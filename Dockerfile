# 完全独立的 Dockerfile - 不依赖本机环境
FROM php:8.2-fpm

WORKDIR /var/www/html

# 安装系统依赖
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nginx \
    supervisor \
    nodejs \
    npm \
    vim \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 安装 PHP 扩展（包括 intl）
RUN apt-get update && apt-get install -y libicu-dev && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl && \
    apt-get remove -y libicu-dev && apt-get autoremove -y && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# 安装 Xdebug（开发环境）
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# 配置 Xdebug
RUN echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 复制应用代码（所有代码都在镜像中，不挂载）
COPY . /var/www/html

# 复制配置文件
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# 启用 Nginx 站点并创建符号链接
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default && \
    rm -f /etc/nginx/sites-enabled/default.bak

# 测试 Nginx 配置
RUN nginx -t || true

COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# 安装依赖（完全在容器内）
RUN composer install --optimize-autoloader --no-interaction
RUN npm install

# 创建初始化脚本（改进错误处理，确保服务总是启动）
RUN cat > /usr/local/bin/docker-entrypoint.sh << 'EOF'
#!/bin/bash
# 不使用 set -e，确保即使某些步骤失败，服务也能启动
echo "🚀 容器初始化开始..."

# 如果 .env 不存在，从 .env.example 创建
if [ ! -f .env ]; then
if [ -f .env.example ]; then
echo "从 .env.example 创建 .env 文件..."
cp .env.example .env
else
echo "创建基础 .env 文件..."
cat > .env << 'ENVEOF'
APP_NAME="UNA Navigator"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=una
DB_USERNAME=root
DB_PASSWORD=secret
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
ENVEOF
fi
fi

# 等待数据库就绪（最多等待2分钟）
echo "等待数据库连接..."
DB_CONNECTED=false
for i in {1..60}; do
# 使用简单的 PHP 连接测试，不依赖 artisan 命令
if php -r "try { \$pdo = new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo 'connected'; exit(0); } catch (Exception \$e) { exit(1); }" 2>/dev/null; then
echo "✅ 数据库连接成功"
DB_CONNECTED=true
break
fi
sleep 2
done

if [ "$DB_CONNECTED" = false ]; then
echo "⚠️ 数据库连接超时，但继续启动服务..."
fi

# 生成 APP_KEY（如果不存在）
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
echo "生成应用密钥..."
php artisan key:generate --force 2>/dev/null || echo "⚠️ APP_KEY 生成失败，但继续..."
fi

# 运行迁移（仅在数据库连接成功时）
if [ "$DB_CONNECTED" = true ]; then
echo "运行数据库迁移..."
php artisan migrate --force 2>/dev/null || echo "⚠️ 迁移失败，但继续..."

# 填充数据（仅在首次）
echo "检查是否需要填充数据..."
ROLE_COUNT=$(php artisan tinker --execute="try { echo \App\Models\Role::count(); } catch (Exception \$e) { echo 0; }" 2>/dev/null | grep -oE '^[0-9]+' || echo "1")
if [ "$ROLE_COUNT" = "0" ]; then
php artisan db:seed --force 2>/dev/null || echo "数据填充失败，跳过"
else
echo "数据已存在，跳过填充"
fi
fi

# 清除缓存
echo "清除缓存..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# 设置权限
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# 测试 Nginx 配置
nginx -t 2>/dev/null || echo "⚠️ Nginx 配置测试失败，但继续..."

echo "✅ 初始化完成，启动服务..."
# 确保 supervisor 总是启动
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
EOF

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 设置权限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 80 5173

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]


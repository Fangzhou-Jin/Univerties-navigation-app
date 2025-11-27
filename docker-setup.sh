#!/bin/bash

# Docker 部署脚本 - UNA Navigator

echo "🚀 开始部署 UNA Navigator 到 Docker..."

# 检查 Docker 是否已安装
if ! command -v docker &> /dev/null; then
    echo "❌ 错误: Docker 未安装，请先安装 Docker"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo "❌ 错误: Docker Compose 未安装，请先安装 Docker Compose"
    exit 1
fi

echo "✅ Docker 和 Docker Compose 已安装"

# 检查 .env 文件
if [ ! -f .env ]; then
    echo "📝 创建 .env 文件..."
    cp .env.example .env
    
    # 生成 APP_KEY
    echo "🔑 生成应用密钥..."
    
    # 临时使用 PHP 生成密钥
    if command -v php &> /dev/null; then
        APP_KEY=$(php -r "echo 'base64:'.base64_encode(random_bytes(32));")
        # 在 macOS 上使用不同的 sed 语法
        if [[ "$OSTYPE" == "darwin"* ]]; then
            sed -i '' "s|APP_KEY=|APP_KEY=$APP_KEY|" .env
        else
            sed -i "s|APP_KEY=|APP_KEY=$APP_KEY|" .env
        fi
        echo "✅ 应用密钥已生成"
    else
        echo "⚠️  警告: PHP 未安装，请手动运行 'php artisan key:generate'"
    fi
else
    echo "✅ .env 文件已存在"
fi

# 停止并删除旧容器
echo "🛑 停止旧容器..."
docker-compose down

# 构建镜像
echo "🔨 构建 Docker 镜像..."
docker-compose build

# 启动容器
echo "▶️  启动容器..."
docker-compose up -d

# 等待数据库启动
echo "⏳ 等待数据库启动 (15秒)..."
sleep 15

# 运行数据库迁移
echo "🗄️  运行数据库迁移..."
docker-compose exec app php artisan migrate --force

# 清除缓存
echo "🧹 清除缓存..."
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

echo ""
echo "✅ 部署完成！"
echo ""
echo "📱 应用访问地址:"
echo "   - 主应用: http://localhost:8000"
echo "   - phpMyAdmin: http://localhost:8080"
echo "   - Mailhog: http://localhost:8025"
echo ""
echo "🔧 常用命令:"
echo "   查看日志: docker-compose logs -f app"
echo "   停止容器: docker-compose down"
echo "   重启容器: docker-compose restart"
echo "   进入容器: docker-compose exec app bash"
echo ""


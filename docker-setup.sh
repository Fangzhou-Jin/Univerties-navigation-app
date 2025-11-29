#!/bin/bash

# ============================================================================
# Docker 部署脚本 - UNA Navigator
# 适用于包含 Google Authenticator 2FA 的完整系统
# ============================================================================

set -e  # 遇到错误立即退出

# 颜色定义
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# 打印带颜色的消息
print_success() { echo -e "${GREEN}✅ $1${NC}"; }
print_error() { echo -e "${RED}❌ $1${NC}"; }
print_warning() { echo -e "${YELLOW}⚠️  $1${NC}"; }
print_info() { echo -e "${BLUE}ℹ️  $1${NC}"; }

echo "🚀 开始部署 UNA Navigator 到 Docker..."
echo ""

# ============================================================================
# 步骤 1: 检查必要的工具
# ============================================================================
print_info "检查必要的工具..."

if ! command -v docker &> /dev/null; then
    print_error "Docker 未安装，请先安装 Docker"
    echo "访问: https://docs.docker.com/get-docker/"
    exit 1
fi

if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    print_error "Docker Compose 未安装，请先安装 Docker Compose"
    exit 1
fi

# 使用 docker compose 或 docker-compose
if docker compose version &> /dev/null 2>&1; then
    DOCKER_COMPOSE="docker compose"
else
    DOCKER_COMPOSE="docker-compose"
fi

print_success "Docker 和 Docker Compose 已安装"

# ============================================================================
# 步骤 2: 检查并创建 .env 文件
# ============================================================================
print_info "检查环境配置文件..."

if [ ! -f .env ]; then
    print_warning ".env 文件不存在，从 .env.example 复制..."
    
    if [ ! -f .env.example ]; then
        print_error ".env.example 文件不存在！"
        exit 1
    fi
    
    cp .env.example .env
    
    # 更新数据库名称为 una
    if [[ "$OSTYPE" == "darwin"* ]]; then
        sed -i '' 's/DB_DATABASE=.*/DB_DATABASE=una/' .env
        sed -i '' 's/CACHE_STORE=.*/CACHE_STORE=file/' .env
        sed -i '' 's/SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
    else
        sed -i 's/DB_DATABASE=.*/DB_DATABASE=una/' .env
        sed -i 's/CACHE_STORE=.*/CACHE_STORE=file/' .env
        sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
    fi
    
    print_success ".env 文件已创建并配置"
else
    print_success ".env 文件已存在"
fi

# 检查并预生成 APP_KEY (在容器启动前)
if ! grep -q "APP_KEY=base64:" .env; then
    print_warning "APP_KEY 未设置，预先生成..."
    
    # 生成一个临时的 APP_KEY
    if command -v php &> /dev/null && php -r "exit(class_exists('Illuminate\Encryption\Encrypter') ? 0 : 1);" 2>/dev/null; then
        # 如果本地有 PHP 和 Laravel，使用本地生成
        php artisan key:generate --force 2>/dev/null || {
            # 如果失败，生成一个随机的 base64 密钥
            RANDOM_KEY=$(openssl rand -base64 32 2>/dev/null || head -c 32 /dev/urandom | base64)
            if [[ "$OSTYPE" == "darwin"* ]]; then
                sed -i '' "s/APP_KEY=.*/APP_KEY=base64:${RANDOM_KEY}/" .env
            else
                sed -i "s/APP_KEY=.*/APP_KEY=base64:${RANDOM_KEY}/" .env
            fi
        }
    else
        # 使用 openssl 生成随机密钥
        if command -v openssl &> /dev/null; then
            RANDOM_KEY=$(openssl rand -base64 32)
            if [[ "$OSTYPE" == "darwin"* ]]; then
                sed -i '' "s/APP_KEY=.*/APP_KEY=base64:${RANDOM_KEY}/" .env
            else
                sed -i "s/APP_KEY=.*/APP_KEY=base64:${RANDOM_KEY}/" .env
            fi
            print_success "已使用 openssl 生成 APP_KEY"
        else
            print_warning "无法预生成 APP_KEY，将在容器启动后生成"
        fi
    fi
fi

# ============================================================================
# 步骤 3: 清理旧容器和数据
# ============================================================================
print_info "清理旧容器..."

$DOCKER_COMPOSE down --volumes 2>/dev/null || true

# 删除旧的容器（如果存在）
docker rm -f una_navigator_app una_navigator_db una_navigator_phpmyadmin una_navigator_mailhog una_navigator_redis 2>/dev/null || true

print_success "旧容器已清理"

# ============================================================================
# 步骤 4: 构建 Docker 镜像
# ============================================================================
print_info "构建 Docker 镜像（这可能需要几分钟）..."

$DOCKER_COMPOSE build --no-cache

print_success "Docker 镜像构建完成"

# ============================================================================
# 步骤 5: 启动 Docker 容器
# ============================================================================
print_info "启动 Docker 容器..."

$DOCKER_COMPOSE up -d

print_success "Docker 容器已启动"

# ============================================================================
# 步骤 6: 等待数据库准备就绪
# ============================================================================
print_info "等待数据库启动..."

max_attempts=30
attempt=0

while [ $attempt -lt $max_attempts ]; do
    if $DOCKER_COMPOSE exec -T db mysqladmin ping -h localhost -uroot -proot &> /dev/null; then
        print_success "数据库已就绪"
        break
    fi
    
    attempt=$((attempt + 1))
    echo -n "."
    sleep 2
done

if [ $attempt -eq $max_attempts ]; then
    print_error "数据库启动超时"
    exit 1
fi

# 额外等待确保数据库完全初始化
sleep 3

# ============================================================================
# 步骤 7: 安装 Composer 依赖
# ============================================================================
print_info "安装 PHP 依赖包..."

$DOCKER_COMPOSE exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader

# 确保 Google2FA 包已安装
if ! $DOCKER_COMPOSE exec -T app composer show pragmarx/google2fa &> /dev/null; then
    print_warning "Google2FA 包未安装，正在安装..."
    $DOCKER_COMPOSE exec -T app composer require pragmarx/google2fa --no-interaction
fi

print_success "Composer 依赖已安装"

# ============================================================================
# 步骤 8: 生成应用密钥
# ============================================================================
print_info "生成应用密钥..."

APP_KEY_GENERATED=false

if ! grep -q "APP_KEY=base64:" .env; then
    $DOCKER_COMPOSE exec -T app php artisan key:generate --force
    APP_KEY_GENERATED=true
    print_success "应用密钥已生成"
else
    print_success "应用密钥已存在"
fi

# 如果生成了新密钥，重启容器以加载新的环境变量
if [ "$APP_KEY_GENERATED" = true ]; then
    print_info "重启应用容器以加载新的 APP_KEY..."
    $DOCKER_COMPOSE restart app
    sleep 3  # 等待容器重启
    print_success "应用容器已重启"
fi

# ============================================================================
# 步骤 9: 运行数据库迁移
# ============================================================================
print_info "运行数据库迁移..."

# 先检查数据库连接
if ! $DOCKER_COMPOSE exec -T app php artisan db:show &> /dev/null; then
    print_error "无法连接到数据库"
    print_info "检查日志: $DOCKER_COMPOSE logs db"
    exit 1
fi

# 运行迁移
$DOCKER_COMPOSE exec -T app php artisan migrate:fresh --force

print_success "数据库迁移完成"

# ============================================================================
# 步骤 10: 填充数据库数据
# ============================================================================
print_info "填充示例数据..."

$DOCKER_COMPOSE exec -T app php artisan db:seed --force

print_success "示例数据已填充"

# ============================================================================
# 步骤 11: 安装前端依赖并构建
# ============================================================================
if [ -f "package.json" ]; then
    print_info "安装前端依赖..."
    
    # 检查 npm 是否可用
    if command -v npm &> /dev/null; then
        npm install
        npm run build
        print_success "前端资源已构建"
    else
        print_warning "npm 未安装，跳过前端构建"
        print_info "如需前端资源，请手动运行: npm install && npm run build"
    fi
fi

# ============================================================================
# 步骤 12: 清除并优化缓存
# ============================================================================
print_info "优化应用..."

$DOCKER_COMPOSE exec -T app php artisan config:clear
$DOCKER_COMPOSE exec -T app php artisan route:clear
$DOCKER_COMPOSE exec -T app php artisan view:clear
$DOCKER_COMPOSE exec -T app php artisan cache:clear

# 生产环境可以启用缓存
# $DOCKER_COMPOSE exec -T app php artisan config:cache
# $DOCKER_COMPOSE exec -T app php artisan route:cache
# $DOCKER_COMPOSE exec -T app php artisan view:cache

print_success "应用优化完成"

# ============================================================================
# 步骤 13: 设置权限
# ============================================================================
print_info "设置文件权限..."

$DOCKER_COMPOSE exec -T app chmod -R 775 storage bootstrap/cache
$DOCKER_COMPOSE exec -T app chown -R www-data:www-data storage bootstrap/cache

print_success "文件权限已设置"

# ============================================================================
# 步骤 14: 验证应用健康状态
# ============================================================================
print_info "验证应用健康状态..."

# 等待应用完全启动
sleep 2

# 检查应用是否能正常响应
if command -v curl &> /dev/null; then
    HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 2>/dev/null || echo "000")
    
    if [ "$HTTP_STATUS" = "200" ]; then
        print_success "应用健康检查通过 (HTTP 200)"
    else
        print_warning "应用返回状态码: $HTTP_STATUS"
        
        if [ "$HTTP_STATUS" = "500" ]; then
            print_error "检测到 500 错误,可能是 APP_KEY 问题,正在尝试修复..."
            
            # 尝试在容器内重新生成密钥
            $DOCKER_COMPOSE exec -T app php artisan key:generate --force
            
            # 重启应用容器
            $DOCKER_COMPOSE restart app
            sleep 3
            
            # 再次检查
            HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 2>/dev/null || echo "000")
            if [ "$HTTP_STATUS" = "200" ]; then
                print_success "修复成功!应用现在正常运行"
            else
                print_error "应用仍有问题,请检查日志: $DOCKER_COMPOSE logs app"
            fi
        fi
    fi
else
    print_warning "curl 未安装,跳过健康检查"
fi

# ============================================================================
# 部署完成
# ============================================================================
echo ""
echo "════════════════════════════════════════════════════════════════"
print_success "部署完成！UNA Navigator 已成功启动"
echo "════════════════════════════════════════════════════════════════"
echo ""

print_info "📱 应用访问地址:"
echo "   ➜ 主应用:       http://localhost:8000"
echo "   ➜ 用户注册:     http://localhost:8000/users/register"
echo "   ➜ 用户登录:     http://localhost:8000/users/login"
echo "   ➜ 管理员登录:   http://localhost:8000/admin-login"
echo "   ➜ phpMyAdmin:   http://localhost:8080"
echo "   ➜ Mailhog:      http://localhost:8025"
echo ""

print_info "🔐 测试账户:"
echo "   管理员: admin@example.com / admin123 (无 2FA)"
echo "   普通用户: user@example.com / user123 (无 2FA)"
echo "   注意: 新注册用户必须设置 Google Authenticator"
echo ""

print_info "📊 数据库信息:"
echo "   数据库名: una"
echo "   用户名: root"
echo "   密码: root"
echo "   端口: 3306"
echo ""

print_info "🔧 常用命令:"
echo "   查看日志:       $DOCKER_COMPOSE logs -f app"
echo "   查看数据库日志: $DOCKER_COMPOSE logs -f db"
echo "   停止容器:       $DOCKER_COMPOSE down"
echo "   重启容器:       $DOCKER_COMPOSE restart"
echo "   进入应用容器:   $DOCKER_COMPOSE exec app bash"
echo "   进入数据库:     $DOCKER_COMPOSE exec db mysql -uroot -proot una"
echo "   重新部署:       ./docker-setup.sh"
echo ""

print_info "📚 项目特性:"
echo "   ✓ 强制 Google Authenticator 两步验证"
echo "   ✓ 完整的大学导航数据库结构"
echo "   ✓ 管理员和普通用户角色分离"
echo "   ✓ RESTful API 接口"
echo "   ✓ Docker 容器化部署"
echo ""

print_warning "首次使用提示:"
echo "   1. 新注册的用户必须设置 Google Authenticator"
echo "   2. 需要在手机上安装 Google Authenticator 应用"
echo "   3. 登录时需要输入 6 位动态验证码"
echo ""

echo "════════════════════════════════════════════════════════════════"
print_success "享受使用 UNA Navigator! 🎉"
echo "════════════════════════════════════════════════════════════════"


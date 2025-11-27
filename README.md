# UNA Navigator

University Navigation App - Laravel + Docker

## 🚀 快速开始

### 前置要求
- Docker Desktop
- Git

### 自动部署（推荐）

```bash
# 克隆项目
git clone <repository-url>
cd SDP_0.1

# 一键部署
./docker-setup.sh
```

### 手动部署

```bash
# 1. 复制环境配置
cp .env.example .env

# 2. 启动 Docker 容器
docker-compose up -d --build

# 3. 生成应用密钥
docker-compose exec app php artisan key:generate

# 4. 等待数据库启动（约15秒）
sleep 15

# 5. 运行数据库迁移
docker-compose exec app php artisan migrate
```

## 🌐 访问地址

- **主应用**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080
- **Mailhog** (邮件测试): http://localhost:8025

## 🔧 常用命令

```bash
# 启动
docker-compose up -d

# 停止
docker-compose down

# 查看日志
docker-compose logs -f app

# 进入容器
docker-compose exec app bash

# 运行迁移
docker-compose exec app php artisan migrate

# 清除缓存
docker-compose exec app php artisan cache:clear
```

## 📊 技术栈

- Laravel 12.x
- PHP 8.2
- MySQL 8.0
- Redis
- Nginx
- Docker

## 👥 团队协作

1. 克隆仓库
2. 运行 `./docker-setup.sh`
3. 开始开发

**注意**: 不要提交 `.env` 文件到 Git！


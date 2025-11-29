# UNA Navigator

Universities Navigation Application - Laravel + Docker

**最新更新**: 数据库结构已根据 `una.sql` 完全重构（2025-11-27）

## 🚀 快速开始

### 前置要求

-   Docker Desktop
-   Git

### 自动部署（推荐）

```bash
# 克隆项目
git clone <repository-url>
cd Univerties-navigation-app-main

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
docker-compose exec app php artisan migrate:fresh

# 6. 填充示例数据（可选）
docker-compose exec app php artisan db:seed
```

## 🌐 访问地址

-   **主应用**: http://localhost:8000
-   **用户登录**: http://localhost:8000/login
-   **管理员登录**: http://localhost:8000/admin-login
-   **phpMyAdmin**: http://localhost:8080
-   **Mailhog** (邮件测试): http://localhost:8025

## 🔐 默认账户

运行 `php artisan db:seed` 后可使用以下测试账户：

**管理员账户**
-   邮箱: `admin@example.com`
-   密码: `admin123`

**普通用户账户**
-   邮箱: `user@example.com`
-   密码: `user123`

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

# 运行迁移（首次或重置数据库）
docker-compose exec app php artisan migrate:fresh

# 填充示例数据
docker-compose exec app php artisan db:seed

# 清除缓存
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
```

## 🚨 故障排查

### 问题 1: "MissingAppKeyException" 错误

**症状**: 访问应用时出现 500 错误，日志显示 "No application encryption key has been specified"

**解决方案**:
```bash
# 方法 1: 在容器内生成密钥并重启
docker-compose exec app php artisan key:generate --force
docker-compose restart app

# 方法 2: 完全重启所有容器
docker-compose down
docker-compose up -d

# 方法 3: 重新运行部署脚本
./docker-setup.sh
```

**预防措施**: 
- 最新版本的 `docker-setup.sh` 已经包含自动检测和修复功能
- 脚本会在容器启动前预生成 APP_KEY
- 部署完成后会自动进行健康检查

### 问题 2: 数据库连接失败

**症状**: "SQLSTATE[HY000] [2002] Connection refused"

**解决方案**:
```bash
# 检查数据库容器状态
docker-compose ps

# 查看数据库日志
docker-compose logs db

# 重启数据库容器
docker-compose restart db

# 等待30秒后重试
sleep 30
docker-compose exec app php artisan migrate
```

### 问题 3: 端口被占用

**症状**: "port is already allocated"

**解决方案**:
```bash
# 查看占用端口的进程
lsof -i :8000  # 应用端口
lsof -i :3306  # MySQL 端口
lsof -i :8080  # phpMyAdmin 端口

# 停止占用端口的进程或修改 docker-compose.yml 中的端口映射
```

### 问题 4: 权限问题 (Linux)

**症状**: "Permission denied" 错误

**解决方案**:
```bash
# 修复存储目录权限
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:$USER storage bootstrap/cache

# 或在容器内修复
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### 问题 5: Windows 用户无法运行脚本

**症状**: 双击 `.sh` 文件无反应或出现错误

**解决方案**:
```bash
# 1. 安装 Git for Windows (包含 Git Bash)
# 下载: https://git-scm.com/download/win

# 2. 使用 Git Bash 运行脚本
bash docker-setup.sh

# 或使用 WSL2 (Windows Subsystem for Linux)
wsl
./docker-setup.sh
```

## 📊 技术栈

-   Laravel 11.x
-   PHP 8.2
-   MySQL 8.0 / MariaDB
-   Redis
-   Nginx
-   Docker

## 📁 数据库结构

本应用包含以下数据表：

1. **roles_una** - 用户角色
2. **universities_una** - 大学信息
3. **buildings_una** - 建筑信息
4. **departments_una** - 院系信息
5. **rooms_una** - 房间信息
6. **room_types_una** - 房间类型
7. **availability_una** - 可用性状态
8. **paths_una** - 房间路径
9. **users_una** - 用户账户

详细信息请查看 [DATABASE_SETUP.md](DATABASE_SETUP.md) 和 [MIGRATION_NOTES.md](MIGRATION_NOTES.md)

## 🔌 API 接口

### 公共接口（需要登录）
-   `GET /api/universities` - 获取所有大学
-   `GET /api/buildings` - 获取所有建筑
-   `GET /api/rooms` - 获取所有房间
-   `GET /api/rooms/search` - 搜索房间
-   `GET /api/paths` - 获取路径信息

### 管理员接口（需要管理员权限）
-   所有资源的增删改操作

## 👥 团队协作

1. 克隆仓库
2. 运行 `./docker-setup.sh`
3. 开始开发

**注意**: 
- 不要提交 `.env` 文件到 Git
- 数据库迁移前请备份重要数据
- 所有表名使用 `_una` 后缀

## 📝 更新日志

### 2025-11-27 - 数据库重构
- ✅ 根据 `una.sql` 完全重建数据库结构
- ✅ 创建 9 个新数据表
- ✅ 重写所有 Model 和 Controller
- ✅ 更新路由和中间件
- ✅ 保留所有前端视图
- ✅ 添加完整的 API 接口

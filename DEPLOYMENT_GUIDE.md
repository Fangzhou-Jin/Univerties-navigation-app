# 部署指南 - UNA Navigator

## 📋 目录
- [快速部署](#快速部署)
- [防止 APP_KEY 错误](#防止-app_key-错误)
- [跨平台部署](#跨平台部署)
- [故障排查](#故障排查)

---

## 🚀 快速部署

### 一键部署（推荐）

```bash
./docker-setup.sh
```

这个脚本会自动：
1. ✅ 检查 Docker 是否安装
2. ✅ 创建并配置 .env 文件
3. ✅ **预生成 APP_KEY**（防止加密错误）
4. ✅ 构建 Docker 镜像
5. ✅ 启动所有容器
6. ✅ 安装依赖
7. ✅ 运行数据库迁移
8. ✅ 填充示例数据
9. ✅ **自动健康检查和故障修复**

---

## 🔐 防止 APP_KEY 错误

### 问题原因

`MissingAppKeyException` 错误发生的原因：
1. Docker Compose 在启动时从 `.env` 文件读取 `APP_KEY`
2. 如果启动时 `.env` 没有 `APP_KEY`，容器会收到空值
3. 即使之后在容器内生成了密钥，容器仍然使用启动时的空值

### 解决方案（已在脚本中实现）

#### 1️⃣ **预生成策略**（步骤 2）
脚本在容器启动**之前**就会检查并生成 APP_KEY：

```bash
# docker-setup.sh 第 82-112 行
if ! grep -q "APP_KEY=base64:" .env; then
    # 使用 openssl 生成随机密钥
    RANDOM_KEY=$(openssl rand -base64 32)
    sed -i "s/APP_KEY=.*/APP_KEY=base64:${RANDOM_KEY}/" .env
fi
```

这确保了 Docker Compose 启动时就能读取到正确的 APP_KEY。

#### 2️⃣ **自动重启策略**（步骤 8）
如果在容器启动后生成了新密钥，脚本会自动重启容器：

```bash
# docker-setup.sh 第 167-176 行
if [ "$APP_KEY_GENERATED" = true ]; then
    print_info "重启应用容器以加载新的 APP_KEY..."
    docker compose restart app
fi
```

#### 3️⃣ **健康检查策略**（步骤 14）
部署完成后自动检查应用是否正常：

```bash
# docker-setup.sh 第 251-283 行
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000)

if [ "$HTTP_STATUS" = "500" ]; then
    # 自动修复
    docker compose exec app php artisan key:generate --force
    docker compose restart app
fi
```

---

## 🌍 跨平台部署

### macOS / Linux

```bash
# 直接运行
./docker-setup.sh

# 或
bash docker-setup.sh
```

### Windows

#### 方法 1: Git Bash（推荐）✅

1. 安装 [Git for Windows](https://git-scm.com/download/win)
2. 右键项目文件夹 → "Git Bash Here"
3. 运行：
```bash
bash docker-setup.sh
```

#### 方法 2: WSL2

1. 启用 WSL2
2. 安装 Ubuntu
3. 在 WSL2 终端中：
```bash
cd /mnt/c/path/to/project
./docker-setup.sh
```

#### 方法 3: PowerShell（如果上述方法不可用）

```powershell
# 手动执行关键步骤
docker-compose up -d --build
docker-compose exec app php artisan key:generate --force
docker-compose restart app
docker-compose exec app php artisan migrate:fresh --seed
```

### 脚本的跨平台兼容性

脚本已经处理了 macOS 和 Linux 的差异：

```bash
# 示例：sed 命令的平台兼容
if [[ "$OSTYPE" == "darwin"* ]]; then
    sed -i '' 's/pattern/replacement/' file  # macOS
else
    sed -i 's/pattern/replacement/' file     # Linux
fi
```

---

## 🚨 故障排查

### 场景 1: 仍然遇到 MissingAppKeyException

**即时修复**:
```bash
docker-compose exec app php artisan key:generate --force
docker-compose restart app
```

**永久修复**:
```bash
# 完全重新部署
docker-compose down
rm .env
./docker-setup.sh
```

### 场景 2: 脚本运行中断

如果脚本在某个步骤中断，可以：

```bash
# 清理并重新开始
docker-compose down --volumes
rm .env
./docker-setup.sh
```

### 场景 3: 健康检查失败

```bash
# 查看详细错误
docker-compose logs app

# 常见解决方案
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose restart app
```

### 场景 4: 数据库连接失败

```bash
# 检查数据库状态
docker-compose ps db

# 等待数据库完全启动
docker-compose exec db mysqladmin ping -h localhost -uroot -proot

# 如果失败，重启数据库
docker-compose restart db
sleep 10
docker-compose exec app php artisan migrate
```

---

## 📊 验证部署成功

### 1. 检查容器状态
```bash
docker-compose ps
```
应该看到所有容器都是 "Up" 状态。

### 2. 检查 APP_KEY
```bash
docker-compose exec app grep "APP_KEY" .env
```
应该看到类似 `APP_KEY=base64:xxxxx` 的输出。

### 3. 访问应用
在浏览器中打开：
- http://localhost:8000 （应该显示欢迎页面）
- http://localhost:8080 （phpMyAdmin）

### 4. 测试登录
使用默认账户登录：
- 管理员: admin@example.com / admin123
- 用户: user@example.com / user123

---

## 🔄 日常操作

### 启动项目
```bash
docker-compose up -d
```

### 停止项目
```bash
docker-compose down
```

### 查看日志
```bash
docker-compose logs -f app
```

### 重置数据库
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

### 进入容器调试
```bash
docker-compose exec app bash
```

---

## 💡 最佳实践

1. **首次部署**: 始终使用 `./docker-setup.sh`
2. **后续启动**: 使用 `docker-compose up -d`
3. **遇到问题**: 先查看日志 `docker-compose logs app`
4. **重大问题**: 重新运行 `./docker-setup.sh`

---

## 📞 获取帮助

如果遇到其他问题：

1. 查看日志:
   ```bash
   docker-compose logs app
   ```

2. 检查环境:
   ```bash
   docker-compose exec app php artisan env
   docker-compose exec app php artisan about
   ```

3. 完全重置:
   ```bash
   docker-compose down --volumes --remove-orphans
   rm -rf storage/logs/*
   ./docker-setup.sh
   ```

---

**最后更新**: 2025-11-27
**版本**: v2.0


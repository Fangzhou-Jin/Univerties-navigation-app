# 快速参考卡片 - UNA Navigator

## 🚀 一键部署
```bash
./docker-setup.sh
```
> 脚本会自动处理所有事情，包括 APP_KEY 生成、容器启动、数据库迁移等

---

## 📱 访问地址
| 服务 | 地址 | 说明 |
|------|------|------|
| 主应用 | http://localhost:8000 | Laravel 应用 |
| 用户注册 | http://localhost:8000/users/register | 新用户注册 |
| 用户登录 | http://localhost:8000/users/login | 用户登录 |
| 管理员登录 | http://localhost:8000/admin-login | 管理员入口 |
| phpMyAdmin | http://localhost:8080 | 数据库管理 |
| Mailhog | http://localhost:8025 | 测试邮件 |

---

## 🔐 测试账户
| 角色 | 邮箱 | 密码 |
|------|------|------|
| 管理员 | admin@example.com | admin123 |
| 普通用户 | user@example.com | user123 |

---

## 🐛 遇到 500 错误？

### 快速修复（1分钟）
```bash
docker-compose exec app php artisan key:generate --force
docker-compose restart app
```

### 完全重置（3分钟）
```bash
docker-compose down
rm .env
./docker-setup.sh
```

---

## 🔧 常用命令速查

### 容器管理
```bash
# 启动
docker-compose up -d

# 停止
docker-compose down

# 重启
docker-compose restart app

# 查看状态
docker-compose ps

# 查看日志
docker-compose logs -f app
```

### Laravel 命令
```bash
# 清除缓存
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear

# 重置数据库
docker-compose exec app php artisan migrate:fresh --seed

# 生成密钥
docker-compose exec app php artisan key:generate --force

# 进入容器
docker-compose exec app bash
```

### 数据库操作
```bash
# 进入 MySQL
docker-compose exec db mysql -uroot -proot una

# 备份数据库
docker-compose exec db mysqldump -uroot -proot una > backup.sql

# 恢复数据库
docker-compose exec -T db mysql -uroot -proot una < backup.sql
```

---

## 🌍 Windows 用户

### 使用 Git Bash（推荐）
1. 安装 Git for Windows
2. 右键项目文件夹 → "Git Bash Here"
3. 运行: `bash docker-setup.sh`

### 使用 WSL2
```bash
cd /mnt/c/path/to/project
./docker-setup.sh
```

---

## 📊 健康检查

### 手动检查应用状态
```bash
curl -I http://localhost:8000
```
✅ 正常: `HTTP/1.1 200 OK`  
❌ 错误: `HTTP/1.1 500 Internal Server Error`

### 检查 APP_KEY
```bash
docker-compose exec app grep "APP_KEY" .env
```
应该看到: `APP_KEY=base64:xxxxx...`

### 检查数据库连接
```bash
docker-compose exec app php artisan db:show
```

---

## 🆘 紧急救援

### 容器无法启动
```bash
docker-compose down --volumes
docker-compose up -d --build
```

### 端口被占用
```bash
# 查看占用端口的进程
lsof -i :8000
lsof -i :3306

# 修改 docker-compose.yml 中的端口映射
```

### 权限问题 (Linux)
```bash
sudo chown -R $USER:$USER .
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

---

## 📚 详细文档

- **完整部署指南**: [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)
- **更新日志**: [CHANGELOG.md](CHANGELOG.md)
- **项目说明**: [README.md](README.md)

---

## 💡 最佳实践

1. ✅ 首次部署使用 `./docker-setup.sh`
2. ✅ 日常启动使用 `docker-compose up -d`
3. ✅ 定期备份数据库
4. ✅ 不要提交 `.env` 文件到 Git
5. ✅ 遇到问题先查看日志

---

## 🎯 三重防护机制

| 防护层 | 说明 | 自动执行 |
|--------|------|----------|
| 🛡️ 预生成 | 容器启动前生成 APP_KEY | ✅ |
| 🔄 智能重启 | 新密钥生成后自动重启 | ✅ |
| 🏥 健康检查 | 部署后验证并自动修复 | ✅ |

---

**最后更新**: 2025-11-27  
**版本**: 2.0.0

---

### 需要帮助？

遇到问题请：
1. 查看日志: `docker-compose logs app`
2. 阅读故障排查: [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)
3. 尝试完全重置: `docker-compose down && ./docker-setup.sh`


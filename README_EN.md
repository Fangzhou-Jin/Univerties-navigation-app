# UNA Navigator

University Navigation App - Laravel + Docker

## 🚀 Quick Start

### Prerequisites
- Docker Desktop
- Git

### Automatic Deployment (Recommended)

```bash
# Clone the project
git clone <repository-url>
cd SDP_0.1

# One-click deployment
./docker-setup.sh
```

### Manual Deployment

```bash
# 1. Copy environment configuration
cp .env.example .env

# 2. Start Docker containers
docker-compose up -d --build

# 3. Generate application key
docker-compose exec app php artisan key:generate

# 4. Wait for database to start (about 15 seconds)
sleep 15

# 5. Run database migrations
docker-compose exec app php artisan migrate
```

## 🌐 Access URLs

- **Main Application**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080
- **Mailhog** (Email Testing): http://localhost:8025

## 🔧 Common Commands

```bash
# Start
docker-compose up -d

# Stop
docker-compose down

# View logs
docker-compose logs -f app

# Enter container
docker-compose exec app bash

# Run migrations
docker-compose exec app php artisan migrate

# Clear cache
docker-compose exec app php artisan cache:clear
```

## 📊 Tech Stack

- Laravel 12.x
- PHP 8.2
- MySQL 8.0
- Redis
- Nginx
- Docker

## 👥 Team Collaboration

1. Clone the repository
2. Run `./docker-setup.sh`
3. Start developing

**Note**: Do NOT commit the `.env` file to Git!


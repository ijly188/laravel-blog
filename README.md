# 七盞茶Web&App後台 & Restful APIs

建立laravel-blog & Restful APIs，透過 laravel 7 框架開發

## Getting Started
```
git clone https://github.com/ijly188/laravel-blog.git
```

```
composer install
```

```
cp .env.example .env
```

```
php artisan key:generate
```

```
composer dump-autoload
```

```
php artisan cache:clear
```

```
php artisan route:clear
```

```
php artisan config:clear
```

```
php artisan view:clear
```

```
php artisan db:seed
```

### 設定 .env 資訊

依據 local 系統配置 進行設置

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:6SYshYY5VNL7S4brox+FWQJfy+mm+4r5qXcDvodVOYc=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

JWT_SECRET=
JWT_TTL=
```
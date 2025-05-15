# News Portal

A modern news aggregator portal with user authentication and Telegram verification, built with Laravel and Vue.js.


## Tech Stack

- Backend: Laravel (PHP)
- Frontend: Vue.js 3 + Inertia.js
- Styling: Tailwind CSS
- Database: MySQL
- Message Queue: RabbitMQ
- Authentication: Laravel Sanctum
- Icons: Lucide Icons

## Requirements

- PHP >= 8.1
- MySQL >= 8.0
- Node.js >= 16
- Nginx
- PHP-FPM
- RabbitMQ
- Composer
- Git

## Installation

1. Clone the repository

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your environment variables in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_portal
DB_USERNAME=root
DB_PASSWORD=

TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHANNEL_ID=your_channel_id

RABBITMQ_HOST=localhost
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_VHOST=/

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_ID}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"

TELEGRAM_BOT_TOKEN="KEY"
TELEGRAM_CHANNEL="ID"
GNEWS_API_KEY="KEY"
```

7. Run migrations:
```bash
php artisan migrate
```

8. Build frontend assets:
```bash
npm run build
```

9. Start the queue worker:
```bash
php artisan queue:work
```

10. Start the scheduler:
```bash
php artisan schedule:work
```

## Development

1. Start the development server:
```bash
php artisan serve
```

2. Start Vite development server:
```bash
npm run dev
```

## Telegram Bot Setup

1. Create a new bot using [@BotFather](https://t.me/botfather)
2. Create a new channel and add your bot as an administrator
3. Get the channel ID and add it to your `.env` file
4. Add the bot token to your `.env` file

## Web Routes
| URI                         | Description |
|-----------------------------|-------------|
| `/register`                 | Show user registration form |
| `/login`                    | Show user login form |
| `/settings/profile`         | Show user profile (authenticated) |
| `/dashboard`                | Show all news articles |
| `/news/{id}`                | Show a specific news article |
| `/admin`                    | Admin dashboard |

#!/bin/sh

# Copy .env.example to .env if .env does not exist
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate application key
php artisan key:generate

# Update environment variables
if [ -n "$APP_ENV" ]; then
    sed -i "s/APP_ENV=.*/APP_ENV=$APP_ENV/" .env
fi

if [ -n "$APP_DEBUG" ]; then
    sed -i "s/APP_DEBUG=.*/APP_DEBUG=$APP_DEBUG/" .env
fi

if [ -n "$DB_HOST" ]; then
    sed -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/" .env
fi

if [ -n "$DB_DATABASE" ]; then
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/" .env
fi

if [ -n "$DB_USERNAME" ]; then
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USERNAME/" .env
fi

if [ -n "$DB_PASSWORD" ]; then
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env
fi

php artisan optimize

# Run build npm packages
npm install
npm run build

# Run migrations and seed the database
php artisan migrate --seed

php artisan optimize

# Start PHP-FPM
php-fpm

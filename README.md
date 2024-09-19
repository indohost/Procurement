# Procurement - Laravel Project

## Overview

This project is a Laravel 10 application that includes authentication and uses UUIDs as primary keys for the database models.

## Prerequisites

-   PHP >= 8.1
-   Composer
-   Laravel 10
-   MariaDB or any other compatible database

## Installation

### 1. Clone the repository

```bash
git https://github.com/indohost/Procurement.git
cd procurement
```

### 2. Install dependencies

```bash
composer install

npm install && npm run build
```

### 3. Environment setup

```bash
cp .env.example .env

php artisan key:generate
```

### 4. Set up the database

```bash
php artisan migrate
```

### Penjelasan Tambahan

-   **UUID**: UUID (Universally Unique Identifier) digunakan sebagai primary key untuk model. Ini berguna untuk memastikan keunikan global dan menghindari konflik ID di lingkungan multi-server atau distribusi.

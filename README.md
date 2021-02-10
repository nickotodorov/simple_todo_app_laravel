# Simple ToDo application
Simple ToDo application for interview purposes

## System Requirements

- PHP 7.4.*
- MySQL 8+ 

## Project Setup

- Create local database and configure virtual host for the  project.
- Execute the following commands in project root directory:

```
$ composer update
$ cp .env.example .env
```

- In the .env file you need to change the database settings, according to your configuration.
- Generate application key using the following command:

```
php artisan key:generate
```

- Execute the migrations:

```bash
php artisan migrate
```
- Execute the seeders to fill the database with some predefined records:

```bash
php artisan db:seed
```

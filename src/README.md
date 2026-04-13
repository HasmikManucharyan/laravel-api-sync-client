# Laravel API Sync Client

## Description

This project is a Laravel application that synchronizes data from an external API into a local MySQL database.

It supports the following entities:
- Sales
- Orders
- Stocks
- Incomes

Data is fetched from a paginated API and stored using upsert to avoid duplicates.

## Tech Stack

- PHP 8.1
- Laravel 8
- MySQL 8
- Docker / Docker Compose

## Installation

Clone project:
git clone <repo-url>
cd <project-folder>

Copy .env file:
cp .env.example .env

Configure .env:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...

DB_CONNECTION=mysql
DB_HOST=laravel_db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

API_BASE_URL=http://109.73.206.144:6969
API_KEY=your-api-key

Start Docker:
docker-compose up -d --build

Install dependencies:
docker exec -it laravel_app composer install

Run migrations:
docker exec -it laravel_app php artisan migrate

## Data Sync

Orders sync:
docker exec -it laravel_app php artisan sync:orders 2026-04-01 2026-04-10

## How it works

Data is fetched from external API  
Pagination is handled automatically (page & limit = 500)  
Data is cleaned and transformed  
Duplicates are removed using external_id  
Data is stored using upsert

## API Requirements

Authorization via query parameter key  
Date format Y-m-d  
Pagination page, limit (max 500)

Example:
/api/orders?dateFrom=2026-04-01&dateTo=2026-04-10&page=1&limit=500&key=XXX

## Database

Primary key id  
Unique key external_id

## Docker Services

laravel_app  
laravel_db  
laravel_nginx

## Notes

API key must be set in .env  
Pagination is required for full data sync  
Upsert is used to avoid duplicates

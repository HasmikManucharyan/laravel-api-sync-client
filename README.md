# Laravel API Sync Client

## Description

This project is a Laravel application that synchronizes data from an external API into a local MySQL database.

It supports the following entities:
- Sales
- Orders
- Stocks
- Incomes

Data is fetched from a paginated API and stored using upsert to avoid duplicates.

The project is designed with a layered architecture (API Client → Service Layer → Command Layer).

---

## Tech Stack

- PHP 8.1
- Laravel 8
- MySQL 8
- Docker / Docker Compose

---

## Installation

Clone project:  
git clone https://github.com/HasmikManucharyan/laravel-api-sync-client.git  
cd laravel-api-sync-client  

Copy environment file:  
cp .env.example .env  

---

## Environment Configuration

The project supports two environments:

- Local (Docker)
- Production (Remote MySQL - Railway or other provider)

---

### Local Setup (Docker)

    DB_CONNECTION=mysql
    DB_HOST=laravel_db
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=root
    
    API_BASE_URL=http://109.73.206.144:6969
    API_KEY=your-api-key

---

### Production Setup (Remote Database)

    DB_CONNECTION=mysql
    DB_HOST=YOUR_REMOTE_HOST
    DB_PORT=YOUR_PORT
    DB_DATABASE=YOUR_DATABASE
    DB_USERNAME=YOUR_USERNAME
    DB_PASSWORD=YOUR_PASSWORD

---

## Database Access

Production database credentials are provided separately to reviewers upon request.

---

## Switching Environments

To switch environment:
- Update .env file
- Run:

php artisan config:clear

---

## Run Project with Docker

docker-compose up -d --build

---

## Install Dependencies

docker exec -it laravel_app composer install

---

## Run Migrations

docker exec -it laravel_app php artisan migrate

---

## Data Sync

docker exec -it laravel_app php artisan sync:orders 2026-04-01 2026-04-10

---

## How it works

- Data is fetched from external API
- Pagination is handled automatically (page & limit = 500)
- Data is cleaned and transformed in Service Layer
- Duplicates are removed using external_id
- Data is stored using upsert

---

## API Requirements

- Authorization via query parameter key
- Date format: Y-m-d
- Pagination: page, limit (max 500)

Example:
/api/orders?dateFrom=2026-04-01&dateTo=2026-04-10&page=1&limit=500&key=XXX

---

## Database Structure

- Primary key: id
- Unique key: external_id

---

## Docker Services

- laravel_app
- laravel_db
- laravel_nginx

---

## Architecture

- API Client → External API communication
- Service Layer → Business logic and transformation
- Command Layer → Artisan entry point for sync

---

## Notes

- API key must be set in .env
- Pagination is required for full synchronization
- Upsert is used to prevent duplicates
- Project is ready for scaling and adding queues or multiple APIs

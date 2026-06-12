# Local Setup Guide

Follow these sequential steps to run this Laravel + Vue project on your local machine.

## Prerequisites
Ensure you have **PHP**, **Composer**, and **MySQL** installed.

---

## Installation Steps

1. **Clone the repository and enter the directory:**
   ```bash
   git clone https://github.com/finnleygrange/order-note-board.git
   cd order-note-board
2. **Install PHP dependencies:**
   ```bash
   composer install
   ```
3. **Set up your environment configuration:**
   ```bash
   cp .env.example .env
4. **Generate the application security key:**
   ```bash
   php artisan key:generate
5. **Run database migrations to build the tables:**
   ```bash
   php artisan migrate

---

## Running the Server

**Start the built-in PHP development server by running:**
   ```bash
   php artisan serve
   ```
Once running, open your browser and navigate to:
http://127.0.0.1:8001
   

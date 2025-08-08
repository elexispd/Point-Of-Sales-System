# Point-Of-Sales-System API

A **Point of Sales (POS)** and **Inventory Management API** built with **PHP**.  
This API is designed for a web-based POS application, providing secure and efficient endpoints for managing products, sales, inventory, and authentication using **JWT (JSON Web Token)**.

---

## Features

- **JWT Authentication**
  - Secure login and registration
  - Token-based authentication for protected endpoints
- **User Management**
  - Create and manage admin and cashier accounts
  - Role-based access control
- **Product Management**
  - Add, edit, delete, and view products
  - Category support
  - Stock tracking
- **Sales Management**
  - Process sales transactions
  - Generate receipts
  - Track daily, weekly, and monthly sales
- **Inventory Management**
  - View stock levels
  - Automatic stock deduction after sales
  - Low-stock alerts
- **Reporting**
  - Sales reports by date range
  - Inventory summary

---

## Technologies Used

- **Language:** PHP (>=7.4)
- **Authentication:** JSON Web Token (JWT)
- **Database:** MySQL
- **Web Server:** Apache / Nginx
- **Dependencies:**
  - [`firebase/php-jwt`](https://github.com/firebase/php-jwt) – JWT implementation for PHP

---

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/elexispd/point-of-sales-system.git
   cd point-of-sales-system
composer install

create .env
DB_HOST=localhost
DB_NAME=pos_db
DB_USER=root
DB_PASS=
JWT_SECRET=your_secret_key
JWT_ISSUER=http://localhost

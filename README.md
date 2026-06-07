# Toko Online - Laravel E-commerce Platform

Modern, full-featured e-commerce platform built with Laravel 11, Filament v3, and Tailwind CSS.

## Features

### Customer Features
- Product Catalog — Browse products by category with search and filters
- Shopping Cart — Session-based cart with real-time updates
- Checkout Flow — Multi-step checkout with address, shipping, and payment
- Shipping Calculator — Real-time shipping cost via RajaOngkir API (JNE, POS, TIKI)
- Dual Payment System:
  - Midtrans — Automated payment gateway (credit card, e-wallet, bank transfer)
  - Manual Transfer — Upload receipt for manual verification
- Order Tracking — View order history and status
- Modern UI — Clean, responsive design with Tailwind CSS

### Admin Features (Filament Panel)
- Dashboard — Order statistics and insights
- Category Management — Create and manage product categories
- Product Management — Full CRUD with image upload, stock tracking
- Order Management — View, process, and update order status
- Payment Settings — Toggle Midtrans/Manual Transfer on/off
- Customer Management — View customer orders and details
- Payment Confirmation — Review and approve manual transfer receipts

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 11 |
| Admin Panel | Filament v3 |
| Database | MySQL 8 |
| Frontend | Blade + Tailwind CSS + Alpine.js |
| Auth | Laravel Breeze |
| Payment Gateway | Midtrans (Sandbox) |
| Shipping API | RajaOngkir |
| Image Upload | Spatie Media Library |

## Installation

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & NPM

### Setup Steps

1. **Navigate to the project**
   ```bash
   cd /Applications/XAMPP/xamppfiles/htdocs/ecommerce/toko-online
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure `.env`** — Add your credentials:
   ```env
   DB_CONNECTION=mysql
   DB_DATABASE=toko_online
   DB_USERNAME=root
   DB_PASSWORD=

   # Midtrans (Sandbox)
   MIDTRANS_SERVER_KEY=your-sandbox-server-key
   MIDTRANS_CLIENT_KEY=your-sandbox-client-key
   MIDTRANS_IS_PRODUCTION=false

   # RajaOngkir
   RAJAONGKIR_API_KEY=your-rajaongkir-api-key
   RAJAONGKIR_ORIGIN_CITY_ID=501
   ```

4. **Run migrations and seed data**
   ```bash
   php artisan migrate --seed
   ```

5. **Create storage link**
   ```bash
   php artisan storage:link
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

## Default Credentials

### Admin Panel
- URL: `http://localhost:8000/webadmin/login`
- Email: `adminwebsite@websiaponline.com`
- Password: `Passw@rdku`

### Test Customer
- Register a new account at `/register`

## API Keys Setup

### Midtrans (Sandbox)
1. Register at https://dashboard.sandbox.midtrans.com/
2. Get Server Key and Client Key from Settings → Access Keys
3. Update `.env` with your keys

### RajaOngkir
1. Register at https://rajaongkir.com/
2. Get API Key from dashboard
3. Update `.env` with your key

## Usage Guide

### Customer Flow
1. Browse Products — Visit homepage or `/products`
2. Add to Cart — Click "Add to Cart" on any product
3. Checkout — Click cart icon → "Checkout"
4. Enter Address — Fill shipping address form
5. Select Shipping — Choose courier and service (costs calculated via RajaOngkir)
6. Choose Payment:
   - Midtrans: Redirected to Midtrans Snap page
   - Manual Transfer: Upload receipt after transfer
7. Track Order — View order status in "My Orders"

### Admin Flow
1. Login at `/webadmin/login` with admin credentials
2. Manage Products — Add/edit products with images
3. Process Orders — View orders, confirm payments, update status
4. Payment Settings — Toggle payment methods on/off
5. Confirm Manual Payments — Review receipts and approve

## Database Schema

- `users` — Customer accounts
- `categories` — Product categories
- `products` — Product catalog with stock tracking
- `orders` — Order records
- `order_items` — Order line items
- `provinces`, `cities` — Shipping locations
- `payment_settings` — Payment method toggles

## Sample Data

The seeder creates:
- **6 categories**: Fashion Pria, Fashion Wanita, Elektronik, Rumah Tangga, Olahraga, Kecantikan
- **15 products** across all categories
- **8 provinces** and **15 cities** for shipping
- **Payment settings** with both methods enabled# wso-onlineshop

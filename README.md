# Stock Commerce (Next.js 16 + Laravel 12)

A full-stack ecommerce starter split into:

- `frontend/` → Next.js 16 storefront (React 19 + TypeScript)
- `backend/` → Laravel 12 API + Admin dashboard + POS

## Features

- Product listing UI rendered by Next.js App Router.
- Laravel API endpoints:
  - `GET /api/products`
  - `GET /api/categories`
  - `POST /api/orders`
- Admin dashboard to manage ecommerce operations:
  - KPI cards (products, categories, orders, revenue, managers)
  - recent order list
  - low-stock product alerts
- Shop manager module:
  - add manager
  - activate/deactivate manager
- POS module:
  - manager ভিত্তিক checkout
  - inventory auto decrement
  - paid order creation
- Product management (create/delete).
- Database schema + seeder for categories, products, managers, and orders.
- CORS configured so Next.js can call Laravel locally.

## Local setup

### 1) Backend (Laravel 12)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
mkdir -p database && touch database/database.sqlite
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```

Admin URLs:
- `http://localhost:8000/admin`
- `http://localhost:8000/admin/products`
- `http://localhost:8000/admin/managers`
- `http://localhost:8000/admin/pos`

### 2) Frontend (Next.js 16)

```bash
cd frontend
npm install
cp .env.local.example .env.local
npm run dev
```

`frontend/.env.local`:

```env
NEXT_PUBLIC_API_BASE_URL=http://localhost:8000/api
```

Then open `http://localhost:3000`.

## Suggested next steps

- Add authentication/authorization for admin routes (manager login and roles).
- Add receipt printing + barcode scanner for POS.
- Persist inventory transactions and order status history.
- Add checkout with Stripe for online orders.

## Project ZIP export

If you need a distributable archive:

```bash
cd ..
zip -r stock-commerce.zip stock
```

The archive can then be shared as `stock-commerce.zip` (in this environment, use `sandbox:/workspace/stock-commerce.zip` as the clickable download URI).

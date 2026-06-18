# 🛒 E-Commerce Store — Laravel Project

A full-featured e-commerce web application built with **Laravel 12**, featuring a complete shopping experience, admin panel, REST APIs, and **Face Recognition Login**!

---

## 📸 Project Overview

This project is a complete e-commerce store where users can browse products, search, add to cart, place orders, and track their order history. Admins can manage products, categories, orders, and users through a dedicated admin panel. The project also includes REST APIs with token authentication and a unique **Face Recognition login system** for admins.

---

## ✨ Features

### 👤 User Side
- User Registration & Login
- Forgot Password (Gmail SMTP email)
- User Profile Page (update name, email, password)
- Browse Products with Category Filter
- 🔍 Search Products by Name
- Product Detail Page
- Add to Cart / Remove from Cart
- Cart Item Count in Navbar
- Place Orders
- View Order History with Status

### 👨‍💼 Admin Panel
- Admin Dashboard (stats overview)
- Manage Products (Add / Edit / Delete with Image Upload)
- Manage Categories (Add / Edit / Delete)
- Manage Orders (View all + Update Status)
- View All Users
- 📷 Face Recognition Setup & Login

### 🔌 REST APIs
- `GET /api/products` — Get all products
- `GET /api/products/{id}` — Get single product
- `GET /api/categories` — Get all categories
- `POST /api/register` — Register new user (returns token)
- `POST /api/login` — Login user (returns token)
- `GET /api/user` — Get logged in user info (protected)
- `POST /api/logout` — Logout user (protected)

### 📷 Face Recognition
- Admin can register their face (one time setup)
- Login using face scan instead of password
- Uses face-api.js for real time face detection
- Euclidean distance algorithm for face matching
- Face data stored securely in database

---

## 🛠️ Tech Stack

| Technology | Usage |
|---|---|
| Laravel 12 | Backend Framework |
| PHP 8.2 | Programming Language |
| MySQL | Database |
| Bootstrap 5 | Frontend Styling |
| Laravel Sanctum | API Authentication |
| face-api.js | Face Recognition |
| XAMPP | Local Development Server |
| Postman | API Testing |

---

## 🗄️ Database Structure

| Table | Description |
|---|---|
| `users` | Registered users (role: user/admin, face_descriptor) |
| `categories` | Product categories |
| `products` | Products with image, price, stock |
| `orders` | User orders with status |
| `order_items` | Individual items inside each order |
| `personal_access_tokens` | API tokens (Sanctum) |

---

## ⚙️ Installation & Setup

### **Requirements**
- PHP 8.2+
- Composer
- MySQL
- Node.js & npm
- XAMPP (or any local server)

---

### **Step 1: Clone the Repository**
```bash
git clone https://github.com/khanjee56/e-Commerce-Store.git
cd e-Commerce-Store
```

### **Step 2: Install Dependencies**
```bash
composer install
npm install
npm run build
```

### **Step 3: Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

### **Step 4: Configure Database**
Open `.env` and update:
```env
DB_DATABASE=ecommerce_store
DB_USERNAME=root
DB_PASSWORD=
```

### **Step 5: Configure Gmail (Forgot Password)**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youremail@gmail.com
MAIL_FROM_NAME="MyStore"
```

### **Step 6: Run Migrations & Seed Data**
```bash
php artisan migrate:fresh --seed
```

### **Step 7: Create Storage Link**
```bash
php artisan storage:link
```

### **Step 8: Run the Project**
```bash
php artisan serve
```

Open browser → `http://localhost:8000`

---

## 👨‍💼 Admin Access

After running seeder, manually set your user role to `admin` in database:

```sql
UPDATE users SET role = 'admin' WHERE id = 1;
```

Then login and access admin panel at `/admin/dashboard`

---

## 📷 Face Recognition Setup

1. Login as admin
2. Go to Admin Dashboard
3. Click **"📷 Setup Face Recognition"**
4. Allow camera access
5. Position face clearly in camera
6. Click **"📸 Save My Face"**
7. Done! Now login at `/face-login` using your face!

---

## 🔌 API Testing with Postman

### **Register**
```
POST http://localhost:8000/api/register
Headers: Accept: application/json
Body (JSON):
{
    "name": "Test User",
    "email": "test@gmail.com",
    "password": "123456",
    "password_confirmation": "123456"
}
```

### **Login**
```
POST http://localhost:8000/api/login
Headers: Accept: application/json
Body (JSON):
{
    "email": "test@gmail.com",
    "password": "123456"
}
```

### **Protected Routes**
Add header to every protected request:
```
Authorization: Bearer {your_token_here}
Accept: application/json
```

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── OrderController.php
│   │   ├── AdminController.php
│   │   └── Api/
│   │       ├── AuthApiController.php
│   │       └── ProductApiController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── User.php
│   ├── Product.php
│   ├── Category.php
│   ├── Order.php
│   └── OrderItem.php
database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    └── ProductSeeder.php
routes/
├── web.php
└── api.php
resources/views/
├── layouts/
├── admin/
│   ├── dashboard.blade.php
│   ├── face-setup.blade.php
│   ├── products/
│   ├── categories/
│   ├── orders/
│   └── users/
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── face-login.blade.php
├── products/
├── cart/
├── orders/
└── profile.blade.php
public/
└── models/ (face-api.js models)
```

---

## 🔄 Daily Git Workflow

```bash
# Before starting work
git pull

# After finishing work
git add .
git commit -m "describe what you did"
git push
```

---

## 👨‍💻 Developer

**Haris Khan**
- GitHub: [@khanjee56](https://github.com/khanjee56)
- Project: BS Computer Science Student

---

## 📄 License

This project is open source and available for learning purposes.

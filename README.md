# 🚀 TaskNest Backend (Laravel API)

API حرفه‌ای برای سیستم مدیریت وظایف با Laravel 12 و Sanctum.

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## ✨ امکانات

- 🔐 احراز هویت با Sanctum (ثبت‌نام، ورود، خروج)
- ✅ CRUD کامل وظایف
- 📝 زیر وظایف (Subtasks)
- 🎯 اولویت‌بندی (کم، متوسط، زیاد)
- 📊 وضعیت وظایف
- 📅 تاریخ سررسید
- 🔍 جستجو و فیلتر
- 📈 آمار وظایف

## 🛠 تکنولوژی‌ها

- Laravel 12
- PHP 8.3
- Sanctum
- SQLite / MySQL
- Eloquent ORM

## 🚀 نصب و راه‌اندازی

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

ثبت‌نام
bash
curl -X POST http://localhost:8000/api/v1/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "محسن",
    "email": "mohsen@test.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
پاسخ:

json
{
  "success": true,
  "message": "ثبت‌نام با موفقیت انجام شد.",
  "user": { "id": 1, "name": "محسن", "email": "mohsen@test.com" },
  "token": "1|abc123xyz..."
}
ورود
bash
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "mohsen@test.com",
    "password": "password123"
  }'
ایجاد وظیفه
bash
curl -X POST http://localhost:8000/api/v1/tasks \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "title": "طراحی صفحه اصلی",
    "priority": "high",
    "subtasks": ["طراحی هدر", "طراحی فوتر"]
  }'
لیست وظایف با فیلتر
bash
curl -X GET "http://localhost:8000/api/v1/tasks?status=pending&priority=high&search=طراحی" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

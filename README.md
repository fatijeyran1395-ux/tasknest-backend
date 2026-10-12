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

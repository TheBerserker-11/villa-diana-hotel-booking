
🏨 Villa Diana Hotel Booking System

A full-stack Laravel 10 web application designed for Villa Diana Hotel that allows customers to explore rooms, check availability, book online, and enables administrators to manage hotel operations through a powerful admin dashboard.

This project was developed as a Capstone Project.

✨ Key Highlights

Secure OTP Email Registration

Smart Booking Flow with Redirect Persistence

Admin-only Dashboard & Role Protection

Real-time Room Availability Checking

Booking & Revenue Reports

Virtual Room Tour Integration

Modern Responsive UI

👨‍💻 Technology Stack
Layer	Tech
Backend	Laravel 10 (PHP)
Frontend	Blade, Bootstrap, JavaScript
Database	MySQL
Email	Laravel Mail (OTP verification)
Authentication	Laravel Auth + Custom OTP
Reports	Laravel + Admin Dashboard
🔐 Authentication Flow

Customer Registration:

Register → Send OTP → Verify OTP → Set Password → Login → Continue Booking

Smart redirect:
If a user logs in or registers while booking, they are automatically returned to the booking summary.

👤 Customer Features

Create account with Email OTP verification

Browse rooms with availability filtering

Booking summary & reservation system

Virtual room tour support

My Bookings dashboard

Profile management

Password reset via email

🛠️ Admin Features

Admins NEVER see customer pages.

Admin panel includes:

Dashboard analytics

Booking management

Room & Room Type CRUD

Event management

Customer management

Revenue & occupancy reports

Export reports to PDF

🧩 System Architecture
🏗️ High Level Architecture

This system follows a 3-Layer Web Architecture

Presentation Layer (Browser)

Application Layer (Laravel Backend)

Data Layer (MySQL Database)

                ┌──────────────────────────┐
                │        CLIENT SIDE       │
                │  Browser / Mobile User   │
                └────────────┬─────────────┘
                             │ HTTP Request
                             ▼
                ┌──────────────────────────┐
                │     LARAVEL WEB SERVER   │
                │  Routes + Middleware     │
                └────────────┬─────────────┘
                             │
        ┌────────────────────┼────────────────────┐
        ▼                    ▼                    ▼
┌──────────────┐   ┌────────────────┐   ┌────────────────┐
│ Auth System  │   │ Booking Module │   │ Admin Panel    │
│ OTP + Login  │   │ Orders/Rooms   │   │ Reports/CRUD   │
└──────┬───────┘   └────────┬───────┘   └────────┬───────┘
       │                     │                    │
       └──────────────┬──────┴──────────────┬────┘
                      ▼                     ▼
              ┌─────────────────────────────────┐
              │          MySQL Database         │
              │ Users • Rooms • Orders • Reviews│
              └─────────────────────────────────┘
🔄 Booking Flow Architecture
Guest User
   │
   ▼
Browse Rooms → Select Dates → Booking Summary
   │
   ├─ Not logged in?
   │        │
   │        ▼
   │   Login / Register (OTP)
   │        │
   │        ▼
   └──── Redirect back to Booking Summary
            │
            ▼
       Proceed to Payment (GCash Modal)
            │
            ▼
        Booking Stored in Database
            │
            ▼
      User sees booking in My Bookings
🔐 Authentication Architecture
Register Form
     │
     ▼
Send OTP (Email)
     │
     ▼
Verify OTP
     │
     ▼
Create Password
     │
     ▼
Auto Login → Continue Booking

Security features:

Rate-limited OTP sending

Session-based verification

Redirect persistence

Role-based access control

🛡️ Admin Security Architecture
Login → Check Role
        │
        ├── is_admin = 1 → /admin dashboard
        │
        └── is_admin = 0 → User Home

Middleware Protection:
• IsAdmin.php
• RedirectAdminToDashboard.php

Admins cannot access customer pages and customers cannot access admin routes.

🗄️ Database Core Entities

Main tables used:

users

rooms

room_types

orders (bookings)

reviews

events

Relationship overview:

User 1 ────< Orders >──── 1 Room
RoomType 1 ────< Rooms
User 1 ────< Reviews
📡 External Services
Service	Purpose
SMTP Mail	Send OTP & Password Reset Emails
GCash (UI Modal)	Payment interface
Kuula	Virtual Room Tour

🚀 Installation Guide

Clone repository:

git clone https://github.com/YOUR_USERNAME/villa-diana-hotel.git
cd villa-diana-hotel

Install dependencies:

composer install
cp .env.example .env
php artisan key:generate

Configure database inside .env

Run migrations:

php artisan migrate --seed
php artisan serve

Open app:


📸 Screenshots



Home Page

Booking Summary

OTP Verification

Admin Dashboard

Reports

📚 Academic Information

Capstone Project Title:
Hotel Booking System with Web-Based Virtual Tour

Initial Deployment Target:
Villa Diana Hotel

📄 License

This project is for academic and demonstration purposes.

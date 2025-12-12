# 📞 StandaloneCoders Telecaller SaaS Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/TailwindCSS-3.3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" />
</p>

---

## 🚀 **Complete Telecaller SaaS Platform**

A **production-ready** Telecaller SaaS platform with complete dashboard system, mobile API integration, advanced RBAC hierarchy, and auto-dialer functionality. Perfect for telemarketing companies, sales teams, and call centers.

### 🎯 **Core Features**

#### **🏢 4-Level Role-Based Access Control (RBAC)**
- **Super Admin** → Platform-wide management
- **Admin** → Company-level management  
- **Manager** → Team-level management
- **Agent** → Self-access with auto-dialer

#### **📱 Mobile API Integration**
- Complete REST API for Android/iOS apps
- Device binding and management
- Real-time synchronization
- JWT authentication with device control

#### **🤖 Auto Dialer System**
- Android device integration with SIM cards
- Automated calling with lead progression
- Call disposition tracking (Interested, Not Interested, Callback, etc.)
- Real-time call timer and duration logging
- Agent-specific dialer management

#### **📊 Advanced Analytics & Reporting**
- Role-based dashboards
- Real-time call statistics
- Lead conversion tracking
- Performance metrics and insights

#### **💰 Subscription Management**
- Multiple pricing tiers (₹2,499, ₹6,699, ₹16,699)
- User and lead limits per plan
- Automatic billing cycle management
- Feature-based access control

---

## 🛠️ **Tech Stack**

### **Backend**
- **Laravel 11** - PHP Framework
- **PHP 8.2+** - Server-side language
- **MySQL 8.0** - Primary database
- **SQLite** - Development database
- **Redis** - Caching and sessions

### **Frontend**
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework
- **Blade Templates** - Laravel templating engine

### **DevOps & Tools**
- **Docker** - Containerization
- **Vite** - Asset bundling
- **Composer** - PHP dependency management
- **NPM** - JavaScript package management

---

## ⚡ **Quick Start**

### **Prerequisites**
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/SQLite

### **Installation**
```bash
# Clone the repository
git clone https://github.com/StandaloneCoders/telecaller-saas.git
cd telecaller-saas

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate --seed

# Build assets
npm run build

# Start development server
php artisan serve
```

### **Access URLs**
- **Application**: http://127.0.0.1:8000
- **Login**: http://127.0.0.1:8000/login
- **Register**: http://127.0.0.1:8000/register

---

## 🔐 **Demo Accounts**

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| 🔥 **Super Admin** | `admin@platform.com` | `password123` | Platform-wide |
| 👑 **Admin** | `john@democorp.com` | `password123` | Company-level |
| 🎯 **Manager** | `mike@democorp.com` | `password123` | Team-level |
| 📞 **Agent** | `smith@democorp.com` | `password123` | Auto-dialer access |

---

## 📱 **Mobile API Endpoints**

### **Authentication**
```bash
POST /api/v1/auth/login
POST /api/v1/auth/logout
POST /api/v1/auth/refresh
```

### **Auto Dialer Integration**
```bash
GET  /api/v1/auto-dialer/leads     # Get assigned leads
POST /api/v1/auto-dialer/start     # Start calling session
POST /api/v1/auto-dialer/log-call  # Log call disposition
```

### **Lead Management**
```bash
GET  /api/v1/leads                 # Get agent leads
POST /api/v1/leads/{id}/update     # Update lead status
GET  /api/v1/leads/{id}/timeline   # Get lead history
```

---

## 🏗️ **System Architecture**

### **Database Schema**
- **Users & Roles** - RBAC implementation
- **Companies & Teams** - Multi-tenant structure
- **Leads & Call Logs** - Lead management system
- **Auto Dialers** - Device and SIM management
- **Subscription Plans** - Billing and limits
- **Audit Logs** - Activity tracking

### **Permission Matrix**
| Feature | Super Admin | Admin | Manager | Agent |
|---------|:-----------:|:-----:|:-------:|:-----:|
| Companies | ✅ All | ❌ | ❌ | ❌ |
| Users | ✅ All | ✅ Company | ✅ Team | ❌ |
| Leads | ✅ All | ✅ Company | ✅ Team | ✅ Assigned |
| Auto Dialer | ✅ All | ✅ Company | ✅ Team | ✅ Own |
| Call Logs | ✅ All | ✅ Company | ✅ Team | ✅ Own |
| Subscriptions | ✅ Manage | ✅ Company | ✅ View | ✅ View |

---

## 🤖 **Auto Dialer Features**

### **Device Management**
- Android device registration with unique IDs
- SIM card number tracking
- Device status monitoring (Active/Inactive/Maintenance)
- Daily call statistics and limits

### **Calling Interface**
- Automated lead progression
- Real-time call timer
- Call disposition buttons
- Notes and feedback system
- Start/Stop calling controls

### **Disposition Types**
- ✅ **Interested** - Lead shows interest
- ❌ **Not Interested** - Lead not interested
- 📅 **Callback** - Schedule follow-up call
- 📵 **No Answer** - Lead didn't answer
- 📞 **Busy** - Line was busy
- 🚫 **Invalid** - Invalid phone number

---

## 💰 **Subscription Plans**

### **Starter Plan - ₹2,499/month**
- 5 Users
- 1,000 Leads
- Basic Dashboard
- Email Support

### **Professional Plan - ₹6,699/month**
- 25 Users
- 10,000 Leads
- Advanced Analytics
- Priority Support
- API Access

### **Enterprise Plan - ₹16,699/month**
- 100 Users
- 50,000 Leads
- Custom Integrations
- Dedicated Support
- White Label Options

---

## 🔒 **Security Features**

- **JWT Authentication** with device binding
- **Multi-tenant isolation** with company scoping
- **Role-based permissions** at API and UI level
- **Device management** with remote control
- **Audit logging** for all user actions
- **IP whitelisting** and rate limiting
- **Data encryption** and secure storage

---

## 🚀 **Deployment**

### **Production Requirements**
- **Server**: Ubuntu 20.04+ or CentOS 8+
- **Web Server**: Nginx or Apache
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **Cache**: Redis 6.0+
- **Queue**: Redis or Database
- **Storage**: Local or AWS S3

### **Docker Deployment**
```bash
# Build production image
docker build -t telecaller-saas:latest .

# Run with docker-compose
docker-compose -f docker-compose.prod.yml up -d
```

---

## 👥 **Development Team**

### **StandaloneCoders**
- **Yogendra Singh** - Lead Developer & Founder
- **Govind Raajpoot** - Backend Developer
- **Sparsh Jain** - Frontend Developer  
- **Pranay Mukherjee** - Full Stack Developer

---

## 🔗 **Links & Resources**

- **Website**: https://standalonecoders.com
- **Documentation**: https://docs.standalonecoders.com
- **Support**: support@standalonecoders.com
- **Sales**: sales@standalonecoders.com

---

<p align="center">
  <strong>Built with ❤️ by StandaloneCoders</strong><br>
  <em>"Building digital empires that scale!"</em>
</p>

---

**🔓 OPEN SOURCE**: This project is licensed under the MIT License. Feel free to use, modify, and distribute according to the license terms.

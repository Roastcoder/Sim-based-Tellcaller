<h1 align="center">📞 Telecaller SaaS Platform 📞</h1>
<h3 align="center">Complete 4-Level RBAC Telecaller Dashboard with Mobile API Integration</h3>
<p align="center">Built by <b>RoastCoder</b> (Yogendra Singh) 🔥</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/TailwindCSS-3.3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white" />
</p>

---

## 🚀 What This Beast Does

A **production-ready** Telecaller SaaS platform with complete dashboard system, mobile API integration, and advanced RBAC hierarchy. Perfect for telemarketing companies, sales teams, and call centers.

### 🎯 **Core Features**
- 🏢 **4-Level Role Hierarchy**: Super Admin → Admin → Manager → Agent
- 🏗️ **Multi-Tenant Architecture**: Complete company isolation
- 📱 **Mobile API**: Full REST API for Android/iOS apps
- 📊 **Advanced Dashboard**: Role-based analytics and reporting
- 🔒 **Device Management**: Secure device binding and control
- 📦 **App Management**: APK upload, versioning, and distribution

---

## 🔥 Live Demo & Screenshots

<p align="center">
  <img src="https://via.placeholder.com/800x400/1f2937/ffffff?text=Super+Admin+Dashboard" alt="Super Admin Dashboard" />
</p>

<p align="center">
  <img width="49%" src="https://via.placeholder.com/400x300/3b82f6/ffffff?text=Agent+Dashboard" alt="Agent Dashboard" />
  <img width="49%" src="https://via.placeholder.com/400x300/10b981/ffffff?text=Apps+Management" alt="Apps Management" />
</p>

---

## 🛠️ Tech Stack

### 🎨 Frontend
<p>
  <img src="https://skillicons.dev/icons?i=html,css,js,tailwind,alpine" />
</p>

### 🔧 Backend & Database
<p>
  <img src="https://skillicons.dev/icons?i=php,laravel,mysql,redis" />
</p>

### 🚀 DevOps & Tools
<p>
  <img src="https://skillicons.dev/icons?i=docker,nginx,git,github,vscode" />
</p>

---

## ⚡ Quick Start

### 🐳 Docker Setup (Recommended)
```bash
# Clone the repository
git clone https://github.com/RoastCoder/telecaller-saas.git
cd telecaller-saas

# Start with Docker
cp .env.example .env
docker-compose -f docker/docker-compose.yml up -d

# Setup database
docker-compose exec app php artisan migrate --seed
```

### 🔧 Manual Setup
```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed
npm run build

# Start server
php artisan serve
```

---

## 🎭 Demo Accounts

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| 🔥 **Super Admin** | `admin@platform.com` | `password123` | Platform-wide |
| 👑 **Admin** | `john@democorp.com` | `password123` | Company-level |
| 🎯 **Manager** | `mike@democorp.com` | `password123` | Team-level |
| 📞 **Agent** | `smith@democorp.com` | `password123` | Self-access |

---

## 📱 Mobile API Integration

### 🔐 Authentication
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "smith@democorp.com",
    "password": "password123",
    "device_info": {
      "device_id": "android_123456",
      "device_name": "Samsung Galaxy S21"
    }
  }'
```

### 📊 Call Logging
```bash
curl -X POST http://localhost:8000/api/v1/call-logs \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "phone": "+1234567890",
    "call_type": "outgoing",
    "duration_seconds": 120,
    "disposition": "interested"
  }'
```

---

## 🏗️ Architecture Overview

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Super Admin   │    │      Admin      │    │     Manager     │
│  Platform-wide  │───▶│  Company-level  │───▶│   Team-level    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                                        │
                                               ┌─────────────────┐
                                               │      Agent      │
                                               │   Self-access   │
                                               └─────────────────┘
```

---

## 🔒 Security Features

- 🛡️ **JWT Authentication** with device binding
- 🏢 **Multi-tenant isolation** with company scoping
- 🔐 **Role-based permissions** at API and UI level
- 📱 **Device management** with remote lock/unlock
- 📝 **Audit logging** for all user actions
- 🚫 **IP whitelisting** and rate limiting

---

## 📊 Permission Matrix

| Feature | Super Admin | Admin | Manager | Agent |
|---------|:-----------:|:-----:|:-------:|:-----:|
| Companies | ✅ All | ❌ | ❌ | ❌ |
| Users | ✅ All | ✅ Company | ✅ Team | ❌ |
| Leads | ✅ All | ✅ Company | ✅ Team | ✅ Assigned |
| Call Logs | ✅ All | ✅ Company | ✅ Team | ✅ Own |
| Apps | ✅ Manage | ✅ Company | ✅ View | ✅ View |
| Devices | ✅ All | ✅ Company | ✅ Team | ✅ Own |

---

## 🚀 Deployment

### 🐳 Production Docker
```bash
# Build production image
docker build -f docker/Dockerfile -t telecaller-saas:latest .

# Deploy with production compose
docker-compose -f docker/docker-compose.prod.yml up -d
```

### ☁️ Cloud Deployment
- **AWS**: ECS + RDS + ElastiCache
- **DigitalOcean**: App Platform + Managed Database
- **Google Cloud**: Cloud Run + Cloud SQL

---

## 📚 Documentation

- 📖 **[API Documentation](docs/api.yaml)** - Complete OpenAPI 3.0 spec
- 🏗️ **[Architecture Guide](docs/architecture.md)** - System design overview
- 🔧 **[Installation Guide](docs/installation.md)** - Detailed setup instructions
- 🔒 **[Security Guide](docs/security.md)** - Security best practices

---

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🔗 Connect With The Creator

<p align="left">
  <a href="https://www.linkedin.com/in/yogendra-singh-4279251b1" target="_blank">
    <img src="https://skillicons.dev/icons?i=linkedin" width="40"/>
  </a>
  <a href="mailto:iamfaujdar@gmail.com">
    <img src="https://skillicons.dev/icons?i=gmail" width="40"/>
  </a>
  <a href="https://github.com/RoastCoder" target="_blank">
    <img src="https://skillicons.dev/icons?i=github" width="40"/>
  </a>
</p>

---

## 🔥 Developer Quote
> "I don't just build SaaS platforms... I architect digital empires that scale!" 😎🚀

---

<p align="center">
  <img src="https://github-readme-stats.vercel.app/api/pin/?username=RoastCoder&repo=telecaller-saas&theme=tokyonight" />
</p>

---

<p align="center">⭐ If this project helped you, show some ❤️ by starring the repository!</p>
<p align="center">🚀 Built with passion by <b>RoastCoder</b> | Founder @ StandaloneCoders</p>
# Telecaller SaaS - Complete Folder Structure

```
telecaller-saas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── LeadController.php
│   │   │   │   ├── CallLogController.php
│   │   │   │   ├── DeviceController.php
│   │   │   │   └── AppController.php
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── Admin/
│   │   │   │   ├── CompanyController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── ReportController.php
│   │   │   ├── Manager/
│   │   │   │   ├── TeamController.php
│   │   │   │   └── AgentController.php
│   │   │   ├── Agent/
│   │   │   │   └── DashboardController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── LeadController.php
│   │   │   ├── CallLogController.php
│   │   │   ├── AppController.php
│   │   │   ├── DeviceController.php
│   │   │   └── SettingsController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php
│   │   │   ├── CompanyScopeMiddleware.php
│   │   │   └── TeamScopeMiddleware.php
│   │   └── Requests/
│   │       ├── StoreLeadRequest.php
│   │       ├── StoreUserRequest.php
│   │       └── StoreAppRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Company.php
│   │   ├── Team.php
│   │   ├── Lead.php
│   │   ├── CallLog.php
│   │   ├── App.php
│   │   ├── Device.php
│   │   ├── AgentStat.php
│   │   └── AuditLog.php
│   ├── Policies/
│   │   ├── UserPolicy.php
│   │   ├── LeadPolicy.php
│   │   └── CompanyPolicy.php
│   ├── Services/
│   │   ├── ApkService.php
│   │   ├── DeviceService.php
│   │   └── CallLogService.php
│   └── Traits/
│       ├── HasCompanyScope.php
│       └── HasAuditLog.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_roles_table.php
│   │   ├── 2024_01_01_000002_create_companies_table.php
│   │   ├── 2024_01_01_000003_create_users_table.php
│   │   ├── 2024_01_01_000004_create_teams_table.php
│   │   ├── 2024_01_01_000005_create_leads_table.php
│   │   ├── 2024_01_01_000006_create_call_logs_table.php
│   │   ├── 2024_01_01_000007_create_apps_table.php
│   │   ├── 2024_01_01_000008_create_devices_table.php
│   │   ├── 2024_01_01_000009_create_agent_stats_table.php
│   │   └── 2024_01_01_000010_create_audit_logs_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── RoleSeeder.php
│   │   ├── CompanySeeder.php
│   │   └── UserSeeder.php
│   └── factories/
│       ├── UserFactory.php
│       └── LeadFactory.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── auth.blade.php
│   │   │   └── components/
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   ├── dashboard/
│   │   │   ├── index.blade.php
│   │   │   ├── super-admin.blade.php
│   │   │   ├── admin.blade.php
│   │   │   ├── manager.blade.php
│   │   │   └── agent.blade.php
│   │   ├── leads/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── users/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── teams/
│   │   │   ├── index.blade.php
│   │   │   └── create.blade.php
│   │   ├── apps/
│   │   │   ├── index.blade.php
│   │   │   ├── upload.blade.php
│   │   │   └── show.blade.php
│   │   ├── devices/
│   │   │   └── index.blade.php
│   │   └── settings/
│   │       └── index.blade.php
│   ├── js/
│   │   ├── app.js
│   │   ├── components/
│   │   └── types/
│   └── css/
│       └── app.css
├── routes/
│   ├── web.php
│   ├── api.php
│   └── channels.php
├── config/
│   ├── rbac.php
│   └── filesystems.php
├── storage/
│   ├── app/
│   │   ├── public/
│   │   ├── uploads/
│   │   └── apks/
│   └── logs/
├── docker/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   └── nginx.conf
├── tests/
│   ├── Feature/
│   └── Unit/
├── docs/
│   ├── api.yaml
│   └── wireframes.md
├── .github/
│   └── workflows/
│       └── ci.yml
├── composer.json
├── package.json
├── tailwind.config.js
├── vite.config.js
└── README.md
```
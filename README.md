# 4-Level RBAC Implementation for Telecaller SaaS

Complete implementation of **Super Admin → Admin → Manager → Agent** hierarchy with permissions, database schema, API middleware, and mobile app configurations.

## Quick Start

1. **Database Setup**
   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p < database/seed.sql
   ```

2. **Environment Variables**
   ```bash
   JWT_SECRET=your_jwt_secret_here
   DB_HOST=localhost
   DB_NAME=telecaller_saas
   DB_USER=root
   DB_PASS=password
   ```

3. **API Server (Node.js/Express)**
   ```bash
   npm install express jsonwebtoken bcryptjs mysql2
   node api/server.js
   ```

## Role Hierarchy

| Role | ID | Scope | Key Permissions |
|------|----|----|-----------------|
| **SUPER_ADMIN** | 1 | Platform | All companies, billing, platform settings |
| **ADMIN** | 2 | Company | Company users, billing, all teams |
| **MANAGER** | 3 | Team | Team members, team leads, team reports |
| **AGENT** | 4 | Self | Assigned leads, own calls, self stats |

## API Endpoints

### Authentication
- `POST /auth/login` - User login
- `POST /auth/register` - User registration

### Role-Protected Routes
```typescript
// Super Admin only
GET /admin/companies          // View all companies
POST /admin/companies         // Create company
DELETE /admin/companies/:id   // Delete company

// Admin and above
GET /users                    // Company-scoped users
POST /users                   // Create users
GET /billing                  // Company billing
POST /leads/import           // Import leads

// Manager and above  
GET /teams/:id/leads         // Team leads
POST /leads/assign           // Assign leads
GET /teams/:id/stats         // Team stats

// All authenticated users
POST /call-logs              // Log calls
GET /my-leads               // Assigned leads
PUT /leads/:id/disposition  // Update disposition
```

## Database Schema

Core tables:
- `roles` - Role definitions (1-4)
- `companies` - Multi-tenant companies
- `users` - All system users with role_id
- `teams` - Manager-owned teams
- `leads` - Customer leads with assignments
- `call_logs` - Call records with device sync
- `agent_stats` - Daily performance metrics
- `audit_logs` - Action tracking

## Mobile App (Android)

### Required Permissions
```xml
<uses-permission android:name="android.permission.READ_CALL_LOG" />
<uses-permission android:name="android.permission.CALL_PHONE" />
<uses-permission android:name="android.permission.RECORD_AUDIO" />
<uses-permission android:name="android.permission.FOREGROUND_SERVICE" />
```

### Role-Based Features
- **Agent**: Full mobile experience, call logging, voice notes
- **Manager**: Team stats, lead assignment, monitoring
- **Admin**: Company dashboard, user management
- **Super Admin**: Web-only access

## Middleware Usage

### TypeScript/Express
```typescript
import { requireRole, Role } from './middleware/auth';

// Admin only route
app.get('/admin/users', requireRole(Role.ADMIN), handler);

// Company-scoped access
app.get('/companies/:id/data', requireCompanyAccess(), handler);
```

### PHP/Laravel
```php
// Route with role middleware
Route::middleware([RBACMiddleware::requireRole(RBACMiddleware::ADMIN)])
    ->get('/admin/users', 'AdminController@users');

// Check permissions in controller
if (!RBACMiddleware::canViewLeads($user, $leadCompanyId)) {
    return response()->json(['error' => 'forbidden'], 403);
}
```

## Security Features

- **JWT Authentication** with role-based claims
- **Company Scoping** - Users only access their company data
- **Team Scoping** - Managers only access their team data
- **Audit Logging** - All actions tracked with user context
- **Device Binding** - Optional mobile device registration
- **Idempotency** - Duplicate call prevention with device_call_id

## Data Privacy

- Voice notes stored in encrypted S3 buckets
- Configurable data retention policies
- PII masking in exports (role-dependent)
- Audit trail for all data deletions
- GDPR-compliant data handling

## Deployment Checklist

- [ ] Database schema deployed
- [ ] Seed data inserted (Super Admin created)
- [ ] JWT secret configured
- [ ] S3 bucket for voice notes setup
- [ ] Rate limiting configured
- [ ] SSL certificates installed
- [ ] Monitoring and logging setup
- [ ] Backup strategy implemented

## File Structure

```
├── database/
│   ├── schema.sql          # Complete DB schema
│   └── seed.sql           # Sample data
├── api/
│   ├── middleware/
│   │   ├── auth.ts        # TypeScript middleware
│   │   └── rbac.php       # PHP middleware
│   └── routes.ts          # API endpoints
├── types/
│   └── rbac.ts           # TypeScript definitions
├── config/
│   └── rbac.json         # Role permissions config
├── mobile/
│   ├── android-permissions.xml
│   └── role-based-ui.ts  # Mobile UI config
└── README.md
```

## Testing

Test with different role users:
- Super Admin: `admin@platform.com`
- Company Admin: `john@democorp.com` 
- Manager: `mike@democorp.com`
- Agent: `smith@democorp.com`

Default password: `password123` (change in production)

## Support

For implementation questions or customization needs, refer to the inline code comments and configuration files.# Sim-based-Tellcaller

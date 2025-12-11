import express from 'express';
import { Role } from '../types/rbac';
import { authenticateToken, requireRole, requireCompanyAccess } from './middleware/auth';

const router = express.Router();

// Public routes
router.post('/auth/login', loginHandler);
router.post('/auth/register', registerHandler);

// Protected routes with role-based access
router.use(authenticateToken); // All routes below require authentication

// Super Admin only routes
router.get('/admin/companies', requireRole(Role.SUPER_ADMIN), getCompanies);
router.post('/admin/companies', requireRole(Role.SUPER_ADMIN), createCompany);
router.delete('/admin/companies/:id', requireRole(Role.SUPER_ADMIN), deleteCompany);

// Admin and above routes
router.get('/users', requireRole(Role.ADMIN), getUsers);
router.post('/users', requireRole(Role.ADMIN), createUser);
router.get('/billing', requireRole(Role.ADMIN), getBilling);
router.post('/leads/import', requireRole(Role.ADMIN), importLeads);

// Manager and above routes
router.get('/teams/:teamId/leads', requireRole(Role.MANAGER), getTeamLeads);
router.post('/leads/assign', requireRole(Role.MANAGER), assignLeads);
router.get('/teams/:teamId/stats', requireRole(Role.MANAGER), getTeamStats);

// Agent and above routes (all authenticated users)
router.post('/call-logs', createCallLog);
router.get('/my-leads', getMyLeads);
router.put('/leads/:id/disposition', updateLeadDisposition);

// Company-scoped routes
router.get('/companies/:companyId/leads', requireCompanyAccess(), getCompanyLeads);
router.get('/companies/:companyId/reports', requireCompanyAccess(), getCompanyReports);

// Route handlers (simplified)
async function loginHandler(req: any, res: any) {
  // Login logic
  res.json({ token: 'jwt_token', user: {} });
}

async function registerHandler(req: any, res: any) {
  // Registration logic
  res.json({ message: 'User registered' });
}

async function getCompanies(req: any, res: any) {
  // Super admin can view all companies
  res.json({ companies: [] });
}

async function createCompany(req: any, res: any) {
  // Super admin creates new company
  res.json({ company: {} });
}

async function deleteCompany(req: any, res: any) {
  // Super admin deletes company
  res.json({ message: 'Company deleted' });
}

async function getUsers(req: any, res: any) {
  const user = req.user;
  // Admin sees company users, Super admin sees all
  const scope = user.role_id === Role.SUPER_ADMIN ? 'all' : user.company_id;
  res.json({ users: [], scope });
}

async function createUser(req: any, res: any) {
  // Admin creates users in their company
  res.json({ user: {} });
}

async function getBilling(req: any, res: any) {
  const user = req.user;
  // Company-scoped billing info
  res.json({ billing: {}, company_id: user.company_id });
}

async function importLeads(req: any, res: any) {
  // Import leads with company scoping
  res.json({ imported: 0, errors: [] });
}

async function getTeamLeads(req: any, res: any) {
  const { teamId } = req.params;
  // Manager views team leads
  res.json({ leads: [], team_id: teamId });
}

async function assignLeads(req: any, res: any) {
  // Manager assigns leads to team members
  res.json({ assigned: 0 });
}

async function getTeamStats(req: any, res: any) {
  const { teamId } = req.params;
  // Team performance stats
  res.json({ stats: {}, team_id: teamId });
}

async function createCallLog(req: any, res: any) {
  const user = req.user;
  // Agent creates call log
  res.json({ call_log: { user_id: user.id } });
}

async function getMyLeads(req: any, res: any) {
  const user = req.user;
  // Agent views assigned leads only
  res.json({ leads: [], assigned_to: user.id });
}

async function updateLeadDisposition(req: any, res: any) {
  const { id } = req.params;
  const user = req.user;
  // Update lead disposition (with ownership check)
  res.json({ lead: { id, updated_by: user.id } });
}

async function getCompanyLeads(req: any, res: any) {
  const { companyId } = req.params;
  // Company-scoped leads
  res.json({ leads: [], company_id: companyId });
}

async function getCompanyReports(req: any, res: any) {
  const { companyId } = req.params;
  // Company-scoped reports
  res.json({ reports: {}, company_id: companyId });
}

export default router;
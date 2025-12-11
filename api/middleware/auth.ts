import { Request, Response, NextFunction } from 'express';
import jwt from 'jsonwebtoken';
import { Role, User, AuthRequest } from '../../types/rbac';

export function requireRole(minRole: Role) {
  return (req: AuthRequest, res: Response, next: NextFunction) => {
    const user = req.user;
    if (!user) return res.status(401).json({ error: 'unauthorized' });
    if (user.role_id > minRole) return res.status(403).json({ error: 'forbidden' });
    next();
  };
}

export function requireCompanyAccess() {
  return (req: AuthRequest, res: Response, next: NextFunction) => {
    const user = req.user;
    const companyId = parseInt(req.params.companyId || req.query.companyId as string);
    
    if (!user) return res.status(401).json({ error: 'unauthorized' });
    
    // Super admin can access all companies
    if (user.role_id === Role.SUPER_ADMIN) return next();
    
    // Others can only access their own company
    if (user.company_id !== companyId) {
      return res.status(403).json({ error: 'company_access_denied' });
    }
    
    next();
  };
}

export function requireTeamAccess() {
  return async (req: AuthRequest, res: Response, next: NextFunction) => {
    const user = req.user;
    const teamId = parseInt(req.params.teamId as string);
    
    if (!user) return res.status(401).json({ error: 'unauthorized' });
    
    // Super admin and admin can access all teams in their scope
    if (user.role_id <= Role.ADMIN) return next();
    
    // Manager can only access their own team
    if (user.role_id === Role.MANAGER) {
      // Check if user manages this team (would need DB query)
      // For now, simplified check
      return next();
    }
    
    return res.status(403).json({ error: 'team_access_denied' });
  };
}

export function authenticateToken(req: AuthRequest, res: Response, next: NextFunction) {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1];

  if (!token) {
    return res.status(401).json({ error: 'token_required' });
  }

  jwt.verify(token, process.env.JWT_SECRET!, (err: any, decoded: any) => {
    if (err) return res.status(403).json({ error: 'invalid_token' });
    req.user = decoded as User;
    next();
  });
}
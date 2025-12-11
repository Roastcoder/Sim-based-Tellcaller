// RBAC Type Definitions
export enum Role {
  SUPER_ADMIN = 1,
  ADMIN = 2,
  MANAGER = 3,
  AGENT = 4
}

export interface User {
  id: number;
  name: string;
  email: string;
  phone?: string;
  role_id: Role;
  company_id?: number;
  manager_id?: number;
  status: number;
  device_id?: string;
}

export interface Permission {
  'company.manage'?: boolean | string;
  'billing.manage'?: boolean | string;
  'team.manage'?: boolean | string;
  'lead.assign'?: boolean | string;
  'report.view'?: boolean | string;
  'calllogs.view'?: boolean | string;
  'leads.update.self'?: boolean;
}

export interface RolePermissions {
  role_id: Role;
  permissions: Permission;
}

export const ROLE_PERMISSIONS: Record<string, RolePermissions> = {
  SUPER_ADMIN: {
    role_id: Role.SUPER_ADMIN,
    permissions: {
      'company.manage': true,
      'billing.manage': true,
      'team.manage': true,
      'lead.assign': 'all',
      'report.view': 'all',
      'calllogs.view': 'all'
    }
  },
  ADMIN: {
    role_id: Role.ADMIN,
    permissions: {
      'company.manage': true,
      'billing.manage': true,
      'team.manage': 'company',
      'lead.assign': 'company',
      'report.view': 'company',
      'calllogs.view': 'company'
    }
  },
  MANAGER: {
    role_id: Role.MANAGER,
    permissions: {
      'team.manage': 'own',
      'lead.assign': 'team',
      'report.view': 'team',
      'calllogs.view': 'team'
    }
  },
  AGENT: {
    role_id: Role.AGENT,
    permissions: {
      'lead.assign': false,
      'report.view': 'self',
      'calllogs.view': 'self',
      'leads.update.self': true
    }
  }
};

export interface AuthRequest extends Request {
  user?: User;
}
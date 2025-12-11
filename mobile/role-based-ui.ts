// Mobile App Role-Based UI Configuration
export interface MobileUIConfig {
  role: string;
  screens: string[];
  features: string[];
  restrictions: string[];
}

export const MOBILE_UI_CONFIG: Record<string, MobileUIConfig> = {
  AGENT: {
    role: 'AGENT',
    screens: [
      'dashboard',
      'my_leads',
      'call_history',
      'lead_details',
      'call_screen',
      'voice_notes',
      'profile',
      'sync_status'
    ],
    features: [
      'auto_call_logging',
      'voice_note_recording',
      'lead_disposition',
      'follow_up_reminders',
      'offline_mode',
      'call_analytics_self',
      'lead_search_assigned',
      'quick_dial'
    ],
    restrictions: [
      'no_lead_assignment',
      'no_team_view',
      'no_user_management',
      'no_company_settings',
      'assigned_leads_only'
    ]
  },
  
  MANAGER: {
    role: 'MANAGER',
    screens: [
      'dashboard',
      'team_overview',
      'team_leads',
      'team_performance',
      'lead_assignment',
      'agent_monitoring',
      'reports',
      'profile'
    ],
    features: [
      'team_lead_assignment',
      'team_performance_view',
      'agent_call_monitoring',
      'team_reports',
      'lead_import_team',
      'bulk_lead_actions',
      'team_voice_notes_access'
    ],
    restrictions: [
      'team_scope_only',
      'no_company_billing',
      'no_cross_team_access',
      'limited_user_creation'
    ]
  },
  
  ADMIN: {
    role: 'ADMIN',
    screens: [
      'dashboard',
      'company_overview',
      'all_leads',
      'all_teams',
      'user_management',
      'company_reports',
      'billing',
      'settings',
      'data_import'
    ],
    features: [
      'company_wide_access',
      'user_creation_management',
      'billing_management',
      'data_import_export',
      'company_settings',
      'cross_team_reports',
      'company_voice_notes_access'
    ],
    restrictions: [
      'company_scope_only',
      'no_platform_settings',
      'no_multi_company_access'
    ]
  },
  
  SUPER_ADMIN: {
    role: 'SUPER_ADMIN',
    screens: ['web_redirect'],
    features: ['web_platform_access'],
    restrictions: ['mobile_access_limited']
  }
};

// Mobile feature flags based on role
export function getMobileFeatures(roleId: number): string[] {
  const roleMap: Record<number, string> = {
    1: 'SUPER_ADMIN',
    2: 'ADMIN', 
    3: 'MANAGER',
    4: 'AGENT'
  };
  
  const role = roleMap[roleId];
  return MOBILE_UI_CONFIG[role]?.features || [];
}

// Check if user can access specific mobile screen
export function canAccessScreen(roleId: number, screenName: string): boolean {
  const roleMap: Record<number, string> = {
    1: 'SUPER_ADMIN',
    2: 'ADMIN',
    3: 'MANAGER', 
    4: 'AGENT'
  };
  
  const role = roleMap[roleId];
  const config = MOBILE_UI_CONFIG[role];
  
  return config?.screens.includes(screenName) || false;
}

// Mobile API endpoints per role
export const MOBILE_API_ACCESS: Record<string, string[]> = {
  AGENT: [
    'GET /api/v1/my-leads',
    'POST /api/v1/call-logs',
    'PUT /api/v1/leads/:id/disposition',
    'POST /api/v1/voice-notes',
    'GET /api/v1/my-stats',
    'POST /api/v1/sync/call-logs'
  ],
  
  MANAGER: [
    'GET /api/v1/team/:id/leads',
    'POST /api/v1/leads/assign',
    'GET /api/v1/team/:id/stats',
    'GET /api/v1/team/:id/agents',
    'POST /api/v1/team/:id/leads/import'
  ],
  
  ADMIN: [
    'GET /api/v1/company/leads',
    'POST /api/v1/users',
    'GET /api/v1/company/reports',
    'POST /api/v1/leads/bulk-import',
    'GET /api/v1/billing'
  ],
  
  SUPER_ADMIN: [
    'GET /api/v1/admin/*'
  ]
};
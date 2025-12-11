<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Role-Based Access Control Configuration
    |--------------------------------------------------------------------------
    */

    'roles' => [
        'SUPER_ADMIN' => [
            'id' => 1,
            'name' => 'Super Admin',
            'permissions' => [
                'company.manage' => true,
                'billing.manage' => true,
                'team.manage' => true,
                'lead.assign' => 'all',
                'lead.view' => 'all',
                'lead.import' => true,
                'lead.export' => true,
                'report.view' => 'all',
                'calllogs.view' => 'all',
                'user.create' => true,
                'user.delete' => true,
                'data.retention' => true,
                'ai.insights' => 'all',
                'app.manage' => true,
                'device.manage' => true,
            ]
        ],
        'ADMIN' => [
            'id' => 2,
            'name' => 'Admin',
            'permissions' => [
                'company.manage' => 'own',
                'billing.manage' => 'own',
                'team.manage' => 'company',
                'lead.assign' => 'company',
                'lead.view' => 'company',
                'lead.import' => true,
                'lead.export' => true,
                'report.view' => 'company',
                'calllogs.view' => 'company',
                'user.create' => 'company',
                'user.delete' => 'company',
                'data.retention' => 'company',
                'ai.insights' => 'company',
                'app.manage' => 'company',
                'device.manage' => 'company',
            ]
        ],
        'MANAGER' => [
            'id' => 3,
            'name' => 'Manager',
            'permissions' => [
                'team.manage' => 'own',
                'lead.assign' => 'team',
                'lead.view' => 'team',
                'lead.import' => 'team',
                'lead.export' => 'team',
                'report.view' => 'team',
                'calllogs.view' => 'team',
                'user.create' => 'team',
                'ai.insights' => 'team',
                'voice.notes.add' => true,
                'voice.notes.play' => 'team',
                'device.view' => 'team',
            ]
        ],
        'AGENT' => [
            'id' => 4,
            'name' => 'Agent',
            'permissions' => [
                'lead.assign' => false,
                'lead.view' => 'assigned',
                'lead.update' => 'assigned',
                'report.view' => 'self',
                'calllogs.view' => 'self',
                'calllogs.create' => true,
                'ai.insights' => 'self',
                'voice.notes.add' => true,
                'voice.notes.play' => 'self',
                'device.manage' => 'own',
            ]
        ]
    ],

    'ui_rules' => [
        'sidebar' => [
            'SUPER_ADMIN' => [
                'dashboard', 'companies', 'users', 'teams', 'leads', 
                'call-logs', 'apps', 'devices', 'reports', 'settings'
            ],
            'ADMIN' => [
                'dashboard', 'users', 'teams', 'leads', 'call-logs', 
                'apps', 'devices', 'reports', 'settings'
            ],
            'MANAGER' => [
                'dashboard', 'leads', 'call-logs', 'teams', 'apps', 'devices'
            ],
            'AGENT' => [
                'dashboard', 'agent.leads', 'call-logs', 'apps', 'devices'
            ]
        ],
        'actions' => [
            'create_user' => [1, 2, 3],
            'delete_user' => [1, 2],
            'assign_leads' => [1, 2, 3],
            'import_leads' => [1, 2, 3],
            'export_data' => [1, 2, 3],
            'view_billing' => [1, 2],
            'manage_teams' => [1, 2, 3],
            'upload_apps' => [1, 2],
            'manage_devices' => [1, 2, 3],
        ]
    ],

    'mobile_permissions' => [
        'AGENT' => [
            'call_logging' => true,
            'voice_notes' => true,
            'lead_updates' => true,
            'offline_sync' => true,
            'background_service' => true,
            'device_binding' => true,
        ],
        'MANAGER' => [
            'team_stats' => true,
            'lead_reassign' => true,
            'team_reports' => true,
            'agent_monitoring' => true,
        ],
        'ADMIN' => [
            'company_dashboard' => true,
            'user_management' => true,
            'company_reports' => true,
            'app_management' => true,
        ],
        'SUPER_ADMIN' => [
            'platform_access' => 'web_only'
        ]
    ],

    'data_scoping' => [
        'company_isolation' => true,
        'team_isolation' => true,
        'agent_isolation' => true,
    ],

    'security' => [
        'device_binding_required' => env('DEVICE_BINDING_REQUIRED', false),
        'max_devices_per_agent' => env('MAX_DEVICES_PER_AGENT', 2),
        'token_expiry_days' => env('API_TOKEN_EXPIRY_DAYS', 30),
        'audit_logging' => true,
        'ip_whitelist_enabled' => env('IP_WHITELIST_ENABLED', false),
    ],

    'features' => [
        'voice_notes' => env('VOICE_NOTES_ENABLED', true),
        'ai_insights' => env('AI_INSIGHTS_ENABLED', false),
        'call_recording' => env('CALL_RECORDING_ENABLED', false),
        'lead_scoring' => env('LEAD_SCORING_ENABLED', true),
        'bulk_operations' => env('BULK_OPERATIONS_ENABLED', true),
        'data_export' => env('DATA_EXPORT_ENABLED', true),
    ],

    'limits' => [
        'leads_per_import' => env('LEADS_PER_IMPORT', 1000),
        'call_logs_per_sync' => env('CALL_LOGS_PER_SYNC', 100),
        'voice_note_max_size_mb' => env('VOICE_NOTE_MAX_SIZE_MB', 10),
        'apk_max_size_mb' => env('APK_MAX_SIZE_MB', 100),
    ]
];
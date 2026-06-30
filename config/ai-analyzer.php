<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Analyzer Dashboard Path
    |--------------------------------------------------------------------------
    |
    | The URI path where the AI Analyzer dashboard will be accessible. Feel free to
    | change this value to suit your application's needs.
    |
    */

    'path' => env('AI_ANALYZER_PATH', 'ai-analyzer'),

    /*
    |--------------------------------------------------------------------------
    | Authentication Guard
    |--------------------------------------------------------------------------
    |
    | The authentication guard to use when checking access to the AI Analyzer
    | dashboard. Defaults to your application's default "web" guard.
    |
    */

    'auth_guard' => env('AI_ANALYZER_GUARD', 'web'),

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware applied to all AI Analyzer dashboard routes. The "web" middleware
    | group is always applied. Add "auth" or custom auth middleware here
    | if you want to require authentication.
    |
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | AI Analyzer Dashboard Domain
    |--------------------------------------------------------------------------
    |
    | Set a custom domain for the AI Analyzer dashboard routes. Leave null to use
    | the same domain as the rest of your application.
    |
    */

    'domain' => env('AI_ANALYZER_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Back to Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used for the "Back to App" link in the AI Analyzer dashboard
    | header. Set this to your application's home page or any URL where
    | users should return after using the AI Analyzer dashboard.
    |
    */

    'back_to_app_url' => env('AI_ANALYZER_BACK_TO_APP_URL', '/'),

    /*
    |--------------------------------------------------------------------------
    | Agent Discovery Directories
    |--------------------------------------------------------------------------
    |
    | Directories that AI Analyzer will scan to discover agent classes. Paths are
    | relative to your application's base path.
    |
    */

    'agent_directories' => [
        'app/AI/Agents',
        'app/Ai/Agents',
    ],

    /*
    |--------------------------------------------------------------------------
    | Agent Registry Cache TTL
    |--------------------------------------------------------------------------
    |
    | Number of seconds to cache the discovered agent classes. Set to 0 to
    | disable caching entirely.
    |
    */

    'registry_cache_ttl' => 3600,

    /*
    |--------------------------------------------------------------------------
    | Currency Configuration
    |--------------------------------------------------------------------------
    |
    | The default currency and symbol used for cost calculations and display
    | throughout the dashboard (pricing matrix, cost dashboard, etc.).
    |
    */

    'currency' => env('ANALYZER_CURRENCY', 'USD'),

    'currency_symbol' => env('ANALYZER_CURRENCY_SYMBOL', '$'),

    /*
    |--------------------------------------------------------------------------
    | Budget Monitoring
    |--------------------------------------------------------------------------
    |
    | Configure budget alert functionality. Notifications are dispatched via
    | Laravel's queue system (non-blocking) so they never slow down requests.
    |
    */

    'budget' => [

        'enabled' => env('ANALYZER_BUDGET_ENABLED', true),

        'notification_channels' => ['mail'],

    ],

    /*
    |--------------------------------------------------------------------------
    | SDK Observability
    |--------------------------------------------------------------------------
    |
    | When enabled, AI Analyzer listens to official Laravel AI SDK events for features
    | such as run storage and budget monitoring. Run storage can be disabled
    | independently without disabling event-driven budget checks.
    |
    */

    'observability' => [

        'enabled' => env('AI_ANALYZER_OBSERVABILITY_ENABLED', true),

        'store_runs' => env('AI_ANALYZER_STORE_RUNS', true),

        'capture_text_payloads' => env('AI_ANALYZER_CAPTURE_TEXT_PAYLOADS', true),

        'max_payload_length' => (int) env('AI_ANALYZER_MAX_PAYLOAD_LENGTH', 10000),

        'excluded_operations' => [],

    ],

    /*
    |--------------------------------------------------------------------------
    | Prompt Lab Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the Prompt Lab feature, which lets you configure an agent
    | and compare responses across multiple provider+model pairs.
    |
    */

    'prompt-lab' => [

        'max_slots' => (int) env('ANALYZER_PROMPT_LAB_MAX_SLOTS', 3),

        'timeout_seconds' => (int) env('ANALYZER_PROMPT_LAB_TIMEOUT', 120),

    ],

    /*
    |--------------------------------------------------------------------------
    | Sandbox Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the Agent Sandbox playground. Controls the number of
    | records shown in Eloquent model picker dropdowns.
    |
    */

    'sandbox' => [

        'records_per_picker' => 20,

    ],

    /*
    |--------------------------------------------------------------------------
    | Export Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for conversation export functionality — Pest test generation
    | and JSON fine-tuning exports.
    |
    */

    'export' => [

        'pest_namespace' => env('ANALYZER_PEST_NAMESPACE', 'Tests\\Feature\\AI'),

        'json_format' => env('ANALYZER_JSON_FORMAT', 'openai'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Configuration
    |--------------------------------------------------------------------------
    |
    | Security audit and compliance settings. Includes access logging,
    | PII detection, and data retention policies.
    |
    */

    'audit' => [

        'enabled' => env('ANALYZER_AUDIT_ENABLED', true),

        'retention_days' => (int) env('ANALYZER_RETENTION_DAYS', 90),

    ],

];

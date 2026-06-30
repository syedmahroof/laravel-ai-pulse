# Config Options

Complete reference for all configuration options in `config/ai-analyzer.php`.

## Dashboard Path

```php
'path' => env('AI_ANALYZER_PATH', 'ai-analyzer'),
```

The URI prefix for the AI Analyzer dashboard.

| Value | Example URL |
|:---|:---|
| `'ai-analyzer'` | `/ai-analyzer` |
| `'admin/ai'` | `/admin/ai` |
| `'debug'` | `/debug` |

## Authentication

```php
'auth_guard' => env('AI_ANALYZER_GUARD', 'web'),
```

The authentication guard used for access control.

```php
'middleware' => ['web'],
```

Middleware stack applied to all AI Analyzer routes. The `Authorize` middleware is automatically appended.

## Domain

```php
'domain' => env('AI_ANALYZER_DOMAIN', null),
```

Custom subdomain for AI Analyzer routes. `null` uses the application domain.

## Navigation

```php
'back_to_app_url' => env('AI_ANALYZER_BACK_TO_APP_URL', '/'),
```

Target URL for the "Back to App" link in the dashboard header.

## Agent Discovery

```php
'agent_directories' => [
    'app/AI/Agents',
    'app/Ai/Agents',
],
```

Directories scanned for agent classes. Relative to the application base path.

```php
'registry_cache_ttl' => 3600,
```

Cache duration for discovered agents (seconds). `0` disables caching.

## Currency

```php
'currency' => env('ANALYZER_CURRENCY', 'USD'),
'currency_symbol' => env('ANALYZER_CURRENCY_SYMBOL', '$'),
```

Default currency for cost calculations and display.

## Budget Monitoring

```php
'budget' => [
    'enabled' => env('ANALYZER_BUDGET_ENABLED', true),
    'notification_channels' => ['mail'],
],
```

| Option | Type | Default | Description |
|:---|:---|:---|:---|
| `enabled` | bool | `true` | Toggle budget alert system |
| `notification_channels` | array | `['mail']` | Channels for budget notifications |

## SDK Observability

```php
'observability' => [
    'enabled' => env('AI_ANALYZER_OBSERVABILITY_ENABLED', true),
    'store_runs' => env('AI_ANALYZER_STORE_RUNS', true),
    'capture_text_payloads' => env('AI_ANALYZER_CAPTURE_TEXT_PAYLOADS', true),
    'max_payload_length' => (int) env('AI_ANALYZER_MAX_PAYLOAD_LENGTH', 10000),
    'excluded_operations' => [],
],
```

| Option | Type | Default | Description |
|:---|:---|:---|:---|
| `enabled` | bool | `true` | Toggle SDK event listening |
| `store_runs` | bool | `true` | Persist runs to `analyzer_ai_runs` |
| `capture_text_payloads` | bool | `true` | Store prompt/response text |
| `max_payload_length` | int | `10000` | Character limit for stored text |
| `excluded_operations` | array | `[]` | Operation names to ignore |

## Prompt Lab

```php
'prompt-lab' => [
    'max_slots' => (int) env('ANALYZER_PROMPT_LAB_MAX_SLOTS', 3),
    'timeout_seconds' => (int) env('ANALYZER_PROMPT_LAB_TIMEOUT', 120),
],
```

| Option | Type | Default | Description |
|:---|:---|:---|:---|
| `max_slots` | int | `3` | Max provider+model combinations per comparison |
| `timeout_seconds` | int | `120` | Request timeout per slot |

## Sandbox

```php
'sandbox' => [
    'records_per_picker' => 20,
],
```

| Option | Type | Default | Description |
|:---|:---|:---|:---|
| `records_per_picker` | int | `20` | Records shown in Eloquent model pickers |

## Export

```php
'export' => [
    'pest_namespace' => env('ANALYZER_PEST_NAMESPACE', 'Tests\\Feature\\AI'),
    'json_format' => env('ANALYZER_JSON_FORMAT', 'openai'),
],
```

| Option | Type | Default | Description |
|:---|:---|:---|:---|
| `pest_namespace` | string | `Tests\\Feature\\AI` | Namespace for generated Pest tests |
| `json_format` | string | `openai` | Format for JSON exports |

## Audit

```php
'audit' => [
    'enabled' => env('ANALYZER_AUDIT_ENABLED', true),
    'retention_days' => (int) env('ANALYZER_RETENTION_DAYS', 90),
],
```

| Option | Type | Default | Description |
|:---|:---|:---|:---|
| `enabled` | bool | `true` | Toggle PII scanning and data retention |
| `retention_days` | int | `90` | Default data retention period |

## Environment Variables

| Variable | Config Key | Default | Description |
|:---|:---|:---|:---|
| `AI_ANALYZER_PATH` | `path` | `ai-analyzer` | Dashboard URI prefix |
| `AI_ANALYZER_GUARD` | `auth_guard` | `web` | Auth guard |
| `AI_ANALYZER_DOMAIN` | `domain` | `null` | Custom subdomain |
| `AI_ANALYZER_BACK_TO_APP_URL` | `back_to_app_url` | `/` | Back to app link |
| `ANALYZER_CURRENCY` | `currency` | `USD` | Currency code |
| `ANALYZER_CURRENCY_SYMBOL` | `currency_symbol` | `$` | Currency symbol |
| `ANALYZER_BUDGET_ENABLED` | `budget.enabled` | `true` | Budget alerts toggle |
| `ANALYZER_PROMPT_LAB_MAX_SLOTS` | `prompt-lab.max_slots` | `3` | Max comparison slots |
| `ANALYZER_PROMPT_LAB_TIMEOUT` | `prompt-lab.timeout_seconds` | `120` | Slot timeout |
| `AI_ANALYZER_OBSERVABILITY_ENABLED` | `observability.enabled` | `true` | SDK event listening toggle |
| `AI_ANALYZER_STORE_RUNS` | `observability.store_runs` | `true` | Persist runs toggle |
| `AI_ANALYZER_CAPTURE_TEXT_PAYLOADS` | `observability.capture_text_payloads` | `true` | Text capture toggle |
| `AI_ANALYZER_MAX_PAYLOAD_LENGTH` | `observability.max_payload_length` | `10000` | Max payload length |
| `ANALYZER_PEST_NAMESPACE` | `export.pest_namespace` | `Tests\Feature\AI` | Pest namespace |
| `ANALYZER_JSON_FORMAT` | `export.json_format` | `openai` | JSON export format |
| `ANALYZER_AUDIT_ENABLED` | `audit.enabled` | `true` | Audit toggle |
| `ANALYZER_RETENTION_DAYS` | `audit.retention_days` | `90` | Retention period |

## Full Config File

```php
<?php

return [
    'path' => env('AI_ANALYZER_PATH', 'ai-analyzer'),
    'auth_guard' => env('AI_ANALYZER_GUARD', 'web'),
    'middleware' => ['web'],
    'domain' => env('AI_ANALYZER_DOMAIN', null),
    'back_to_app_url' => env('AI_ANALYZER_BACK_TO_APP_URL', '/'),
    
    'agent_directories' => [
        'app/AI/Agents',
        'app/Ai/Agents',
    ],
    
    'registry_cache_ttl' => 3600,
    
    'currency' => env('ANALYZER_CURRENCY', 'USD'),
    'currency_symbol' => env('ANALYZER_CURRENCY_SYMBOL', '$'),
    
    'budget' => [
        'enabled' => env('ANALYZER_BUDGET_ENABLED', true),
        'notification_channels' => ['mail'],
    ],
    
    'observability' => [
        'enabled' => env('AI_ANALYZER_OBSERVABILITY_ENABLED', true),
        'store_runs' => env('AI_ANALYZER_STORE_RUNS', true),
        'capture_text_payloads' => env('AI_ANALYZER_CAPTURE_TEXT_PAYLOADS', true),
        'max_payload_length' => (int) env('AI_ANALYZER_MAX_PAYLOAD_LENGTH', 10000),
        'excluded_operations' => [],
    ],
    
    'prompt-lab' => [
        'max_slots' => (int) env('ANALYZER_PROMPT_LAB_MAX_SLOTS', 3),
        'timeout_seconds' => (int) env('ANALYZER_PROMPT_LAB_TIMEOUT', 120),
    ],
    
    'sandbox' => [
        'records_per_picker' => 20,
    ],
    
    'export' => [
        'pest_namespace' => env('ANALYZER_PEST_NAMESPACE', 'Tests\\Feature\\AI'),
        'json_format' => env('ANALYZER_JSON_FORMAT', 'openai'),
    ],
    
    'audit' => [
        'enabled' => env('ANALYZER_AUDIT_ENABLED', true),
        'retention_days' => (int) env('ANALYZER_RETENTION_DAYS', 90),
    ],
];
```

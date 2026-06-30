# Configuration

AI Pulse works out of the box with sensible defaults, but every aspect can be customized via the published config file.

## Publish the Config

The `ai-pulse:install` command publishes the configuration file for you. To publish only the configuration file:

```bash
php artisan vendor:publish --tag=ai-pulse-config
```

This creates `config/ai-pulse.php` in your application.

## Config Reference

### Dashboard Path

```php
'path' => env('AI_PULSE_PATH', 'ai-pulse'),
```

The URI prefix where the AI Pulse dashboard is accessible. Change this to anything you like:

```php
'path' => 'admin/ai-pulse',    // Accessible at /admin/ai-pulse
'path' => 'debug/ai',          // Accessible at /debug/ai
```

### Authentication Guard

```php
'auth_guard' => env('AI_PULSE_GUARD', 'web'),
```

The authentication guard used when checking access. Defaults to your application's `web` guard.

### Route Middleware

```php
'middleware' => ['web'],
```

Middleware applied to all AI Pulse routes. The `web` middleware is always included automatically. Add `auth` or custom middleware here:

```php
'middleware' => ['web', 'auth', 'verified'],
```

### Custom Domain

```php
'domain' => env('AI_PULSE_DOMAIN', null),
```

Set a custom subdomain for AI Pulse routes. Leave `null` to use the same domain as your application.

```php
'domain' => 'pulse.myapp.test',
```

### Back to App URL

```php
'back_to_app_url' => env('AI_PULSE_BACK_TO_APP_URL', '/'),
```

The target URL for the **"Back to App"** link in the AI Pulse header.

### Agent Discovery

```php
'agent_directories' => [
    'app/AI/Agents',
    'app/Ai/Agents',
],
```

Directories that AI Pulse scans to discover agent classes. Paths are relative to your application's base path. AI Pulse uses PHP's tokenizer to extract class names without loading the files.

```php
'agent_directories' => [
    'app/AI/Agents',
    'app/Domain/Agents',
    'modules/*/Agents',
],
```

### Registry Cache TTL

```php
'registry_cache_ttl' => 3600,
```

Number of seconds to cache discovered agent metadata. Set to `0` to disable caching entirely. The cache stores:

- Discovered agent class names
- Per-agent metadata (instructions, tools, temperature, schema support)

Clear the cache with:

```php
app(\Syedmahroof\AiPulse\Contracts\AgentRegistryContract::class)->refresh();
```

### Currency

```php
'currency' => env('PULSE_CURRENCY', 'USD'),
'currency_symbol' => env('PULSE_CURRENCY_SYMBOL', '$'),
```

The default currency and symbol used for cost calculations and display throughout the dashboard.

### Budget Monitoring

```php
'budget' => [
    'enabled' => env('PULSE_BUDGET_ENABLED', true),
    'notification_channels' => ['mail'],
],
```

Configure the budget alert system. Notifications are dispatched via Laravel's queue system (non-blocking) so they never slow down requests.

### SDK Observability

```php
'observability' => [
    'enabled' => env('AI_PULSE_OBSERVABILITY_ENABLED', true),
    'store_runs' => env('AI_PULSE_STORE_RUNS', true),
    'capture_text_payloads' => env('AI_PULSE_CAPTURE_TEXT_PAYLOADS', true),
    'max_payload_length' => (int) env('AI_PULSE_MAX_PAYLOAD_LENGTH', 10000),
    'excluded_operations' => [],
],
```

Control how AI Pulse listens to Laravel AI SDK events:

| Option | Default | Description |
|:---|:---|:---|
| `enabled` | `true` | Master toggle for SDK event listening |
| `store_runs` | `true` | Persist one-off runs to `pulse_ai_runs` |
| `capture_text_payloads` | `true` | Store prompt/response text |
| `max_payload_length` | `10000` | Character limit for stored text |
| `excluded_operations` | `[]` | Operation names to ignore |

### Prompt Lab

```php
'prompt-lab' => [
    'max_slots' => (int) env('PULSE_PROMPT_LAB_MAX_SLOTS', 3),
    'timeout_seconds' => (int) env('PULSE_PROMPT_LAB_TIMEOUT', 120),
],
```

Settings for the Prompt Lab comparison feature:

- **`max_slots`** — Maximum number of provider+model combinations per comparison (default: 3)
- **`timeout_seconds`** — Request timeout per comparison slot (default: 120)

### Sandbox

```php
'sandbox' => [
    'records_per_picker' => 20,
],
```

Controls the number of records shown in Eloquent model picker dropdowns within the Agent Sandbox.

### Export

```php
'export' => [
    'pest_namespace' => env('PULSE_PEST_NAMESPACE', 'Tests\\Feature\\AI'),
    'json_format' => env('PULSE_JSON_FORMAT', 'openai'),
],
```

Settings for conversation export:

- **`pest_namespace`** — Namespace used when generating Pest test files
- **`json_format`** — Format for JSON exports (`openai` for fine-tuning)

### Audit

```php
'audit' => [
    'enabled' => env('PULSE_AUDIT_ENABLED', true),
    'retention_days' => (int) env('PULSE_RETENTION_DAYS', 90),
],
```

Security audit and compliance settings:

- **`enabled`** — Toggle for PII scanning and data retention features
- **`retention_days`** — Default data retention period for automatic cleanup

## Environment Variables

You can control most settings via `.env`:

```env
AI_PULSE_PATH=ai-pulse
AI_PULSE_GUARD=web
AI_PULSE_DOMAIN=null
AI_PULSE_BACK_TO_APP_URL=/

PULSE_CURRENCY=USD
PULSE_CURRENCY_SYMBOL=$

PULSE_BUDGET_ENABLED=true
PULSE_PROMPT_LAB_MAX_SLOTS=3
PULSE_PROMPT_LAB_TIMEOUT=120

AI_PULSE_OBSERVABILITY_ENABLED=true
AI_PULSE_STORE_RUNS=true
AI_PULSE_CAPTURE_TEXT_PAYLOADS=true
AI_PULSE_MAX_PAYLOAD_LENGTH=10000

PULSE_PEST_NAMESPACE="Tests\\Feature\\AI"
PULSE_JSON_FORMAT=openai

PULSE_AUDIT_ENABLED=true
PULSE_RETENTION_DAYS=90
```

## Programmatic Access

Use the `PulseConfig` support class to read configuration safely:

```php
use Syedmahroof\AiPulse\Support\PulseConfig;

PulseConfig::path();           // 'ai-pulse'
PulseConfig::guard();          // 'web'
PulseConfig::middleware();     // ['web']
PulseConfig::agentDirs();      // ['/path/to/app/AI/Agents', ...]
PulseConfig::domain();         // null
PulseConfig::registryCacheTtl(); // 3600
PulseConfig::backToAppUrl();   // '/'
```

All methods return sensible defaults if the config file hasn't been published.

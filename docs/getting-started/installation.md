# Installation

Getting started with Laravel AI Analyzer takes less than a minute. The package auto-discovers and requires zero frontend build steps.

## Requirements

Before installing, make sure your environment meets the following:

| Requirement | Version | Notes |
|:---|:---|:---|
| PHP | `^8.3` | Required by the Laravel AI SDK |
| Laravel | `^12.0 \| ^13.0` | Framework version |
| Laravel AI SDK | `^0.6\|^0.7\|^0.8` | `laravel/ai` package with migrations run |
| Livewire | `^4.0` | Auto-installed as a dependency |

> **Important:** The Laravel AI SDK (`laravel/ai`) must be installed and its migrations must have been run. AI Analyzer reads directly from the SDK's `agent_conversations` and `agent_conversation_messages` tables.

## Install via Composer

```bash
composer require syedmahroof/ai-analyzer
```

After installing AI Analyzer, publish its assets and configuration using the `ai-analyzer:install` Artisan command. After installing AI Analyzer, you should also run the `migrate` command to create the tables needed to store AI Analyzer's data:

```bash
php artisan ai-analyzer:install
php artisan migrate
```

AI Analyzer creates the following tables (all prefixed with `analyzer_`):

| Table | Purpose |
|:---|:---|
| `analyzer_pricing_rules` | Editable cost per token per model |
| `analyzer_saved_prompts` | Prompt library with tags and metadata |
| `analyzer_bookmarks` | Starred conversations |
| `analyzer_prompt_lab_sessions` | Prompt Lab comparison history |
| `analyzer_budget_alerts` | Budget thresholds and notifications |
| `analyzer_ai_runs` | One-off SDK run observability |

## Access the Dashboard

Visit `/ai-analyzer` in your browser:

```
http://your-app.test/ai-analyzer
```

By default, AI Analyzer is only accessible in the `local` environment. See [Authorization](/getting-started/authorization) to configure access for production.

## Health Check

If you see a friendly setup banner instead of the dashboard, it usually means the Laravel AI SDK tables haven't been created yet. Run:

```bash
php artisan migrate
```

AI Analyzer performs an automatic health check on boot and surfaces any issues clearly in the UI.

## Next Steps

- [Configure AI Analyzer](/getting-started/configuration) — customize the path, middleware, and features
- [Set Up Authorization](/getting-started/authorization) — control who can access the dashboard
- [Explore the Dashboard](/features/dashboard) — see what AI Analyzer can do

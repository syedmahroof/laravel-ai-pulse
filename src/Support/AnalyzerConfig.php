<?php

namespace Syedmahroof\AiAnalyzer\Support;

use Illuminate\Support\Facades\Config;

class AnalyzerConfig
{
    /**
     * Get the configured dashboard URI path.
     */
    public static function path(): string
    {
        return Config::get('ai-analyzer.path') ?: 'ai-analyzer';
    }

    /**
     * Get the configured authentication guard.
     */
    public static function guard(): string
    {
        return Config::get('ai-analyzer.auth_guard', 'web');
    }

    /**
     * Get the configured route middleware stack.
     *
     * @return array<int, string>
     */
    public static function middleware(): array
    {
        return Config::get('ai-analyzer.middleware', ['web']);
    }

    /**
     * Get the configured agent discovery directories.
     *
     * @return array<int, string>
     */
    public static function agentDirs(): array
    {
        $dirs = Config::get('ai-analyzer.agent_directories', []);

        if (function_exists('base_path')) {
            return array_map(fn (string $dir): string => base_path($dir), $dirs);
        }

        return $dirs;
    }

    /**
     * Get the configured dashboard domain.
     */
    public static function domain(): ?string
    {
        return Config::get('ai-analyzer.domain');
    }

    /**
     * Get the configured agent registry cache TTL.
     */
    public static function registryCacheTtl(): int
    {
        return (int) Config::get('ai-analyzer.registry_cache_ttl', 3600);
    }

    /**
     * Get the configured back-to-app URL.
     */
    public static function backToAppUrl(): string
    {
        return Config::get('ai-analyzer.back_to_app_url', '/');
    }
}

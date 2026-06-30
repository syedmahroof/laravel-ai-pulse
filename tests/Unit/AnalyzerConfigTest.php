<?php

use Syedmahroof\AiAnalyzer\Support\AnalyzerConfig;
use Illuminate\Support\Facades\Config;

it('returns configured path', function () {
    expect(AnalyzerConfig::path())->toBe('ai-analyzer');
});

it('returns default path when not configured', function () {
    Config::offsetUnset('ai-analyzer.path');

    expect(AnalyzerConfig::path())->toBe('ai-analyzer');
});

it('returns configured auth guard', function () {
    Config::set('ai-analyzer.auth_guard', 'api');

    expect(AnalyzerConfig::guard())->toBe('api');
});

it('returns configured middleware stack', function () {
    Config::set('ai-analyzer.middleware', ['web', 'auth:api']);

    expect(AnalyzerConfig::middleware())->toBe(['web', 'auth:api']);
});

it('returns configured domain', function () {
    Config::set('ai-analyzer.domain', 'analyzer.example.com');

    expect(AnalyzerConfig::domain())->toBe('analyzer.example.com');
});

it('returns null domain by default', function () {
    expect(AnalyzerConfig::domain())->toBeNull();
});

it('resolves agent directories with base_path', function () {
    Config::set('ai-analyzer.agent_directories', ['app/AI/Agents']);

    $dirs = AnalyzerConfig::agentDirs();

    expect($dirs[0])->toContain('app/AI/Agents');
});

<?php

use Syedmahroof\AiPulse\Support\PulseConfig;
use Illuminate\Support\Facades\Config;

it('returns configured path', function () {
    expect(PulseConfig::path())->toBe('ai-pulse');
});

it('returns default path when not configured', function () {
    Config::offsetUnset('ai-pulse.path');

    expect(PulseConfig::path())->toBe('ai-pulse');
});

it('returns configured auth guard', function () {
    Config::set('ai-pulse.auth_guard', 'api');

    expect(PulseConfig::guard())->toBe('api');
});

it('returns configured middleware stack', function () {
    Config::set('ai-pulse.middleware', ['web', 'auth:api']);

    expect(PulseConfig::middleware())->toBe(['web', 'auth:api']);
});

it('returns configured domain', function () {
    Config::set('ai-pulse.domain', 'pulse.example.com');

    expect(PulseConfig::domain())->toBe('pulse.example.com');
});

it('returns null domain by default', function () {
    expect(PulseConfig::domain())->toBeNull();
});

it('resolves agent directories with base_path', function () {
    Config::set('ai-pulse.agent_directories', ['app/AI/Agents']);

    $dirs = PulseConfig::agentDirs();

    expect($dirs[0])->toContain('app/AI/Agents');
});

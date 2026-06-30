<?php

use Syedmahroof\AiPulse\Contracts\AgentRegistryContract;
use Syedmahroof\AiPulse\Services\AgentRegistry;

it('registers the service provider and merges config', function () {
    expect(config('ai-pulse.path'))->toBe('ai-pulse');
    expect(config('ai-pulse.auth_guard'))->toBe('web');
});

it('binds AgentRegistryContract', function () {
    $registry = app(AgentRegistryContract::class);

    expect($registry)->toBeInstanceOf(AgentRegistry::class);
});

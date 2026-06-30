<?php

use Syedmahroof\AiAnalyzer\Contracts\AgentRegistryContract;
use Syedmahroof\AiAnalyzer\Services\AgentRegistry;

it('registers the service provider and merges config', function () {
    expect(config('ai-analyzer.path'))->toBe('ai-analyzer');
    expect(config('ai-analyzer.auth_guard'))->toBe('web');
});

it('binds AgentRegistryContract', function () {
    $registry = app(AgentRegistryContract::class);

    expect($registry)->toBeInstanceOf(AgentRegistry::class);
});

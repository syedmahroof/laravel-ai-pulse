<?php

use Illuminate\Support\Collection;
use Syedmahroof\AiPulse\Services\AgentRegistry;

it('returns empty collection when no agents exist', function () {
    $registry = app(AgentRegistry::class);

    $agents = $registry->all();

    expect($agents)->toBeInstanceOf(Collection::class);
    expect($agents)->toHaveCount(0);
});

it('handles non-existent directories gracefully', function () {
    config()->set('ai-pulse.agent_directories', ['/nonexistent/path']);

    $registry = app(AgentRegistry::class);
    $agents = $registry->all();

    expect($agents)->toHaveCount(0);
});

it('returns null for non-existent agent class', function () {
    $registry = app(AgentRegistry::class);

    $result = $registry->find('NonExistent\\Agent');

    expect($result)->toBeNull();
});

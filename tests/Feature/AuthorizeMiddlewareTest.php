<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Syedmahroof\AiPulse\Http\Middleware\Authorize;
use Symfony\Component\HttpKernel\Exception\HttpException;

beforeEach(function () {
    Gate::define('viewAiPulse', fn ($user = null) => false);
});

it('blocks unauthorized users with 403', function () {
    $request = Request::create('/ai-pulse', 'GET');

    $this->expectException(HttpException::class);

    (new Authorize)->handle($request, fn () => response('ok'));
});

it('allows authorized users', function () {
    Gate::define('viewAiPulse', fn ($user = null) => true);

    $request = Request::create('/ai-pulse', 'GET');
    $response = (new Authorize)->handle($request, fn () => response('ok'));

    expect($response->getStatusCode())->toBe(200);
});

<?php

namespace Syedmahroof\AiPulse\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Syedmahroof\AiPulse\Support\PulseConfig;

class Authorize
{
    /**
     * Handle the incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::guard(PulseConfig::guard())->user();

        if (! Gate::check('viewAiPulse', [$user])) {
            abort(403);
        }

        return $next($request);
    }
}

<?php

namespace Syedmahroof\AiPulse\Http\Middleware;

use Syedmahroof\AiPulse\Support\PulseConfig;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

<?php

namespace Syedmahroof\AiAnalyzer\Http\Middleware;

use Syedmahroof\AiAnalyzer\Support\AnalyzerConfig;
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
        $user = Auth::guard(AnalyzerConfig::guard())->user();

        if (! Gate::check('viewAiAnalyzer', [$user])) {
            abort(403);
        }

        return $next($request);
    }
}

<?php

namespace Syedmahroof\AiPulse\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Syedmahroof\AiPulse\Contracts\AgentRegistryContract;

class PlaygroundController extends Controller
{
    /**
     * Display the agent list.
     */
    public function index(): View
    {
        $registry = app(AgentRegistryContract::class);

        return view('ai-pulse::playground.index', [
            'agents' => $registry->all(),
        ]);
    }

    /**
     * Display the sandbox for a specific agent.
     */
    public function show(string $agent): View
    {
        return view('ai-pulse::playground.show', [
            'agent' => $agent,
            'isPro' => true,
        ]);
    }
}

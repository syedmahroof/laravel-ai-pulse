<?php

namespace Syedmahroof\AiPulse\Http\Controllers;

use Syedmahroof\AiPulse\Contracts\AgentRegistryContract;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

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

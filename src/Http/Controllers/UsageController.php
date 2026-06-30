<?php

namespace Syedmahroof\AiPulse\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class UsageController extends Controller
{
    /**
     * Display the usage page.
     */
    public function index(): View
    {
        return view('ai-pulse::usage.index');
    }

    /**
     * Display the pricing matrix.
     */
    public function pricing(): View
    {
        return view('ai-pulse::usage.pricing');
    }

    /**
     * Display the budget alerts.
     */
    public function alerts(): View
    {
        return view('ai-pulse::usage.alerts');
    }

    /**
     * Display the provider health panel.
     */
    public function health(): View
    {
        return view('ai-pulse::usage.health');
    }
}

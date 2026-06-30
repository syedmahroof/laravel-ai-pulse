<?php

namespace Syedmahroof\AiPulse\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Display the AI Pulse dashboard.
     */
    public function index(): View
    {
        return view('ai-pulse::dashboard');
    }
}

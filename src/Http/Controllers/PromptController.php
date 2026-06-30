<?php

namespace Syedmahroof\AiPulse\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class PromptController extends Controller
{
    public function index(): View
    {
        return view('ai-pulse::prompts.index');
    }
}

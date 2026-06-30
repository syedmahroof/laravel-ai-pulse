<?php

namespace Syedmahroof\AiAnalyzer\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class PromptController extends Controller
{
    public function index(): View
    {
        return view('ai-analyzer::prompts.index');
    }
}

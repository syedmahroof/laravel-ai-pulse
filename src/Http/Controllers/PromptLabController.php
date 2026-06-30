<?php

namespace Syedmahroof\AiPulse\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Syedmahroof\AiPulse\Models\PromptLabSession;

class PromptLabController extends Controller
{
    public function index(): View
    {
        $sessions = PromptLabSession::orderBy('created_at', 'desc')->paginate(15);

        return view('ai-pulse::prompt-lab.index', [
            'sessions' => $sessions,
        ]);
    }

    public function show(string $id): View
    {
        $session = PromptLabSession::findOrFail($id);

        return view('ai-pulse::prompt-lab.show', [
            'session' => $session,
        ]);
    }
}

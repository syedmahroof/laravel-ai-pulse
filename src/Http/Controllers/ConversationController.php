<?php

namespace Syedmahroof\AiPulse\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class ConversationController extends Controller
{
    /**
     * Display the thread explorer.
     */
    public function index(): View
    {
        return view('ai-pulse::conversations.index', [
            'useProExplorer' => true,
        ]);
    }

    /**
     * Display the message timeline for a conversation.
     */
    public function show(string $id): View
    {
        return view('ai-pulse::conversations.show', ['id' => $id]);
    }
}

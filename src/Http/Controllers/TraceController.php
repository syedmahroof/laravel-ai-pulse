<?php

namespace Syedmahroof\AiAnalyzer\Http\Controllers;

use Syedmahroof\AiAnalyzer\Services\ConversationRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class TraceController extends Controller
{
    /**
     * Display the execution trace for a conversation.
     */
    public function show(string $id, ConversationRepository $repository): View
    {
        $conversation = $repository->find($id);

        if ($conversation === null) {
            abort(404);
        }

        return view('ai-analyzer::traces.show', [
            'conversation' => $conversation,
            'messages' => $conversation->messages ?? collect(),
            'isPro' => true,
        ]);
    }
}

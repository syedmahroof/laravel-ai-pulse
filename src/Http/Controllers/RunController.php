<?php

namespace Syedmahroof\AiAnalyzer\Http\Controllers;

use Syedmahroof\AiAnalyzer\Services\AiRunRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class RunController extends Controller
{
    public function index(): View
    {
        return view('ai-analyzer::runs.index');
    }

    public function show(string $id, AiRunRepository $runs): View
    {
        $run = $runs->find($id);

        abort_unless($run !== null, 404);

        return view('ai-analyzer::runs.show', ['run' => $run]);
    }
}

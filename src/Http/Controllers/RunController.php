<?php

namespace Syedmahroof\AiPulse\Http\Controllers;

use Syedmahroof\AiPulse\Services\AiRunRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class RunController extends Controller
{
    public function index(): View
    {
        return view('ai-pulse::runs.index');
    }

    public function show(string $id, AiRunRepository $runs): View
    {
        $run = $runs->find($id);

        abort_unless($run !== null, 404);

        return view('ai-pulse::runs.show', ['run' => $run]);
    }
}

<?php

use Syedmahroof\AiPulse\Http\Controllers\AuditController;
use Syedmahroof\AiPulse\Http\Controllers\ConversationController;
use Syedmahroof\AiPulse\Http\Controllers\DashboardController;
use Syedmahroof\AiPulse\Http\Controllers\ExportController;
use Syedmahroof\AiPulse\Http\Controllers\PlaygroundController;
use Syedmahroof\AiPulse\Http\Controllers\PromptController;
use Syedmahroof\AiPulse\Http\Controllers\PromptLabController;
use Syedmahroof\AiPulse\Http\Controllers\RunController;
use Syedmahroof\AiPulse\Http\Controllers\TraceController;
use Syedmahroof\AiPulse\Http\Controllers\UsageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('pulse.dashboard');
Route::get('/conversations', [ConversationController::class, 'index'])->name('pulse.conversations.index');
Route::get('/conversations/{id}', [ConversationController::class, 'show'])->name('pulse.conversations.show');
Route::get('/runs', [RunController::class, 'index'])->name('pulse.runs.index');
Route::get('/runs/{id}', [RunController::class, 'show'])->name('pulse.runs.show');
Route::get('/playground', [PlaygroundController::class, 'index'])->name('pulse.playground.index');
Route::get('/playground/{agent}', [PlaygroundController::class, 'show'])->name('pulse.playground.show');
Route::get('/traces/{id}', [TraceController::class, 'show'])->name('pulse.traces.show');

Route::get('/prompt-lab', [PromptLabController::class, 'index'])->name('pulse.prompt-lab.index');
Route::get('/prompt-lab/session/{id}', [PromptLabController::class, 'show'])->name('pulse.prompt-lab.show');

Route::get('/usage', [UsageController::class, 'index'])->name('pulse.usage.index');
Route::get('/usage/pricing', [UsageController::class, 'pricing'])->name('pulse.usage.pricing');
Route::get('/usage/alerts', [UsageController::class, 'alerts'])->name('pulse.usage.alerts');
Route::get('/usage/health', [UsageController::class, 'health'])->name('pulse.usage.health');

Route::get('/audit', [AuditController::class, 'index'])->name('pulse.audit.index');

Route::post('/export/pest/{id}', [ExportController::class, 'pest'])->name('pulse.export.pest');
Route::post('/export/json/{id}', [ExportController::class, 'json'])->name('pulse.export.json');

Route::get('/prompts', [PromptController::class, 'index'])->name('pulse.prompts.index');

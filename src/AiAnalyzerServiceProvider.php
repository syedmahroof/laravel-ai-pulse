<?php

namespace Syedmahroof\AiAnalyzer;

use Syedmahroof\AiAnalyzer\Console\InstallCommand;
use Syedmahroof\AiAnalyzer\Contracts\AgentRegistryContract;
use Syedmahroof\AiAnalyzer\Http\Livewire\AgentInspector;
use Syedmahroof\AiAnalyzer\Http\Livewire\AgentSandbox;
use Syedmahroof\AiAnalyzer\Http\Livewire\AuditDashboard;
use Syedmahroof\AiAnalyzer\Http\Livewire\BudgetAlerts;
use Syedmahroof\AiAnalyzer\Http\Livewire\CostDashboard;
use Syedmahroof\AiAnalyzer\Http\Livewire\MessageTimeline;
use Syedmahroof\AiAnalyzer\Http\Livewire\PricingMatrix;
use Syedmahroof\AiAnalyzer\Http\Livewire\PromptLab;
use Syedmahroof\AiAnalyzer\Http\Livewire\PromptLibrary;
use Syedmahroof\AiAnalyzer\Http\Livewire\ProviderHealth;
use Syedmahroof\AiAnalyzer\Http\Livewire\RunExplorer;
use Syedmahroof\AiAnalyzer\Http\Livewire\ThreadExplorer;
use Syedmahroof\AiAnalyzer\Http\Livewire\TodayStats;
use Syedmahroof\AiAnalyzer\Http\Middleware\Authorize;
use Syedmahroof\AiAnalyzer\Services\AgentRegistry;
use Syedmahroof\AiAnalyzer\Services\AiRunRecorder;
use Syedmahroof\AiAnalyzer\Services\BudgetMonitor;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Ai\Events\AddingFileToStore;
use Laravel\Ai\Events\AgentFailedOver;
use Laravel\Ai\Events\AgentPrompted;
use Laravel\Ai\Events\AgentStreamed;
use Laravel\Ai\Events\AudioGenerated;
use Laravel\Ai\Events\CreatingStore;
use Laravel\Ai\Events\EmbeddingsGenerated;
use Laravel\Ai\Events\FileAddedToStore;
use Laravel\Ai\Events\FileDeleted;
use Laravel\Ai\Events\FileRemovedFromStore;
use Laravel\Ai\Events\FileStored;
use Laravel\Ai\Events\GeneratingAudio;
use Laravel\Ai\Events\GeneratingEmbeddings;
use Laravel\Ai\Events\GeneratingImage;
use Laravel\Ai\Events\GeneratingTranscription;
use Laravel\Ai\Events\ImageGenerated;
use Laravel\Ai\Events\InvokingTool;
use Laravel\Ai\Events\PromptingAgent;
use Laravel\Ai\Events\ProviderFailedOver;
use Laravel\Ai\Events\RemovingFileFromStore;
use Laravel\Ai\Events\Reranked;
use Laravel\Ai\Events\Reranking;
use Laravel\Ai\Events\StoreCreated;
use Laravel\Ai\Events\StoreDeleted;
use Laravel\Ai\Events\StoringFile;
use Laravel\Ai\Events\StreamingAgent;
use Laravel\Ai\Events\ToolInvoked;
use Laravel\Ai\Events\TranscriptionGenerated;
use Livewire\Livewire;

class AiAnalyzerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ai-analyzer.php', 'ai-analyzer'
        );

        $this->app->singleton(AiAnalyzer::class);

        $this->app->singleton(
            AgentRegistryContract::class,
            AgentRegistry::class
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->loadRoutes();
        $this->loadViews();
        $this->defineGate();
        $this->registerPublishables();
        $this->registerLivewireComponents();
        $this->registerAiEventListeners();
        $this->registerCommands();
    }

    /**
     * Register the package routes.
     */
    protected function loadRoutes(): void
    {
        Route::group($this->routeConfiguration(), function (): void {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Get the route configuration.
     *
     * @return array{domain: string|null, prefix: string, middleware: array<int, string>}
     */
    protected function routeConfiguration(): array
    {
        return [
            'domain' => config('ai-analyzer.domain'),
            'prefix' => config('ai-analyzer.path', 'ai-analyzer'),
            'middleware' => array_merge(
                config('ai-analyzer.middleware', ['web']),
                [Authorize::class]
            ),
        ];
    }

    /**
     * Load the package views.
     */
    protected function loadViews(): void
    {
        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'ai-analyzer'
        );
    }

    /**
     * Define the access Gate for the AI Analyzer dashboard.
     */
    protected function defineGate(): void
    {
        Gate::define('viewAiAnalyzer', function ($user = null) {
            return $this->app->environment('local');
        });
    }

    /**
     * Register publishable resources.
     */
    protected function registerPublishables(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/ai-analyzer.php' => config_path('ai-analyzer.php'),
        ], 'ai-analyzer-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ai-analyzer'),
        ], 'ai-analyzer-views');

        $this->publishes([
            __DIR__.'/../dist' => public_path('vendor/ai-analyzer'),
        ], 'ai-analyzer-assets');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'ai-analyzer-migrations');
    }

    protected function registerCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }

    /**
     * Register the package Livewire components.
     */
    protected function registerLivewireComponents(): void
    {
        Livewire::component('ai-analyzer.today-stats', TodayStats::class);
        Livewire::component('ai-analyzer.thread-explorer', ThreadExplorer::class);
        Livewire::component('ai-analyzer.run-explorer', RunExplorer::class);
        Livewire::component('ai-analyzer.message-timeline', MessageTimeline::class);
        Livewire::component('ai-analyzer.agent-sandbox', AgentSandbox::class);
        Livewire::component('ai-analyzer.agent-inspector', AgentInspector::class);
        Livewire::component('ai-analyzer.prompt-lab', PromptLab::class);
        Livewire::component('ai-analyzer.audit-dashboard', AuditDashboard::class);
        Livewire::component('ai-analyzer.cost-dashboard', CostDashboard::class);
        Livewire::component('ai-analyzer.pricing-matrix', PricingMatrix::class);
        Livewire::component('ai-analyzer.budget-alerts', BudgetAlerts::class);
        Livewire::component('ai-analyzer.provider-health', ProviderHealth::class);
        Livewire::component('ai-analyzer.prompt-library', PromptLibrary::class);
    }

    /**
     * Register Laravel AI SDK observability listeners.
     */
    protected function registerAiEventListeners(): void
    {
        if (! config('ai-analyzer.observability.enabled', true)) {
            return;
        }

        if (! config('ai-analyzer.observability.store_runs', true) && ! config('ai-analyzer.budget.enabled', true)) {
            return;
        }

        $events = $this->app->make(Dispatcher::class);

        $startingEvents = [
            PromptingAgent::class => 'agent_text',
            StreamingAgent::class => 'agent_stream',
            GeneratingImage::class => 'image',
            GeneratingAudio::class => 'audio',
            GeneratingTranscription::class => 'transcription',
            GeneratingEmbeddings::class => 'embeddings',
            Reranking::class => 'reranking',
            StoringFile::class => 'file',
            CreatingStore::class => 'store',
            AddingFileToStore::class => 'store_file',
            RemovingFileFromStore::class => 'store_file',
        ];

        foreach ($startingEvents as $event => $operation) {
            $events->listen($event, function (object $event) use ($operation): void {
                $this->app->make(AiRunRecorder::class)->recordStarting($event, $operation);
            });
        }

        $completedEvents = [
            AgentPrompted::class => 'agent_text',
            AgentStreamed::class => 'agent_stream',
            ImageGenerated::class => 'image',
            AudioGenerated::class => 'audio',
            TranscriptionGenerated::class => 'transcription',
            EmbeddingsGenerated::class => 'embeddings',
            Reranked::class => 'reranking',
            FileStored::class => 'file',
            FileDeleted::class => 'file',
            StoreCreated::class => 'store',
            StoreDeleted::class => 'store',
            FileAddedToStore::class => 'store_file',
            FileRemovedFromStore::class => 'store_file',
        ];

        foreach ($completedEvents as $event => $operation) {
            $events->listen($event, function (object $event) use ($operation): void {
                $this->app->make(AiRunRecorder::class)->recordCompleted($event, $operation);
                $this->app->make(BudgetMonitor::class)->checkCompletedEvent($event);
            });
        }

        $events->listen(InvokingTool::class, function (InvokingTool $event): void {
            $this->app->make(AiRunRecorder::class)->recordToolEvent($event);
        });

        $events->listen(ToolInvoked::class, function (ToolInvoked $event): void {
            $this->app->make(AiRunRecorder::class)->recordToolEvent($event);
        });

        $events->listen(ProviderFailedOver::class, function (ProviderFailedOver $event): void {
            $this->app->make(AiRunRecorder::class)->recordFailover($event);
        });

        $events->listen(AgentFailedOver::class, function (AgentFailedOver $event): void {
            $this->app->make(AiRunRecorder::class)->recordFailover($event);
        });
    }
}

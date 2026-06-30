<?php

namespace Syedmahroof\AiPulse;

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
use Syedmahroof\AiPulse\Console\InstallCommand;
use Syedmahroof\AiPulse\Contracts\AgentRegistryContract;
use Syedmahroof\AiPulse\Http\Livewire\AgentInspector;
use Syedmahroof\AiPulse\Http\Livewire\AgentSandbox;
use Syedmahroof\AiPulse\Http\Livewire\AuditDashboard;
use Syedmahroof\AiPulse\Http\Livewire\BudgetAlerts;
use Syedmahroof\AiPulse\Http\Livewire\CostDashboard;
use Syedmahroof\AiPulse\Http\Livewire\MessageTimeline;
use Syedmahroof\AiPulse\Http\Livewire\PricingMatrix;
use Syedmahroof\AiPulse\Http\Livewire\PromptLab;
use Syedmahroof\AiPulse\Http\Livewire\PromptLibrary;
use Syedmahroof\AiPulse\Http\Livewire\ProviderHealth;
use Syedmahroof\AiPulse\Http\Livewire\RunExplorer;
use Syedmahroof\AiPulse\Http\Livewire\ThreadExplorer;
use Syedmahroof\AiPulse\Http\Livewire\TodayStats;
use Syedmahroof\AiPulse\Http\Middleware\Authorize;
use Syedmahroof\AiPulse\Services\AgentRegistry;
use Syedmahroof\AiPulse\Services\AiRunRecorder;
use Syedmahroof\AiPulse\Services\BudgetMonitor;

class AiPulseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ai-pulse.php', 'ai-pulse'
        );

        $this->app->singleton(AiPulse::class);

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
            'domain' => config('ai-pulse.domain'),
            'prefix' => config('ai-pulse.path', 'ai-pulse'),
            'middleware' => array_merge(
                config('ai-pulse.middleware', ['web']),
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
            __DIR__.'/../resources/views', 'ai-pulse'
        );
    }

    /**
     * Define the access Gate for the AI Pulse dashboard.
     */
    protected function defineGate(): void
    {
        Gate::define('viewAiPulse', function ($user = null) {
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
            __DIR__.'/../config/ai-pulse.php' => config_path('ai-pulse.php'),
        ], 'ai-pulse-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ai-pulse'),
        ], 'ai-pulse-views');

        $this->publishes([
            __DIR__.'/../dist' => public_path('vendor/ai-pulse'),
        ], 'ai-pulse-assets');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'ai-pulse-migrations');
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
        Livewire::component('ai-pulse.today-stats', TodayStats::class);
        Livewire::component('ai-pulse.thread-explorer', ThreadExplorer::class);
        Livewire::component('ai-pulse.run-explorer', RunExplorer::class);
        Livewire::component('ai-pulse.message-timeline', MessageTimeline::class);
        Livewire::component('ai-pulse.agent-sandbox', AgentSandbox::class);
        Livewire::component('ai-pulse.agent-inspector', AgentInspector::class);
        Livewire::component('ai-pulse.prompt-lab', PromptLab::class);
        Livewire::component('ai-pulse.audit-dashboard', AuditDashboard::class);
        Livewire::component('ai-pulse.cost-dashboard', CostDashboard::class);
        Livewire::component('ai-pulse.pricing-matrix', PricingMatrix::class);
        Livewire::component('ai-pulse.budget-alerts', BudgetAlerts::class);
        Livewire::component('ai-pulse.provider-health', ProviderHealth::class);
        Livewire::component('ai-pulse.prompt-library', PromptLibrary::class);
    }

    /**
     * Register Laravel AI SDK observability listeners.
     */
    protected function registerAiEventListeners(): void
    {
        if (! config('ai-pulse.observability.enabled', true)) {
            return;
        }

        if (! config('ai-pulse.observability.store_runs', true) && ! config('ai-pulse.budget.enabled', true)) {
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

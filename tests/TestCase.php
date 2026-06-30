<?php

namespace Syedmahroof\AiPulse\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Syedmahroof\AiPulse\AiPulseServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->runSdkMigrations();
        $this->runPulseMigrations();
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            AiPulseServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('ai-pulse.path', 'ai-pulse');
        $app['config']->set('ai-pulse.auth_guard', 'web');
        $app['config']->set('ai-pulse.middleware', ['web']);
        $app['config']->set('cache.default', 'array');
    }

    /**
     * Run the SDK database migrations.
     */
    protected function runSdkMigrations(): void
    {
        if (Schema::hasTable('agent_conversations')) {
            return;
        }

        $aiMigrationPath = dirname(__DIR__).'/vendor/laravel/ai/database/migrations';

        if (is_dir($aiMigrationPath)) {
            foreach (glob($aiMigrationPath.'/*.php') as $file) {
                $migration = include $file;
                if (is_object($migration) && method_exists($migration, 'up')) {
                    $migration->up();
                }
            }
        }
    }

    /**
     * Run the AI Pulse package database migrations.
     */
    protected function runPulseMigrations(): void
    {
        $orbitMigrationPath = dirname(__DIR__).'/database/migrations';

        if (is_dir($orbitMigrationPath)) {
            foreach (glob($orbitMigrationPath.'/*.php') as $file) {
                $migration = include $file;
                if (is_object($migration) && method_exists($migration, 'up')) {
                    $migration->up();
                }
            }
        }
    }
}

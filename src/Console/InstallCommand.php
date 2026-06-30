<?php

namespace Syedmahroof\AiPulse\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'ai-pulse:install';

    protected $description = 'Install Laravel AI Pulse and publish its resources';

    public function handle(): int
    {
        $this->comment('Publishing AI Pulse configuration...');
        Artisan::call('vendor:publish', ['--tag' => 'ai-pulse-config'], $this->output);

        $this->comment('Publishing AI Pulse assets...');
        Artisan::call('vendor:publish', ['--tag' => 'ai-pulse-assets'], $this->output);

        $this->comment('Publishing AI Pulse migrations...');
        Artisan::call('vendor:publish', ['--tag' => 'ai-pulse-migrations'], $this->output);

        $this->info('AI Pulse installed successfully.');

        $this->newLine();
        $this->line('Next, run the migrations to create the tables needed to store AI Pulse data:');
        $this->comment('  php artisan migrate');

        return self::SUCCESS;
    }
}

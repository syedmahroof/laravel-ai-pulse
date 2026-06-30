<?php

namespace Syedmahroof\AiAnalyzer\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'ai-analyzer:install';

    protected $description = 'Install Laravel AI Analyzer and publish its resources';

    public function handle(): int
    {
        $this->comment('Publishing AI Analyzer configuration...');
        Artisan::call('vendor:publish', ['--tag' => 'ai-analyzer-config'], $this->output);

        $this->comment('Publishing AI Analyzer assets...');
        Artisan::call('vendor:publish', ['--tag' => 'ai-analyzer-assets'], $this->output);

        $this->comment('Publishing AI Analyzer migrations...');
        Artisan::call('vendor:publish', ['--tag' => 'ai-analyzer-migrations'], $this->output);

        $this->info('AI Analyzer installed successfully.');

        $this->newLine();
        $this->line('Next, run the migrations to create the tables needed to store AI Analyzer data:');
        $this->comment('  php artisan migrate');

        return self::SUCCESS;
    }
}

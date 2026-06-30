<?php

namespace Syedmahroof\AiPulse\Http\Livewire;

use Syedmahroof\AiPulse\Services\TokenAggregator;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TodayStats extends Component
{
    public string $period = 'today';

    public function render(): View
    {
        $aggregator = app(TokenAggregator::class);

        return view('ai-pulse::livewire.today-stats', [
            'stats' => $aggregator->periodStats($this->period),
            'breakdown' => $aggregator->agentBreakdown($this->period),
            'periods' => [
                'today' => 'Today',
                '7d' => 'Last 7 Days',
                '30d' => 'Last 30 Days',
                'month' => 'This Month',
                'all' => 'All Time',
            ],
        ]);
    }
}

<?php

namespace Syedmahroof\AiPulse\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Syedmahroof\AiPulse\Models\BudgetAlert;

class BudgetExceeded extends Notification implements ShouldQueue
{
    use Queueable;

    private BudgetAlert $alert;

    private float $currentSpend;

    private bool $hasUnpricedUsage;

    private bool $test;

    public function __construct(BudgetAlert $alert, float $currentSpend, bool $hasUnpricedUsage = false, bool $test = false)
    {
        $this->alert = $alert;
        $this->currentSpend = $currentSpend;
        $this->hasUnpricedUsage = $hasUnpricedUsage;
        $this->test = $test;
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->alert->channels ?? ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $symbol = config('ai-pulse.currency_symbol', '$');
        $subject = $this->test
            ? "Budget Alert Test: {$this->alert->period} threshold"
            : "Budget Alert: {$this->alert->period} threshold exceeded";

        return (new MailMessage)
            ->subject($subject)
            ->view([
                'html' => 'ai-pulse::emails.budget-exceeded',
                'text' => 'ai-pulse::emails.budget-exceeded-text',
            ], [
                'alert' => $this->alert,
                'currentSpend' => $this->currentSpend,
                'currencySymbol' => $symbol,
                'dashboardUrl' => url(config('ai-pulse.path', 'ai-pulse').'/usage'),
                'hasUnpricedUsage' => $this->hasUnpricedUsage,
                'test' => $this->test,
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'alert_id' => $this->alert->id,
            'period' => $this->alert->period,
            'threshold' => $this->alert->threshold_amount,
            'current_spend' => $this->currentSpend,
            'has_unpriced_usage' => $this->hasUnpricedUsage,
            'test' => $this->test,
        ];
    }
}

<x-ai-pulse::layout>
    @slot('breadcrumb', 'Alerts')

    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-50 tracking-tight">Budget Alerts</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Set thresholds to get notified when AI spending exceeds your budget.</p>
        </div>

        <livewire:ai-pulse.budget-alerts />
    </div>
</x-ai-pulse::layout>

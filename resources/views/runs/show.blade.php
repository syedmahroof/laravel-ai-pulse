<x-ai-analyzer::layout>
    @slot('breadcrumb', 'Run Detail')

    <div class="space-y-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-50 tracking-tight">{{ $run->operation }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $run->invocation_id ?? 'No invocation id' }}</p>
            </div>
            <x-ai-analyzer::badge :label="$run->status" :color="$run->status === 'completed' ? 'green' : 'yellow'" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-3">
            <x-ai-analyzer::stat :value="$run->provider ?? 'unknown'" label="Provider" color="blue" />
            <x-ai-analyzer::stat :value="$run->model ?? 'unknown'" label="Model" color="purple" />
            <x-ai-analyzer::stat :value="number_format($run->input_tokens + $run->output_tokens)" label="Tokens" color="green" />
            <x-ai-analyzer::stat :value="config('ai-analyzer.currency_symbol', '$').number_format((float) $run->cost, 6)" :label="$run->missing_pricing ? 'Unpriced Cost' : 'Cost'" :color="$run->missing_pricing ? 'red' : 'green'" />
            <x-ai-analyzer::stat :value="$run->latency_ms ? number_format($run->latency_ms).'ms' : 'unknown'" label="Latency" color="orange" />
        </div>

        @if ($run->missing_pricing)
            <x-ai-analyzer::card padding="p-4">
                <p class="text-sm text-amber-700 dark:text-amber-300">
                    This run has usage but no matching pricing rule for its provider and model, so the recorded cost is incomplete.
                </p>
            </x-ai-analyzer::card>
        @endif

        @if ($run->conversation_id)
            <x-ai-analyzer::card title="Linked Conversation" padding="p-4">
                <a href="{{ route('analyzer.conversations.show', $run->conversation_id) }}" class="text-sm font-medium text-teal-600 dark:text-teal-300">
                    {{ $run->conversation_id }}
                </a>
            </x-ai-analyzer::card>
        @endif

        <x-ai-analyzer::card title="Payload" padding="p-4">
            <pre class="max-h-[420px] overflow-auto rounded-lg bg-gray-950 p-4 text-xs text-gray-100">{{ json_encode($run->payload ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
        </x-ai-analyzer::card>

        <x-ai-analyzer::card title="Usage And Events" padding="p-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <pre class="max-h-[320px] overflow-auto rounded-lg bg-gray-950 p-4 text-xs text-gray-100">{{ json_encode($run->usage ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                <pre class="max-h-[320px] overflow-auto rounded-lg bg-gray-950 p-4 text-xs text-gray-100">{{ json_encode($run->events ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
            </div>
        </x-ai-analyzer::card>

        @if ($run->error)
            <x-ai-analyzer::card title="Error" padding="p-4">
                <p class="text-sm text-red-500 dark:text-red-300">{{ $run->error }}</p>
            </x-ai-analyzer::card>
        @endif
    </div>
</x-ai-analyzer::layout>

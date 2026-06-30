<x-ai-analyzer::layout>
    @slot('breadcrumb', 'Conversation')

    <div class="space-y-6">
        <livewire:ai-analyzer.message-timeline :conversationId="$id" />
    </div>
</x-ai-analyzer::layout>

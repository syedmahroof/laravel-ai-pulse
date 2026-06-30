<x-ai-pulse::layout>
    @slot('breadcrumb', 'Conversation')

    <div class="space-y-6">
        <livewire:ai-pulse.message-timeline :conversationId="$id" />
    </div>
</x-ai-pulse::layout>

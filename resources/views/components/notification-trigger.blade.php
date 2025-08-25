
<div x-data class="flex items-center">
    <x-filament::badge size="md">
        <div x-init="$wire.getUnreadNotificationsCount" wire:poll.15s="getUnreadNotificationsCount">
            {{ $unreadCount ?? 0 }}
        </div>
    </x-filament::badge>
    <x-filament::link
        x-data
        type="button"
        size="lg"
        icon-position="after"
        icon="heroicon-m-bell"
        class="cursor-pointer"
        x-bind:class="{{ $unreadCount == 0 }} || 'animate-bounce'"
        x-on:click="$dispatch('open-modal', { id: 'database-notifications' })"
    >
    </x-filament::link>
</div>

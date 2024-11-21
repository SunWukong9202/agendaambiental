    
<div x-data class="flex items-center">
    <x-filament::badge size="md">
        <div x-init="$wire.getUnreadNotificationsCount" wire:poll.5s="getUnreadNotificationsCount">
            {{ $unreadCount ?? 0 }}
        </div>
    </x-filament::badge>
    <x-filament::link
        type="button"
        size="lg"
        icon-position="after"
        icon="heroicon-m-bell"
        class="cursor-pointer"
        @class([
            'cursor-pointer',
            'animate-bounce' => isset($unreadCount) && $unreadCount > 0
        ])
        x-on:click="$dispatch('open-modal', { id: 'database-notifications' })"
    >
    </x-filament::link>
</div>

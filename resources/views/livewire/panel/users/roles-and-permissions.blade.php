<div>
    <x-filament::breadcrumbs :breadcrumbs="[
        route('admin.roles-and-permissions') => __('ui.pages.Roles & Permissions'),
        '' => __('ui.'.$action),
        ]" 
    />
    
    <div class="mt-4">
        @if ($action == 'list')
            {{ $this->table }}
        @else
            
            <form wire:submit="save">
                <div class="flex">
                    <x-filament::button class="ml-auto flex items-center cursor-pointer" type="submit">
                        <x-filament::loading-indicator wire:loading class="h-5 w-5 inline-block" />
                        {{ $this->role ? 'Edit Role' : 'Create Role' }}
                    </x-filament>
                </div>
                {{ $this->roleForm }}
            </form>
        @endif
    </div>
</div>

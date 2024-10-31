<x-layouts.base>
    <nav 
        class="w-full bg-marine border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    >
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end"> 
                
                <a class="flex ms-2">
                    <img src="/images/logoagenda.jpg" class="h-8 me-3" alt="FlowBite Logo" />
                </a>
            </div>
        </div>
    </nav>
    <nav class=" bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex items-center py-2 justify-center font-medium text-sm">
                <x-link.pill 
                    @class([
                        '!bg-marine !text-white' => request()->routeIs('home')
                    ])
                    href="{{ route('home') }}"
                >
                    {{ __('ui.pages.Home') }}
                </x-link>
                @can(\App\Enums\Permission::HasAdminPanelAccess->value)
                    <x-link.pill 
                        wire:navigate
                        href="{{ route('admin.dashboard') }}"
                    >
                        {{ __('ui.pages.Admin Panel') }}
                    </x-link>
                @else
                <x-link.pill 
                    wire:navigate
                    href="{{ route('logout') }}"
                >
                    {{ __('ui.pages.Log out') }}
                </x-link>
                @endcan
            </div>
        </div>
    </nav>
    <div class="p-4 sm:m dark:bg-gray-800">
        {{ $slot }}
    </div>
</x-layouts>
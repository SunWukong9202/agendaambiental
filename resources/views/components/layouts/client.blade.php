<x-layouts.base>
    <nav 
        class="w-full bg-primary-600/90 "
    >
        <div class="px-3 py-3 lg:px-5 lg:pl-3 flex items-center justify-between">
            {{-- <div class=k""> --}}
            <div class="flex items-center justify-start rtl:justify-end"> 

                <a class="flex ms-2">
                    <img src="/images/logoagenda.jpg" class="h-8 me-3" alt="FlowBite Logo" />
                </a>
            </div>
            <div class="flex gap-2">
                @livewire('notifications-trigger')

                <x-filament::dropdown placement="bottom-start">
                    <x-slot name="trigger">
                        <button type="button" class="ml-auto px-[9px] py-2 rounded-full bg-white dark:bg-gray-950 shadow-sm border-primary-600 dark:border-primary-400 border-4 flex items-center justify-center ring-0">
                            AA
                        </button>
                    </x-slot>
                    
        
                    <x-filament::dropdown.list>
                        <x-filament::dropdown.list.item class="hover:bg-none cursor-text" icon="heroicon-m-user-circle">
                            {{ auth()->user()->name ?? 'Usuario' }}
                        </x-filament::dropdown.list.item>
        
                        <div class="p-1 flex gap-1" @click="close()">
                            <x-filament::button 
                            @click="applyTheme(saveTheme('dark'))"
                            class="flex-1 !ring-0 shadow-none" 
                            {{-- x-bind:class="theme == 'dark' ? 'dark:bg-primary-600' : '' " --}}
                            color="gray" tooltip="{{__('Enable dark mode')}}">
                                <x-heroicon-m-moon class="size-5 text-gray-400" x-bind:class="theme == 'dark' ? 'text-primary-600 dark:text-primary-400' : '' " />
                            </x-filament>
                            <x-filament::button 
                            @click="applyTheme(saveTheme('light'))"
                            class="flex-1 !ring-0 shadow-none" 
                            {{-- x-bind:class="theme == 'light' ? 'dark:bg-primary-600' : '' " --}}
                            color="gray" tooltip="{{__('Enable light mode')}}">
                                <x-heroicon-m-sun class="size-5 text-gray-400 b" x-bind:class="theme == 'light' ? 'text-primary-600 dark:text-primary-400' : '' "/>
                            </x-filament>
                            <x-filament::button 
                            @click="applyTheme(saveTheme('system'))"
                            {{-- x-bind:class="theme == 'system' ? 'dark:bg-primary-600' : '' " --}}
                            class="flex-1 !ring-0 shadow-none" color="gray" tooltip="{{__('Enable system mode')}}">
                                <x-heroicon-m-computer-desktop class="size-5 text-gray-400"  x-bind:class="theme == 'system' ? 'text-primary-600 dark:text-primary-400' : ''"/>
                            </x-filament>
                        </div>
        
                        <div class="p-1">
                            {{-- @livewire('language-switcher') --}}
                            <livewire:panel.language-switcher @change="close()" currentUrl="{{ request()->url() }}" />
                        </div>
        
                        <x-filament::dropdown.list.item tag="a" wire:navigate href="{{ route('logout') }}" icon="heroicon-m-arrow-left-end-on-rectangle">
                            {{ __('Log out') }}
                        </x-filament::dropdown.list.item>
                    </x-filament::dropdown.list>
                </x-filament::dropdown>
            </div>
        </div>

    </nav>
    <nav class=" bg-white border-b border-gray-200 dark:border-0 dark:bg-gray-900 shadow-sm">
        <div class="max-w-screen-xl mx-auto ">
            <div custom-scrollbar
            class="flex flex-nowrap overflow-x-auto items-center py-2 px-2 justify-center font-medium text-sm">
                <x-link.pill 
                    @class([
                        'ml-32 sm:ml-0',
                        '!bg-primary-600/90 !text-white !dark:bg-primary-400' => request()->routeIs('home')
                    ])
                    href="{{ route('home') }}"
                >
                    {{ __('ui.pages.Home') }}
                </x-link>
                @roleCM(\App\Enums\Role::RepairTechnician->value)
                    <x-link.pill 
                        @class([
                            '!bg-primary-600/90 !text-white !dark:bg-primary-400' => request()->routeIs('listRepairs')
                        ])
                        href="{{ route('listRepairs') }}"
                    >
                        {{ __('ui.pages.My Repairs') }}
                    </x-link>
                @endrole

                @canCM(\App\Enums\Permission::HasAdminPanelAccess->value)
                    <x-link.pill 
                        wire:navigate
                        href="{{ route('admin.dashboard') }}"
                    >
                        {{ __('ui.pages.Admin Panel') }}
                    </x-link>                
                @endcan

                <x-link.pill 
                    wire:navigate
                    href="{{ route('logout') }}"
                >
                    {{ __('ui.pages.Log out') }}
                </x-link>
            </div>
        </div>
    </nav>
    
    <div class="p-4 sm:m">
        {{ $slot }}
    </div>
</x-layouts>
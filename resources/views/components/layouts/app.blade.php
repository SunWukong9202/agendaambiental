<x-layouts.base>
    @php
        $routes = \Illuminate\Support\Facades\Config::get('navigation.reactivos', []);
    @endphp

    <x-navbar class="fixed top-0 z-30">
        {{-- <div class="flex-1 w-full"> --}}
            <div class="ml-auto">
                <x-filament::dropdown placement="bottom-start">
                    <x-slot name="trigger">
                        <button type="button" class="ml-auto px-[9px] py-2 rounded-full bg-white shadow-sm border-orange-300 border-4 flex items-center justify-center">
                            AA
                        </button>
                    </x-slot>
                    
                    <x-filament::dropdown.list>
                        <x-filament::dropdown.list.item class="hover:bg-none cursor-text" icon="heroicon-m-user-circle">
                            {{ auth()->user()->name ?? 'Usuario' }}
                        </x-filament::dropdown.list.item>
                        
                        <div class="p-1 flex gap-1">
                            <x-filament::button class="flex-1 !ring-0 shadow-none" color="gray" tooltip="Enable dark mode">
                                <x-heroicon-m-moon class="size-5 text-gray-400" />
                            </x-filament>
                            <x-filament::button class="flex-1 !ring-0 shadow-none" color="gray" tooltip="Enable white mode">
                                <x-heroicon-m-sun class="size-5 text-gray-400" />
                            </x-filament>
                            <x-filament::button class="flex-1 !ring-0 shadow-none" color="gray" tooltip="Enable dark mode">
                                <x-heroicon-m-computer-desktop class="size-5 text-gray-400" />
                            </x-filament>
                        </div>

                        <x-filament::dropdown.list.item tag="a" wire:navigate href="{{ route('home') }}" icon="heroicon-m-arrow-left">
                            {{ __('ui.pages.Return home') }}
                        </x-filament::dropdown.list.item>

                        <x-filament::dropdown.list.item tag="a" wire:navigate href="{{ route('logout') }}" icon="heroicon-m-arrow-left-end-on-rectangle">
                            {{ __('ui.pages.Log out') }}
                        </x-filament::dropdown.list.item>
                    </x-filament::dropdown.list>
                </x-filament::dropdown>
            </div>
    </x-navbar>

    <x-aside
    >

        <x-fl.dropdown>
            <x-fl.dropdown.item :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                <x-slot:icon>
                    <x-heroicon-m-squares-2x2 class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Dashboard') }}
            </x-fl>
        </x-fl>

        <x-fl.dropdown persisted key="{{ __('ui.pages.Users Managment') }}">
            <x-slot name="trigger">
                <x-fl.dropdown.button>
                    {{ __('ui.pages.Users Managment') }}
                </x-fl>
            </x-slot>

            <x-fl.dropdown.item :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                <x-slot:icon>
                    <x-heroicon-m-users class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Manage Users') }}
            </x-fl>

            <x-fl.dropdown.item :href="route('admin.users.suppliers')" :active="request()->routeIs('admin.users.suppliers')">
                <x-slot:icon>
                    <x-heroicon-m-identification class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Manage Suppliers') }}
            </x-fl>

            <x-fl.dropdown.item :href="route('admin.roles-and-permissions')" :active="request()->routeIs('admin.roles-and-permissions')">
                <x-slot:icon>
                    <x-heroicon-m-lock-closed class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Roles & Permissions') }}
            </x-fl>
        </x-fl>

        <x-fl.dropdown persisted initiallyOpen key="{{ __('ui.pages.Event Managment') }}">
            <x-slot name="trigger">
                <x-fl.dropdown.button>
                    {{ __('ui.pages.Event Managment') }}
                </x-fl>
            </x-slot>

            <x-fl.dropdown.item >
                <x-slot:icon>
                    <x-heroicon-m-bolt class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Active Events') }}
            </x-fl>

            <x-fl.dropdown.item >
                <x-slot:icon>
                    <x-heroicon-m-archive-box class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Register Deliveries') }}
            </x-fl>

            <x-fl.dropdown.item >
                <x-slot:icon>
                    <x-heroicon-m-chart-bar class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Event Inventory') }}
            </x-fl>

            <x-fl.dropdown.item >
                <x-slot:icon>
                    <x-heroicon-o-clock class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Inventory Movements') }}
            </x-fl>

            <x-fl.dropdown.item >
                <x-slot:icon>
                    <x-heroicon-o-briefcase class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Repairment Managment') }}
            </x-fl>

            <x-fl.dropdown.item :href="route('admin.events.history')" :active="request()->routeIs('admin.events.history')">
                <x-slot:icon>
                    <x-heroicon-m-rectangle-stack class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Event History') }}
            </x-fl>

            <x-fl.dropdown.item :href="route('admin.events.wastes')" :active="request()->routeIs('admin.events.wastes')">
                <x-slot:icon>
                    <x-heroicon-m-square-3-stack-3d class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Waste Managment') }}
            </x-fl>
        </x-fl>

        <x-fl.dropdown persisted initiallyOpen key="{{ __('ui.pages.Reagent Management') }}">
            <x-slot name="trigger">
                <x-fl.dropdown.button>
                    {{ __('ui.pages.Reagent Management') }}
                </x-fl>
            </x-slot>

            <x-fl.dropdown.item >
                <x-slot:icon>
                    <x-heroicon-m-beaker class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Manage Reagents') }}
            </x-fl>

            <x-fl.dropdown.item >
                <x-slot:icon>
                    <x-heroicon-m-chart-bar class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Reagent Inventory') }}
            </x-fl>

            <x-fl.dropdown.item >
                <x-slot:icon>
                    <x-heroicon-o-clock class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Inventory Movements') }}
            </x-fl>
        </x-fl>
        
    </x-aside>

    <div class="flex-1 p-4 lg:p-8 lg:ml-80 mt-16 lg:mt-20">

        {{ $slot }}

    </div>

</x-layouts>


{{-- <x-link wire:navigate page="users-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link wire:navigate page="events-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link class="pl-11" text="Eventos" icon="grid"/> --}}
<x-layouts.base >
    @php
        $permission = \App\Enums\Permission::class;
    @endphp

    <x-navbar class="fixed top-0 z-30">
        {{-- <div class="flex-1 w-full"> --}}
            <div class="ml-auto flex gap-8">

                @livewire('notifications-trigger')

                <x-filament::dropdown placement="bottom-start">
                    <x-slot name="trigger">
                        {{-- <x-filament::avatar class="ml-auto px-[9px] py-2 rounded-full bg-white dark:bg-gray-950 shadow-sm border-primary-600 dark:border-primary-400 border-4">
                            {{ __('AG') }}
                        </x-filament> --}}
                        <button type="button" class="ml-auto px-[9px] py-2 rounded-full bg-white dark:bg-gray-950 shadow-sm border-primary-600 dark:border-primary-400 border-4 flex items-center justify-center ring-0">
                            AG
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

                        <x-filament::dropdown.list.item tag="a" wire:navigate href="{{ route('home') }}" icon="heroicon-m-cog-6-tooth">
                            {{ __('Settings') }}
                        </x-filament::dropdown.list.item>

                        <x-filament::dropdown.list.item tag="a" wire:navigate href="{{ route('home') }}" icon="heroicon-m-arrow-left">
                            {{ __('Return to home') }}
                        </x-filament::dropdown.list.item>

                        <x-filament::dropdown.list.item tag="a" wire:navigate href="{{ route('logout') }}" icon="heroicon-m-arrow-left-end-on-rectangle">
                            {{ __('Log out') }}
                        </x-filament::dropdown.list.item>
                    </x-filament::dropdown.list>
                </x-filament::dropdown>
            </div>
    </x-navbar>

    <x-aside>
        <x-fl.dropdown>
            <x-fl.dropdown.item :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                <x-slot:icon>
                    <x-heroicon-m-squares-2x2 class="w-5 h-5" />
                </x-slot>
                {{ __('ui.pages.Dashboard') }}
            </x-fl>
        </x-fl>

        @cananyCM([
            $permission::ViewUsers->value,
            $permission::ViewSuppliers->value,
            $permission::ViewRoles->value
        ])
            <x-fl.dropdown persisted initiallyOpen key="{{ __('ui.pages.Users Managment') }}">
                <x-slot name="trigger">
                    <x-fl.dropdown.button>
                        {{ __('ui.pages.Users Managment') }}
                    </x-fl>
                </x-slot>

                @canCM($permission::ViewUsers->value)
                    <x-fl.dropdown.item :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                        <x-slot:icon>
                            <x-heroicon-m-users class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Manage Users') }}
                    </x-fl>
                @endcan

                @canCM($permission::ViewSuppliers->value)
                    <x-fl.dropdown.item :href="route('admin.suppliers')" :active="request()->routeIs('admin.suppliers')">
                        <x-slot:icon>
                            <x-heroicon-m-identification class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Manage Suppliers') }}
                    </x-fl>
                @endcan

                @canCM($permission::ViewRoles->value)
                    <x-fl.dropdown.item :href="route('admin.roles-and-permissions')" :active="request()->routeIs('admin.roles-and-permissions')">
                        <x-slot:icon>
                            <x-heroicon-m-lock-closed class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Roles & Permissions') }}
                    </x-fl>
                @endcan
            </x-fl>
        @endcanany

        @cananyCM([
            $permission::AccessActiveEvents->value,
            $permission::ViewDeliveries->value,
            $permission::ViewEventInventory->value,
            $permission::ViewRepairments->value,
            $permission::ViewWastes->value,
            $permission::ViewEvents->value
        ])
            <x-fl.dropdown persisted initiallyOpen key="{{ __('ui.pages.Event Managment') }}">
                <x-slot name="trigger">
                    <x-fl.dropdown.button>
                        {{ __('ui.pages.Event Managment') }}
                    </x-fl>
                </x-slot>
                @canCM($permission::AccessActiveEvents->value)
                    <x-fl.dropdown.item :href="route('admin.events.actived')" :active="request()->routeIs('admin.events.actived')">
                        <x-slot:icon>
                            <x-heroicon-m-bolt class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Active Events') }}
                    </x-fl>
                @endcanCM

                {{-- @canCM($permission::ViewDeliveries->value)
                    <x-fl.dropdown.item :href="route('admin.events.deliveries')" :active="request()->routeIs('admin.events.deliveries')">
                        <x-slot:icon>
                            <x-heroicon-m-archive-box class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Register Deliveries') }}
                    </x-fl>
                @endcanCM --}}

                @canCM($permission::ViewEventInventory->value)
                    <x-fl.dropdown.item :href="route('admin.events.inventory')" :active="request()->routeIs('admin.events.inventory')">
                        <x-slot:icon>
                            <x-heroicon-m-chart-bar class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Event Inventory') }}
                    </x-fl>

                    {{-- <x-fl.dropdown.item >
                        <x-slot:icon>
                            <x-heroicon-o-clock class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Inventory Movements') }}
                    </x-fl> --}}
                @endcanCM

                {{-- @canCM($permission::ViewRepairments->value)
                    <x-fl.dropdown.item :href="route('admin.events.repairments')" :active="request()->routeIs('admin.events.repairments')" >
                        <x-slot:icon>
                            <x-heroicon-o-briefcase class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Repairment Managment') }}
                    </x-fl>
                @endcanCM --}}

                @canCM($permission::ViewEvents->value)
                    <x-fl.dropdown.item :href="route('admin.events.history')" :active="request()->routeIs('admin.events.history')">
                        <x-slot:icon>
                            <x-heroicon-m-rectangle-stack class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Event History') }}
                    </x-fl>
                @endcanCM

                @canCM($permission::ViewWastes->value)
                    <x-fl.dropdown.item :href="route('admin.events.wastes')" :active="request()->routeIs('admin.events.wastes')">
                        <x-slot:icon>
                            <x-heroicon-m-square-3-stack-3d class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Waste Managment') }}
                    </x-fl>
                @endcanCM
            </x-fl>
        @endcanany

        @cananyCM([
            $permission::ViewReagents->value,
            $permission::ViewReagentsInventory->value,
        ])
            <x-fl.dropdown persisted initiallyOpen key="{{ __('ui.pages.Reagent Management') }}">
                <x-slot name="trigger">
                    <x-fl.dropdown.button>
                        {{ __('ui.pages.Reagent Management') }}
                    </x-fl>
                </x-slot>
                @canCM($permission::ViewReagents->value)
                    <x-fl.dropdown.item 
                        :href="route('admin.reagents.managment')" :active="request()->routeIs('admin.reagents.managment')"
                    >
                        <x-slot:icon>
                            <x-heroicon-m-beaker class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Manage Reagents') }}
                    </x-fl>
                @endcanCM
                
                @canCM($permission::ViewReagentsInventory->value)
                    <x-fl.dropdown.item :href="route('admin.reagents')" :active="request()->routeIs('admin.reagents')" >
                        <x-slot:icon>
                            <x-heroicon-m-chart-bar class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Reagent Inventory') }}
                    </x-fl>

                    {{-- <x-fl.dropdown.item >
                        <x-slot:icon>
                            <x-heroicon-o-clock class="w-5 h-5" />
                        </x-slot>
                        {{ __('ui.pages.Inventory Movements') }}
                    </x-fl> --}}
                @endcanCM

            </x-fl>
        @endcanany

    </x-aside>

    <div class="flex-1 p-4 lg:p-8 lg:ml-80 mt-16">

        {{ $slot }}

    </div>

</x-layouts>


{{-- <x-link wire:navigate page="users-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link wire:navigate page="events-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link class="pl-11" text="Eventos" icon="grid"/> --}}
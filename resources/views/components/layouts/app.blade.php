<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @livewireStyles
        @vite(['resources/js/app.js'])
        @vite('resources/css/app.css')

    </head>
    <body class="text-base md:text-lg lg:text-xl">

        @php
        $routes = \Illuminate\Support\Facades\Config::get('navigation.reactivos', []);
        @endphp
        
        <x-navbar class="fixed top-0 z-50">
            <a href="{{ route('admin.users') }}" class="flex ms-2 ">
                <img src="/images/logoagenda.jpg" class="h-8 me-3" alt="FlowBite Logo" />
            </a>
            @if (request()->routeIs(...$routes))
            <div class="fixed inset-x-0">
                <x-tabs :pages="$routes"/>
            </div>
            @endif
        </x-navbar>
        <x-aside>
            {{-- <x-link page="admin.panel" wire:navigate text="Inicio" icon="grid"/> --}}
            <x-link wire:navigate page="admin.users" text="Usuarios" icon="grid"/>

            {{-- <x-link wire:navigate page="admin.events" text="Eventos" icon="grid"/> --}}

            <x-dropdown key="Acopios">
                <x-slot:trigger>
                    <x-link icon="grid"
                        text="Acopios">
                        <x-icon.angle-down 
                        x-bind:class="expanded ? '-rotate-180': 'rotate-0'"   
                        class="ml-auto mt-[2px]"/>
                    </x-link>
                </x-slot>

                <x-link class="pl-11" wire:navigate page="admin.events" text="Inicio" />
                <x-link wire:navigate page="admin.proveedores" class="pl-11" text="Proveedores" />
            </x-dropdown>

            <x-dropdown key="Inventarios">
                <x-slot:trigger>
                    <x-link icon="grid"
                        text="Inventarios">
                        <x-icon.angle-down 
                        x-bind:class="expanded ? '-rotate-180': 'rotate-0'"   
                        class="ml-auto mt-[2px]"/>
                    </x-link>
                </x-slot>

                <x-link wire:navigate page="admin.inventario.articulos" class="pl-11" text="Articulos" />
                <x-link wire:navigate :page="$routes['Inicio']" :$routes class="pl-11" text="Reactivos" />
            </x-dropdown>

            <x-dropdown key="Configuracion">
                <x-slot:trigger>
                    <x-link icon="grid"
                        text="Configuracion">
                        <x-icon.angle-down 
                        x-bind:class="expanded ? '-rotate-180': 'rotate-0'"   
                        class="ml-auto mt-[2px]"/>
                    </x-link>
                </x-slot>

                <x-link class="pl-11" text="Permisos" />
                <x-link wire:navigate class="pl-11" text="General" />
            </x-dropdown>

            <x-link wire:navigate page="client.home" text="Regresar" icon="arrow-right-to-bracket"/>
            <x-link page="logout" text="Cerrar Sesion" icon="arrow-right-to-bracket"/>
            
            {{-- <x-link text="Acopios" icon="grid"/> --}}

            {{-- <x-link text="Acopio Activo" icon="grid"/> --}}

        </x-aside>

        <div class="p-2 sm:p-4 sm:ml-64 dark:bg-gray-800">
            <div class="p-2 sm:p-4 rounded-lg dark:border-gray-700 mt-14">
                {{ $slot }}
            </div>
        </div>
        @livewireScriptConfig
    </body>
</html>

{{-- <x-link wire:navigate page="users-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link wire:navigate page="events-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link class="pl-11" text="Eventos" icon="grid"/> --}}
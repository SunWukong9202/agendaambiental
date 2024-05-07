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
    <body>
        @php
        $routes = \Illuminate\Support\Facades\Config::get('navigation.reactivos', []);
        @endphp
        
        <x-navbar class="fixed top-0 z-50">
            <a href="{{ route('admin.panel') }}" class="flex ms-2">
                <img src="../images/logoagenda.jpg" class="h-8 me-3" alt="FlowBite Logo" />
            </a>
            @if (request()->routeIs(...$routes))
            <div class="fixed inset-x-0">
                <x-tabs :pages="$routes"/>
            </div>
            @endif
        </x-navbar>
        <x-aside>
            <x-link text="Inicio" icon="grid"/>
            <x-link wire:navigate page="admin.users" text="Usuarios" icon="grid"/>
            <x-link wire:navigate page="admin.events" text="Eventos" icon="grid"/>
            <x-dropdown key="Inventarios">
                <x-slot:trigger>
                    <x-link text="Inventarios" icon="grid" iconRTL="angle-down"/>
                </x-slot>

                <x-link class="pl-11" text="Productos" />
                <x-link wire:navigate :page="$routes['Inicio']" :$routes class="pl-11" text="Reactivos" />
                <x-link class="pl-11" text="Acopio" />
            </x-dropdown>

            {{-- <x-link text="Acopios" icon="grid"/> --}}

            {{-- <x-link text="Acopio Activo" icon="grid"/> --}}

            <x-dropdown key="solicitudes">
                <x-slot:trigger>
                    <x-link text="Solicitudes" icon="grid" iconRTL="angle-down"/>
                </x-slot>

                <x-link class="pl-11" text="Productos" />
                <x-link class="pl-11" text="Reactivos" />
                <x-link class="pl-11" text="Servicios" />
            </x-dropdown>

            <x-dropdown key="Donaciones">
                <x-slot:trigger>
                    <x-link text="Donacion" icon="grid" iconRTL="angle-down"/>
                </x-slot>

                <x-link class="pl-11" text="Productos" />
                <x-link class="pl-11" text="Reactivos" />
                <x-link class="pl-11" text="Acopio" />
            </x-dropdown>

            {{-- <x-link text="Proveedores" icon="grid"/>
            <x-link text="Reactivos" icon="grid"/>
            <x-link text="Residuos" icon="grid"/>
            <x-link text="Solicitudes de Reactivos" icon="grid"/>
            <x-link text="Solicitudes de Productos" icon="grid"/>
            <x-link text="Solicitudes de Servicios" icon="grid"/>
            <x-link text="Captura de Productos" icon="grid"/>
            <x-link text="Captura de Reactivos" icon="grid"/>
            <x-link text="Reparaciones" icon="grid"/> --}}
        </x-aside>

        <div class="p-4 sm:ml-64 dark:bg-gray-800">
            <div class="p-4 rounded-lg dark:border-gray-700 mt-14">
                {{ $slot }}
            </div>
        </div>
        @livewireScriptConfig
    </body>
</html>

{{-- <x-link wire:navigate page="users-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link wire:navigate page="events-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link class="pl-11" text="Eventos" icon="grid"/> --}}
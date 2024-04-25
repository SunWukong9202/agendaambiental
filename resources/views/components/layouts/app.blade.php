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
        <x-navbar />
        <x-aside>
            <x-link  text="Inicio" icon="grid"/>
            <x-link  text="Usuarios" icon="grid"/>

            <x-link  text="Eventos" icon="grid"/>

            <x-link text="Acopios" icon="grid"/>

            <x-link text="Acopio Activo" icon="grid"/>

            <x-dropdown key="solicitudes">
                <x-slot:trigger>
                    <x-link text="Solicitudes" icon="grid" iconRTL="angle-down"/>
                </x-slot>

                <x-link class="pl-11" text="Productos" />
                <x-link class="pl-11" text="Reactivos" />
                <x-link class="pl-11" text="Servicios" />
            </x-dropdown>

            <x-link text="Proveedores" icon="grid"/>
            <x-link text="Reactivos" icon="grid"/>
            <x-link text="Residuos" icon="grid"/>
            <x-link text="Solicitudes de Reactivos" icon="grid"/>
            <x-link text="Solicitudes de Productos" icon="grid"/>
            <x-link text="Solicitudes de Servicios" icon="grid"/>
            <x-link text="Captura de Productos" icon="grid"/>
            <x-link text="Captura de Reactivos" icon="grid"/>
            <x-link text="Reparaciones" icon="grid"/>
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
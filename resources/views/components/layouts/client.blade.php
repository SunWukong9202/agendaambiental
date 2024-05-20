@props([
    'enableTALL' => false
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @livewireStyles
        @vite(['resources/js/app.js'])
        @vite('resources/css/app.css')
        @if (!$enableTALL)
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        @endif
    </head>
    <body>
        <x-navbar>
            <a href="{{ route('agendaAmbiental') }}" class="flex ms-2">
                <img src="/images/logoagenda.jpg" class="h-8 me-3" alt="FlowBite Logo" />
            </a>
        </x-navbar>
        <x-shell.sub-nav>
            <x-link.pill 
            @class([
                'btn-primary' => request()->routeIs('client.home'),
                'btn-light' => !request()->routeIs('client.home') 
            ])
            href="{{ route('client.home') }}">Inicio</x-link>
            <x-link.pill 
            @class([
                'btn-primary' => request()->routeIs('reactivos.donaciones'),
                'btn-light' => !request()->routeIs('reactivos.donaciones') 
            ])
            href="{{ route('reactivos.donaciones') }}">Donar</x-link>
            <x-link.pill 
            @class([
                'btn-primary' => request()->routeIs('reactivos.solicitudes'),
                'btn-light' => !request()->routeIs('reactivos.solicitudes') 
            ])
            href="{{ route('reactivos.solicitudes') }}">Solicitar</x-link>

            <x-link.pill
            @class([
                'btn-primary' => request()->routeIs('articulos.donaciones'),
                'btn-light' => !request()->routeIs('articulos.donaciones') 
            ])
            href="{{ route('articulos.donaciones') }}">Articulos</x-link>

            <x-link.pill
            @class([
                'btn-primary' => request()->routeIs('user.profile'),
                'btn-light' => !request()->routeIs('user.profile') 
            ])
            href="{{ route('user.profile') }}">Perfil</x-link>
        </x-shell>
        <div class="p-4 sm:m dark:bg-gray-800">
            {{ $slot }}
        </div>
        @livewireScriptConfig
    </body>
</html>
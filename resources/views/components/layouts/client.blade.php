

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
        <x-navbar>
            <a href="{{ route('agendaAmbiental') }}" class="flex ms-2">
                <img src="/images/logoagenda.jpg" class="h-8 me-3" alt="FlowBite Logo" />
            </a>
        </x-navbar>
        <x-shell.sub-nav>
            <x-link.pill 
            @class([
                '!bg-marine !text-white' => request()->routeIs('client.home')
            ])
            href="{{ route('client.home') }}">Solicitar</x-link>
            <x-link.pill
            @class([
                '!bg-marine !text-white' => request()->routeIs('user.profile')
            ])
            href="{{ route('user.profile') }}">Perfil</x-link>

            <x-link.pill
            @class([
                '!bg-marine !text-white' => request()->routeIs('admin.panel')
            ])
            href="{{ route('admin.panel') }}">Panel de Administrador</x-link>

            <x-link.pill
            href="{{ route('logout') }}">Cerrar sesion</x-link>

        </x-shell>
        <div class="p-4 sm:m dark:bg-gray-800">
            {{ $slot }}
        </div>
        @livewireScriptConfig
    </body>
</html>
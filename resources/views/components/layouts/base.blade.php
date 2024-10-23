<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @filamentStyles
        @vite(['resources/js/app.js'])
        @vite('resources/css/app.css')

    </head>
    <body class="text-base md:text-base lg:text-lg">

        {{ $slot }}
        
        @filamentScripts
    </body>
</html>

{{-- <x-link wire:navigate page="users-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link wire:navigate page="events-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link class="pl-11" text="Eventos" icon="grid"/> --}}
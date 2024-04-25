@props([
    'icon' => false,
])

@if ($icon)
    <x-dynamic-component :component="'icon.'.$icon"/>
@endif
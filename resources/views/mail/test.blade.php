
<x-mail::layout>

<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

<div style="background-color: #2d3748; padding: 10px; text-align: center; margin-bottom: 1rem; border-radius: 1rem;">
    <img src="{{ asset('images/logouaslp.jpg') }}" alt="Logo" style="width: 148px; height: auto;">
</div>

# Introduction

{{ fake()->text() }}

<x-mail::button :url="''">
Button Text
</x-mail::button>

{{ __('Thanks') }},<br>
{{ config('app.name') }}

<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
        <script>
            document.addEventListener('copy-text', (event) => {
                const { text } = event.detail;
                navigator.clipboard.writeText(text).then(() => {
                    alert('Text copied to clipboard!'); // Replace with a notification system if needed
                }).catch((err) => {
                    console.error('Failed to copy text: ', err);
                });
            });
            // Global function to apply custom validation messages with dynamic constraint values
            window.applyValidationMessages = function (formElement, locale = "{{ str_replace('_', '-', app()->getLocale()) }}") {
                // Function to set a translated custom validity message
                const setTranslatedMessage = (input) => {
                    let messageKey;

                    // Determine the validation type and message key
                    if (input.validity.valueMissing) messageKey = 'required';
                    else if (input.validity.typeMismatch && input.type === 'email') messageKey = 'email';
                    else if (input.validity.typeMismatch && input.type === 'url') messageKey = 'url';
                    else if (input.validity.rangeUnderflow) messageKey = 'min';
                    else if (input.validity.rangeOverflow) messageKey = 'max';
                    else if (input.validity.tooShort) messageKey = 'minlength';
                    else if (input.validity.tooLong) messageKey = 'maxlength';
                    else if (input.validity.patternMismatch) messageKey = 'pattern';
                    else if (input.validity.typeMismatch && input.type === 'number') messageKey = 'number';

                    // Get translated message template if available
                    if (messageKey && validationMessages[messageKey]) {
                        let translatedMessage = validationMessages[messageKey][locale] || validationMessages[messageKey].en;

                        // Replace placeholders with actual constraint values
                        translatedMessage = translatedMessage.replace('{min}', input.min)
                                                            .replace('{max}', input.max)
                                                            .replace('{minLength}', input.minLength)
                                                            .replace('{maxLength}', input.maxLength);

                        // Set the custom validity with the translated message
                        input.setCustomValidity(translatedMessage);
                    } else {
                        input.setCustomValidity('');  // Reset message if no issues
                    }
                };

                // Apply translated messages on page load
                formElement.querySelectorAll('input, textarea, select').forEach(input => {
                    setTranslatedMessage(input);

                    // Update message on input event
                    input.addEventListener('input', () => setTranslatedMessage(input));
                });
            }
        </script>
    </head>
    <body 
    x-cloak
    x-data="{
        theme: $persist('system'),

        systemPreference: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',

        init() {
            if(this.theme == 'system') {
                this.applyTheme(this.systemPreference)   
            } else {
                this.applyTheme(this.theme) 
            }
        },

        saveTheme(theme) {
            return this.theme = theme;
        },

        applyTheme(theme) {
            document.documentElement.classList.toggle('dark', theme === 'dark');
        }
    }"
    class="fi-body fi-panel-admin flex flex-col min-h-screen bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white">

        @auth
            @livewire('database-notifications')
        @endauth

        {{ $slot }}

        @livewire('notifications')

 
        @filamentScripts
        @vite(['resources/js/app.js'])
    </body>
</html>

{{-- <x-link wire:navigate page="users-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link wire:navigate page="events-page" class="pl-11" text="Eventos" icon="grid"/>
<x-link class="pl-11" text="Eventos" icon="grid"/> --}}
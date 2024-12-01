<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="application-name" content="<?php echo e(config('app.name')); ?>">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo e($title ?? 'Page Title'); ?></title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <?php echo \Filament\Support\Facades\FilamentAsset::renderStyles() ?>
        <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
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
            window.applyValidationMessages = function (formElement, locale = "<?php echo e(str_replace('_', '-', app()->getLocale())); ?>") {
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

        <?php if(auth()->guard()->check()): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('database-notifications');

$__html = app('livewire')->mount($__name, $__params, 'lw-833518764-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('notifications');

$__html = app('livewire')->mount($__name, $__params, 'lw-833518764-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

 
        <?php echo \Filament\Support\Facades\FilamentAsset::renderScripts() ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
    </body>
</html>

<?php /**PATH C:\Users\azahe\OneDrive\Escritorio\unir\resources\views/components/layouts/base.blade.php ENDPATH**/ ?>
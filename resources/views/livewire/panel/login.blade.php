<div class="
    flex flex-col items-center justify-center h-screen
    bg-white dark:bg-gray-950
    "
    x-data
>
    <form wire:submit="authenticate" 
        class="
        max-w-md w-full flex flex-col gap-8 p-8 border rounded-lg shadow-sm
        bg-white/80 dark:bg-gray-900 dark:border-0"
        >
        {{ $this->form }}

        <x-filament::button type="submit">
            <x-filament::loading-indicator wire:loading class="w-5 h-5"/>
            <span wire:loading.remove>
                {{ __('form.log in') }}
            </span>
        </x-filament>
    </form>  

</div>



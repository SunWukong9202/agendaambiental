<div>
    <form wire:submit="create">
        {{ $this->form }}
        
        <x-filament::button type="submit">
            {{ __('form.login') }}
        </x-filament>
    </form>        
</div>

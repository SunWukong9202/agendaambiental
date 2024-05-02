
<div class="relative">
    {{ $slot }}
    <div 
    wire:loading
    class="absolute inset-0 bg-white opacity-60">
    </div>

    <div 
    wire:loading.flex
    class="flex justify-center items-center absolute inset-0">
        {{ $show }}
    </div>
</div>
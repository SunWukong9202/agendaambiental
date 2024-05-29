
<div>
    
    <div>
        <x-input.select 
        error="proveedor"
        wire:model.live="proveedor"
        placeholder="Escoge un proveedor"
        label="Proveedores*">
            <option value="" >Selecciona un proveedor</option>
            @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
            @endforeach
        </x-input>
    </div>

    {{-- <livewire:pages.forms.proveedor wire:model="form" /> --}}
    {{-- {{ $form->proveedor?->nombre ?? 'NO SELECCIONADO' }} --}}

</div>

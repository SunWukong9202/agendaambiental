<div>
    <x-table.dropdown
    
        x-init="expanded = true"
        class="!px-0 py-4"
        :persistent="false">
        <x-slot:trigger>
            <x-disclosure-button>
                Datos Generales
            </x-disclosure>
        </x-slot>

        <x-input.group>
            <x-input.text wire:model.stop="form.nombre" label="Nombre*" error="form.nombre" />
            
            <div class="flex">
                <x-input.radio  
                value="No"
                wire:model="rfcPersonaMoral"
                label="RFC para personas fisicias" />
                <x-input.radio 
                value=Yes"
                wire:model="rfcPersonaMoral"
                label="RFC para personas morales" />
            </div>
            <x-input.text 
                wire:model.stop="form.rfc"
                label="RFC*"
                error="form.rfc"
                x-mask:dynamic="$wire.rfcPersonaMoral ? 'aaa999999aaa' : 'aaaa999999aaa'"
                x-on:input="event.target.value = event.target.value.toUpperCase()"
            />
        </x-input>

        <x-input.group class="mt-4 md:mt-5">
            <x-input.text 
            wire:model.stop="form.razon_social"
            label="Razon Social*" error="form.razon_social" />

            <x-input.text 
            wire:model.stop="form.giro_empresa"
            label="Giro de la empresa*" error="form.giro_empresa" />
        </x-input>
    </x-table.dropdown>

    <x-table.dropdown 
        {{-- :x-init="$errors->has('form.cp') || $errors->has('form.num_ext') ? 'expanded = true' : ''" --}}
        :x-init="$form->hasErrors('cp', 'num_ext') ? 'expanded = true' : ''"
        class="!px-0 py-4"
        {{-- class="px-4 pb-2 pt-4 text-sm text-gray-500" --}}
        :persistent="false">
        <x-slot:trigger>
            <x-disclosure-button>
                Direccion
            </x-disclosure-button>
        </x-slot>
        
        <div class="flex gap-4 ">
            <x-input.text 
            wire:model.stop.blur="form.cp"
            x-mask="99999"
            label="CP*" error="form.cp" />

            <x-input.text 
            wire:model.stop="form.num_ext"
            x-mask="#99999"
            label="Num Exterior*" error="form.num_ext" />

            <x-input.text 
            x-mask="#99999"
            wire:model.stop="form.num_int"
            label="Num Interno" error="form.num_int" />
        </div>

        <div class="flex gap-4 mt-4 md:mt-5">

            <x-input.select 
            error="form.colonia"
            wire:model="form.colonia"
            placeholder="Escoge una colonia"
            label="Colonia*">
                <option disabled>Selecciona una colonia</option>
                @foreach ($form->colonias as $colonia)
                    <option value="{{ $colonia }}">{{ $colonia }}</option>
                @endforeach
            </x-input>
            {{-- <x-input.text 
            wire:model.stop="form.colonia"
            label="Colonia" error="form.colonia" /> --}}

            <x-input.text 
            wire:model.stop="form.calle"
            label="Calle*" error="form.calle" />
        </div>

        <div class="flex gap-4 mt-4 md:mt-5">
            <x-input.text 
            wire:model.stop="form.estado"
            label="Estado" error="form.estado" />

            <x-input.text 
            wire:model.stop="form.municipio"
            label="Municipio" error="form.municipio" />
        </div>
    </x-table.dropdown>

    <x-table.dropdown 
        {{-- :x-init="$errors->has('form.correo') || $errors->has('form.telefono') ? 'expanded = true' : ''" --}}
        :x-init="$form->hasErrors('correo', 'telefono') ? 'expanded = true' : ''"
        class="!px-0 py-4"
        :persistent="false">
        <x-slot:trigger>
            <x-disclosure-button>
                Datos de contacto
            </x-disclosure-button>
        </x-slot>
        <div class="flex gap-4">
            <x-input.text 
            wire:model.stop="form.correo"
            label="Correo*" error="form.correo" />

            <x-input.text 
            wire:model.stop="form.telefono"
            x-mask="(999) 999 9999"
            label="Telefono*" error="form.telefono" />
        </div>
    </x-table.dropdown>
    
    @if (!isset($form->proveedor))
        <x-modal-footer>
            <div class="ml-auto">
                <x-loading.wrapper class="!justify-end inset-y-0 right-2">
                    <x-button  
                    wire:click="$dispatch('create-proveedor')"
                    class="ml-auto !px-10 py-2 !mr-0 !mb-0">
                        Registrar
                    </x-button>
                    <x-slot:show>
                        <x-loading class="!fill-marine-600 !w-4 !h-4"/>
                    </x-slot>
                </x-loading>
            </div>
        </x-modal-footer> 
    @else
        <x-modal-footer>
            <x-button.secondary 
            @click="open = false"
            class="ml-auto"
            text="Descartar" />

            <x-button
            wire:click="$dispatch('edit-proveedor')"
            >
                Guardar
            </x-button>                    
        </x-modal-footer>
    @endif
</div>

<div class="max-w-6xl mx-auto">

    <x-utils.breadcrumb 
    :routes="[
        'Solicitar' => 'client.home',
        $type,
    ]"
    />

    <h2 class="mb-4 text-2xl font-bold leading-none tracking-tight text-gray-500 md:text-4xl dark:text-white py-4">

        {{ 
            match($type) 
            {
                'articulos' => 'Solicita un articulo',
                'reactivos' => 'Solicita tus reactivos',
                'donacion' => 'Dona tus reactivos aqui'  
            }           
        }}
    </h2>

    <div class="fixed top-16 right-3 z-30">
        <x-toast
        message="{!! $successMessage !!}"
        wire:model="success"
        x-effect="if($wire.success) setTimeout(()=> $wire.success = false, 5000)"
        />
    </div>
    @if ($type == 'donacion')

    <x-input.select 
    wire:model.stop.live="id"
    label="Reactivo*" 
    error="id">
        <option value="">Selecciona un reactivo para donar</option>
        @foreach ($reactivos as $reactivo)
            <option value="{{ $reactivo->id }}">{{ $reactivo->nombre }}</option>
        @endforeach
    </x-input.select>
    
    <form 
    class="mt-4"
    x-show="$wire.show"
    wire:submit="donar">          
        <x-table.dropdown            
        x-cloak 
        x-init="expanded = true"
        class="!px-0 py-4"
        :persistent="false">
            <x-slot:trigger>
                <x-disclosure-button>
                    Caracteristicas
                </x-disclosure>
            </x-slot>

            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-4 md:mt-5">
                <x-input.text
                wire:model.stop="form.envase"
                label="Envase*" error="form.envase" />
    
                <x-input.text
                wire:model.stop="form.peso"
                x-mask:dynamic="$money($input, '.', '', 2)"
                label="Peso ({{ $this->form?->reactivo->unidad ?? '' }})*" error="form.peso" />
    
                <x-input.text
                x-mask:dynamic="$money($input, '.', '', 2)"
                wire:model.stop="form.cantidad"
                label="Cantidad*" error="form.cantidad" />
                    
                <x-input.select 
                wire:model.stop="form.estado"
                label="Estado Quimico*" 
                error="form.estado">
                    <option value="">Selecciona un estado quimico</option>
                    @foreach (\App\Enums\Estado::cases() as $estado)
                        <option value="{{ $estado->value }}">{{ $estado->name }}</option>
                    @endforeach
                </x-input.select>
    
                <x-input.select 
                wire:model.stop="form.condicion"
                label="Condicion del reactivo*" 
                error="form.condicion">
                    <option value="">Selecciona un estado quimico</option>
                    @foreach (\App\Enums\Condicion::cases() as $condicion)
                        <option value="{{ $condicion->value }}">{{ $condicion->name }}</option>
                    @endforeach
                </x-input.select>
    
                <x-input.text 
                x-cloak 
                class="mb-4"
                x-mask="99/99/9999"
                wire:model.stop="form.caducidad" 
                label="Fecha de Caducidad" 
                error="form.caducidad"
                />
    
                <x-input.text
                wire:model.stop="form.fac_proc"
                label="Facultad*" error="form.fac_proc" />
    
                <x-input.text
                wire:model.stop="form.lab_proc"
                label="Laboratorio*" error="form.lab_proc" />
    
            </div>
        </x-table.dropdown> 

        <x-table.dropdown                   
        {{-- x-init="expanded = true" --}}
        class="!px-0 py-4"
        :persistent="false">
            <x-slot:trigger>
                <x-disclosure-button>
                    Propiedades Quimicas
                </x-disclosure>
            </x-slot>
            @foreach (\App\Enums\CRETIB::cases() as $propiedad)
                <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                    <input id="bordered-checkbox-1" type="checkbox"
                    value="{{ $propiedad->value }}"
                    wire:model="form.CRETIB"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="bordered-checkbox-1" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $propiedad->label() }}</label>
                </div>
            @endforeach
        </x-table.dropdown> 

        <x-loading.wrapper class="!justify-end inset-y-0 right-2">
            <x-button type="submit" class="flex items-center font-semibold !px-8 ml-auto"
            >
                Donar                   
            </x-button>
            <x-slot:show>
                <x-loading class="!fill-marine-600 !w-4 !h-4"/>
            </x-slot>
        </x-loading>

        </div>

    </form>
    @else
    <form wire:submit="solicitar">

        <div class="flex flex-col gap-4  mt-4 md:mt-5">
            
            <div x-show="$wire.founded">
                <x-input.select 
                wire:model.stop="id"
                label="Selecciona un {{ substr($type, 0, strlen($type) - 1) }}*" 
                error="id">
                    <option value="">Selecciona un {{ substr($type, 0, strlen($type) - 1) }}</option>
                    @if ($type == 'reactivos')
                        @foreach ($reactivos as $reactivo)
                            <option value="{{ $reactivo->id }}">{{ $reactivo->nombre }}</option>
                        @endforeach
                    @else
                        @foreach ($articulos as $articulo)
                            <option value="{{ $articulo->id }}">{{ $articulo->nombre }}</option>
                        @endforeach
                    @endif
                </x-input.select>
            </div>

            <div class="flex items-center mt-4">
                <span>Encontro el {{ substr($type, 0, strlen($type) -1) }} que buscaba?</span>
                <x-input.toggle 
                class="ml-4"
                wire:model="founded" >
                </x-input>
            </div>

            <div x-show="!$wire.founded">
                <x-utils.alert class="mt-4">
                    <span class="font-medium">Escriba el nombre del {{ substr($type, 0, strlen($type) - 1) }} que buscaba</span><br>
                </x-utils>

                <x-input.text
                wire:model.stop="otro"
                label="Nombre*" error="otro" />
            </div>

            <x-input.text
            x-show="$wire.type == 'reactivos'"
            x-mask:dynamic="$money($input, '.', '', 2)"
            wire:model.stop="cantidad"
            label="Cantidad*" error="cantidad" />

            <x-utils.alert class="mt-4">
                <span class="font-medium">Aqui puedes especificar: </span><br>
                Si estas bien con un {{ substr($type, 0, strlen($type) - 1) }} en cierto estado (usado, seminuevo) <br>
                Si prefieres que tenga ciertas caracteristicas. <br>
                etc.
            </x-utils>

            <x-input.text-area
            placeholder="Adelante agrega un comentario"
            wire:model.stop="comentario"
            label="Comentario" error="comentario" />


            <x-loading.wrapper class="!justify-end inset-y-0 right-2">
                <x-button type="submit" class="flex items-center font-semibold !px-8 ml-auto">
                    Solicitar                   
                </x-button>
                <x-slot:show>
                    <x-loading class="!fill-marine-600 !w-4 !h-4"/>
                </x-slot>
            </x-loading>

        </div>

    </form>
    @endif
</div>

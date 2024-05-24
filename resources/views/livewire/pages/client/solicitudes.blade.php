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
</div>

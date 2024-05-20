<div class="relative">

    {{-- TOATS DEL CRUD --}}
    {{-- <div class="fixed bottom-5 right-5 z-30">
        <x-toast
        wire:model="createSuccess"
        class="!max-w-sm"
        x-effect="if($wire.createSuccess) setTimeout(()=> $wire.createSuccess = false, 3000)">
            <div class="p-3">
                <span class="font-semibold">acopio Creado Existosamente</span><br>
                {{ $form->acopio?->nombre ?? 'El acopio' }}&nbsp;fue agregado a la tabla
            </div>
        </x-toast>

        <x-toast
        message="acopio editado con éxito"
        wire:model="editSuccess"
        x-effect="if($wire.editSuccess) setTimeout(()=> $wire.editSuccess = false, 3000)"/>
        
        <x-toast
        wire:model="deleteSuccess"
        x-effect="if($wire.deleteSuccess) setTimeout(()=> $wire.deleteSuccess = false, 3000)">
        {{ $form->acopio?->nombre ?? 'El acopio' }}&nbsp;fue eliminado
        </x-toast>
    </div> --}}

    {{-- MODAL PARA VISTA/MODIFICACION --}}
    <x-modal wire:model="modalOpen" 
    outsideTrigger
    :header="match($action) {
        'create' => 'Crear Nuevo acopio',
        'edit' => 'Editar acopio '.$form->nombre,
        'show' => 'Acopio '.$form->nombre,
        default => 'Formulario de acopios'
    }"
    >
        @if ($action == 'create')
            <form wire:submit="create">
                <div class="flex gap-4">
                    <x-input.text wire:model.stop="form.nombre" label="Nombre*" error="form.nombre" />
                    <x-input.text 
                        wire:model.stop="form.sede"
                        label="Sede*"
                        error="form.sede"
                        x-on:input="event.target.value = event.target.value.toUpperCase()"
                    />
                </div>
                
                <x-input.text-area 
                    class="mt-4"
                    wire:model.stop="form.descripcion"
                    label="Descripcion"
                    error="form.descripcion"
                    placeholder="Ingresa una pequeña descripcion del acopio"
                />

                <x-utils.alert class="mt-4">
                    <span class="font-medium">Esta opcion</span> publica el
                    acopio en el momento de su creacion. Eso significa que
                    sera publicado al publico. Pero solo aquellos con permisos
                    podran registrar movimientos.
                </x-utils>

                <div class="flex items-center mt-4">
                    <span>Desea publicar el acopio al momento de su creacion?</span>
                    <x-input.toggle 
                    class="ml-4"
                    wire:model="form.autoEnable" >
                    </x-input>
                </div>

                <x-utils.alert class="mt-4">
                    <span class="font-medium">Esta opcion</span> te permite
                    programar la fecha en que el acopio sera creado publicado
                    si aplicable. 
                </x-utils>

                <div class="flex items-center mt-4">
                    <span>Desea programar el acopio?</span>
                    <x-input.toggle 
                    class="ml-4"
                    wire:model="form.programable" >
                    </x-input>
                </div>

                @if ($form->programable)
                    <x-input.text 
                        class="my-4"
                        wire:model.stop="form.ini_evento" 
                        label="Fecha de publicacion" 
                        x-mask="99/99/9999" placeholder="MM/DD/YYYY"
                        error="form.ini_evento" />
                @endif

                
                <x-modal-footer>
                    <div class="ml-auto">
                        <x-loading.wrapper class="!justify-end inset-y-0 right-2">
                            <x-button type="submit" class="ml-auto !px-10 py-2 !mr-0 !mb-0">
                                Registrar
                            </x-button>
                            <x-slot:show>
                                <x-loading class="!fill-marine-600 !w-4 !h-4"/>
                            </x-slot>
                        </x-loading>
                    </div>
                </x-modal-footer>
            </form>
        @elseif ($action == 'edit')
            En progreso
        @elseif ($action == 'show')
            En progreso 
            <x-modal-footer></x-modal-footer>
        @endif
    </x-modal>

    {{-- BUSQUEDA  Y CREACION--}}
    <div class="flex items-center pb-4 md:pb-5">
        <x-input.search 
        class="w-80 !p-0"
        placeholder="Busca acopios"
        wire:model.live.debounce.350ms="search">
        <x-icon.circle class="cursor-pointer" wire:click="clear"/>
        </x-input>

        {{-- <x-button wire:click="test">
            toast
        </x-button> --}}

        <x-button 
        wire:click="setAction('create')"
        class=" flex items-center ml-auto font-semibold">
            <x-icon.plus class="!w-5 !h-5 mr-2"/>
            Nuevo
        </x-button>

    </div>

    {{-- TABLA --}}
    <x-loading.wrapper>
        <x-slot:show>
            <x-loading class="!w-14 !h-14 !fill-marine-600"/>
        </x-slot>

        <x-table 
        class="p-8"
        :columns="[
            'Nombre' => ['nombre', $sortCol, $sortAsc],
            'Descripcion',// => ['total', $sortCol, $sortAsc],
            'Sede' => ['sede', $sortCol, $sortAsc],
            'inicio' => ['correo', $sortCol, $sortAsc],
            'Creado' => ['created_at', $sortCol, $sortAsc],
            'Accion'
            ]">
            @foreach ($acopios as $acopio)
            <tr 
            class="hover:bg-gray-50"
            wire:key="{{ $acopio->id }}">
                <td class="whitespace-nowrap p-3 text-sm">
                    <div class="flex gap-1">
                    {{ $acopio->nombre }}
                    </div>
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    <x-utils.tooltip>
                        <x-slot:trigger>
                            <x-table.truncable-col>
                                {{ $acopio->descripcion  }}
                            </x-table>
                        </x-slot>
                        {{ $acopio->descripcion }}
                    </x-utils>
                </td>

                <td class="whitespace-nowrap p-3 text-sm">
                    <div>{{ $acopio->sede }}</div>
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    {{ $acopio->fechaLegible('ini_evento') }}
                </td>

                <td class="whitespace-nowrap p-3 text-sm">
                    {{ $acopio->fechaLegible('created_at') }}
                </td>

                <td>
                    <x-table.dropdown>
                        <x-slot:trigger>
                            <x-icon.button>
                                <x-icon.dots-vertical class="rotate-90"/>
                            </x-icon>
                        </x-slot>
                        <x-table.closable>
                            <x-table.button 
                            wire:click="setAction('show', {{ $acopio->id }})"
                            text="Mostrar"/>
                        </x-table>
                        <x-table.closable>
                            <x-table.button 
                            wire:click="setAction('edit', {{ $acopio->id }})" text="Editar"/>
                        </x-table>
                        <x-table.closable>
                            <x-table.button
                            wire:confirm.prompt="Estas Seguro?\n\nEscribe DELETE Para Confirmar|DELETE"
                            wire:click="delete({{ $acopio->id }})" text="Eliminar"/>
                        </x-table>
                    </x-table>
                </td>
            </tr>
            @endforeach
        </x-table>
            @if ($acopios->isEmpty())
                <div class="p-16 flex items-center justify-center text-xl">
                    Sin resultados para: 
                    <span 
                    class="font-semibold"
                    >&nbsp;&nbsp;"{{ $search }}"</span>
                </div>
            @endif
    </x-loading>
    
    <div class="pt-4 flex justify-between items-center">
        <div class="text-gray-700 text-sm">
            Resultados: {{ $acopios->total() }}
        </div>

        {{ $acopios->links('components.pagination') }}
    </div>
</div>


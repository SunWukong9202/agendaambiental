<div>
    <div class="fixed bottom-5 right-5 z-30">
        <x-toast
        wire:model="actionSuccess"
        class="!max-w-sm"
        x-effect="if($wire.actionSuccess) setTimeout(()=> $wire.actionSuccess = false, 5000)">
            <div class="p-3">
                {!! $actionMessage !!}
            </div>
        </x-toast>
    </div>

    {{-- MODAL PARA VISTA/MODIFICACION --}}
    <x-modal wire:model="modalOpen" 
    outsideTrigger
    :header="match($action) {
        'create' => 'Crear Nuevo Articulo',
        'edit' => 'Editar Articulo: '.$form->nombre,
        'show' => 'Articulo '.$form->nombre,
        default => 'Formulario de articulos'
    }"
    >
        @if ($action == 'create' || $action == 'edit')
            <form wire:submit="{{ $action }}">
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-4">
                    <x-input.text 
                    wire:model.stop="form.nombre"
                    label="Nombre*" error="form.nombre" />

                    <x-input.text
                    x-mask:dynamic="$money($input, '.', '', 0)"
                    wire:model.stop="form.cantidad"
                    label="Cantidad*" error="form.cantidad" />

                </div>
                @if ($action == 'create')
                    <x-modal-footer>
                        <div class="ml-auto">
                            <x-loading.wrapper class="!justify-end inset-y-0 right-2">
                                <x-button type="submit" class="ml-auto !px-10 py-2 !mr-0 !mb-0">
                                    Agregar
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

                        <x-button type="submit">
                            Guardar
                        </x-button>                    
                    </x-modal-footer>
                @endif
            </form>
        @elseif ($action == 'show')
                <x-utils.text-info
                    title="Nombre*">
                    {{ $form->nombre }}
                </x-utils>

                <x-utils.text-info
                    title="Cantidad">
                    {{ $form->cantidad }}
                </x-utils>

                <x-utils.text-info
                title="Agregado">
                    <span
                    x-text="flatpickr.formatDate(new Date('{{ $form->articulo->created_at->toIso8601String() }}'), 'F j, Y h:i K')"
                    ></span>
                </x-utils>

            <x-modal-footer></x-modal-footer>
        @endif
    </x-modal>

    {{-- BUSQUEDA  Y CREACION--}}
    <div class="flex items-center pb-4 md:pb-5">
        <x-input.search 
        class="w-80 !p-0"
        placeholder="Busca articulos"
        wire:model.live.debounce.350ms="search">
        <x-icon.circle class="cursor-pointer" wire:click="clear"/>
        </x-input>

        <x-button 
        wire:click="setAction('create')"
        class=" flex items-center ml-auto font-semibold">
            <x-icon.plus class="!w-5 !h-5 mr-2"/>
            Nuevo
        </x-button>

    </div>

    <x-loading.wrapper>
        <x-slot:show>
            <x-loading class="!w-14 !h-14 !fill-marine-600"/>
        </x-slot>
        <x-table 
        class="p-8"
        :columns="[
            'Nombre',
            'Cantidad',
            'Agregado',
            '',
            ]">
            @foreach ($articulos as $articulo)
            <tr 
            class="hover:bg-gray-50"
            wire:key="{{ $articulo->id }}">
                <td class="whitespace-nowrap p-3 text-sm">
                    <div class="flex gap-1">
                    {{ $articulo->nombre }}
                    </div>
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    <div>{{ $articulo->cantidad }}</div>
                </td>
    
                <td 
                x-text="flatpickr.formatDate(new Date('{{ $articulo->created_at->toIso8601String() }}'), 'F j, Y h:i K')"
                class="whitespace-nowrap p-3 text-sm">
                </td>
    
                <td >
                    <x-table.dropdown>
                        <x-slot:trigger>
                            <x-icon.button>
                                <x-icon.dots-vertical class="rotate-90"/>
                            </x-icon>
                        </x-slot>
                        <x-table.closable>
                            <x-table.button 
                            wire:click="setAction('show', {{ $articulo->id }})"
                            text="Mostrar"/>
                        </x-table>
                        <x-table.closable>
                            <x-table.button 
                            wire:click="setAction('edit', {{ $articulo->id }})" text="Editar"/>
                        </x-table>
                        <x-table.closable>
                            <x-table.button
                            wire:confirm.prompt="Estas Seguro?\n\nEscribe DELETE Para Confirmar|DELETE"
                            wire:click="delete({{ $articulo->id }})" text="Eliminar"/>
                        </x-table>
                    </x-table>
                </td>
            </tr>
            @endforeach
        </x-table>
        @if ($articulos->isEmpty())
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
            Resultados: {{ $articulos->total() }}
        </div>

        {{ $articulos->links('components.pagination') }}
    </div>
</div>

<div class="relative">

    <div class="fixed bottom-5 right-5 z-30">
        <x-toast
        wire:model="createSuccess"
        class="!max-w-sm"
        x-effect="if($wire.createSuccess) setTimeout(()=> $wire.createSuccess = false, 3000)">
            <div class="p-3">
                <span class="font-semibold">Reactivo Creado Existosamente</span><br>
                {{ $form->reactivo?->nombre ?? 'El reactivo' }}&nbsp;fue agregado a la tabla
            </div>
        </x-toast>

        <x-toast
        message="Reactivo editado con éxito"
        wire:model="editSuccess"
        x-effect="if($wire.editSuccess) setTimeout(()=> $wire.editSuccess = false, 3000)"/>
        
        <x-toast
        wire:model="deleteSuccess"
        x-effect="if($wire.deleteSuccess) setTimeout(()=> $wire.deleteSuccess = false, 3000)">
        {{ $form->reactivo?->nombre ?? 'El Reactivo' }}&nbsp;fue eliminado
        </x-toast>
    </div>

    <x-modal wire:model="modalOpen" 
    outsideTrigger
    :header="match($action) {
        'create' => 'Crear Nuevo Reactivo',
        'edit' => 'Editar Reactivo '.$form->nombre,
        'show' => 'Reactivo '.$form->nombre,
        default => 'Formulario de Reactivos'
    }"
    >
        {{-- <div>
            @error('form.unidad') <span class="text-red-600">{{ $message }}</span> @enderror
        </div> --}}
        @if ($action == 'create')
            <form wire:submit="create">
                <div class="flex gap-4">
                    <x-input.text wire:model="form.nombre" label="Nombre*" error="form.nombre" />
                    <x-input.text 
                    wire:model="form.grupo"
                    label="Grupo*" error="form.grupo" />
                </div>
                <div class="flex gap-4 mt-4 md:mt-5">
                    <x-input.text 
                    wire:model="form.formula"
                    label="Formula*" error="form.formula" />

                    <x-input.select 
                    wire:model="form.unidad"
                    error="form.unidad"
                    label="Unidad De Medida*">
                        <option value="" disabled>Selecciona una unidad</option>
                        @foreach ($form->getUnidades() as $unidad => $unidadConFormato)
                            <option value="{{ $unidad }}">{{ $unidadConFormato }}</option>
                        @endforeach
                    </x-input>

                    {{-- <x-input.text label="Unidad De Medida*" error="unidad" /> --}}
                </div>
                <div class="flex gap-4 my-4 md:my-5">
                    <x-input.text 
                    x-mask:dynamic="$money($input, '.', '', 2)"
                    wire:model="form.total"
                    label="Cantidad En Existencia" 
                    error="form.total" />
                    <div class="w-full pt-7 flex items-center">
                        <x-input.toggle 
                        wire:model="form.visible" >
                        {{ $form->visible ? 'Visible': 'Oculto'}}
                        </x-input>
                    </div>
                </div>

                <x-modal-footer>
                    <div class="ml-auto">
                        <x-loading.wrapper class="!justify-end inset-y-0 right-2">
                            <x-button type="submit" class="ml-auto !px-10 py-2 !mr-0 !mb-0">
                                Crear
                            </x-button>
                            <x-slot:show>
                                <x-loading class="!fill-marine-600 !w-4 !h-4"/>
                            </x-slot>
                        </x-loading>
                    </div>
                </x-modal-footer>
            </form>
        @elseif ($action == 'edit')
            <form wire:submit="edit">
                <div class="flex gap-4">
                    <x-input.text wire:model.blur="form.nombre" label="Nombre*" error="form.nombre" />
                    <x-input.text 
                    wire:model.blur="form.grupo"
                    label="Grupo*" error="form.grupo" />
                </div>
                <div class="flex gap-4 mt-4 md:mt-5">
                    <x-input.text 
                    wire:model.blur="form.formula"
                    label="Formula*" error="form.formula" />
                    <x-input.select 
                    wire:model="form.unidad"
                    error="form.unidad"
                    label="Unidad De Medida*">
                        <option disabled>Selecciona una unidad</option>
                        @foreach ($form->getUnidades() as $unidad => $unidadConFormato)
                            <option value="{{ $unidad }}">{{ $unidadConFormato }}</option>
                        @endforeach
                    </x-input>
                    {{-- <x-input.text label="Unidad De Medida*" error="unidad" /> --}}
                </div>
                <div class="flex gap-4 my-4 md:my-5">
                    <x-input.text 
                    x-mask:dynamic="$money($input, '.', '', 2)"
                    wire:model="form.total"
                    label="Cantidad En Existencia" 
                    error="form.total" />
                    <div class="w-full pt-7 flex items-center">
                        <x-input.toggle 
                        wire:model="form.visible" >
                        {{ $form->visible ? 'Visible': 'Oculto'}}
                        
                        </x-input>
                    </div>
                </div>

                <x-modal-footer>
                    <x-button.secondary 
                    @click="open = false"
                    class="ml-auto"
                    text="Descartar" />

                    <x-button type="submit">
                        Guardar
                    </x-button>                    
                </x-modal-footer>
            </form>
        @elseif ($action == 'show')
            <div class="flex gap-4">
                <x-input.text disabled wire:model="form.nombre" label="Nombre*" error="nombre" />
                <x-input.text disabled
                wire:model="form.grupo"
                label="Grupo*" error="grupo" />
            </div>
            <div class="flex gap-4 mt-4 md:mt-5">
                <x-input.text disabled
                wire:model="form.formula"
                label="Formula*" error="formula" />
                <x-input.select disabled
                wire:model="form.unidad"
                error="form.unidad"
                label="Unidad De Medida*">
                    <option value="" disabled>Selecciona una unidad</option>
                    @foreach ($form->getUnidades() as $unidad => $unidadConFormato)
                        <option value="{{ $unidad }}">{{ $unidadConFormato }}</option>
                    @endforeach
                </x-input>
                {{-- <x-input.text label="Unidad De Medida*" error="unidad" /> --}}
            </div>
            <div class="flex gap-4 my-4 md:my-5">
                <x-input.text disabled
                x-mask:dynamic="$money($input, '.', '', 2)"
                wire:model="form.total"
                label="Cantidad En Existencia" 
                error="total" />
                <div class="w-full pt-7 flex items-center">
                    <x-input.toggle disabled
                    wire:model="form.visible" >
                    {{ $form->visible ? 'Visible': 'Oculto'}}
                    
                    </x-input>
                </div>
            </div>
            <x-modal-footer></x-modal-footer>
        @endif
    </x-modal>

    <div class="flex items-center pb-4 md:pb-5">
        <x-input.search 
        class="w-80 !p-0"
        placeholder="Busca Reactivos"
        wire:model.live.debounce.350ms="search">
        <x-icon.circle class="cursor-pointer" wire:click="clear"/>
        </x-input>

        {{-- <x-button wire:click="test">
            toast
        </x-button> --}}

        <x-button 
        wire:click="setCreate"
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
            'Nombre' => ['nombre', $sortCol, $sortAsc],
            'Grupo' => ['grupo', $sortCol, $sortAsc],
            'Formula',
            'Disponible' => ['total', $sortCol, $sortAsc],
            'Estado',
            'Creado' => ['created_at', $sortCol, $sortAsc],
            'Accion'
            ]">
            @foreach ($reactivos as $reactivo)
            <tr 
            class="hover:bg-gray-50"
            wire:key="{{ $reactivo->id }}">
                <td class="whitespace-nowrap p-3 text-sm">
                    <div class="flex gap-1">
                    {{ $reactivo->nombre }}
                    </div>
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    <div>{{ $reactivo->grupo }}</div>
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    <div class="rounded-full py-0.5 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-white text-xs bg-blue-500 opacity-75">
                        <div>{{ $reactivo->formula }}</div>
                    </div>
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    {{ $reactivo->total .' '.$reactivo->unidad }}
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    {{ $reactivo->visible ? 'Visible' : 'Oculto' }}
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    {{ $reactivo->fechaLegible('created_at') }}
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
                            wire:click="setAction({{ $reactivo->id }}, 'show')"
                            text="Mostrar"/>
                        </x-table>
                        <x-table.closable>
                            <x-table.button 
                            wire:click="setAction({{ $reactivo->id }}, 'edit')" text="Editar"/>
                        </x-table>
                        <x-table.closable>
                            <x-table.button
                            wire:confirm.prompt="Estas Seguro?\n\nEscribe DELETE Para Confirmar|DELETE"
                            wire:click="delete({{ $reactivo->id }})" text="Eliminar"/>
                        </x-table>
                    </x-table>
                </td>
            </tr>
            @endforeach
        </x-table>
            @if ($reactivos->isEmpty())
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
            Resultados: {{ $reactivos->total() }}
        </div>

        {{ $reactivos->links('components.pagination') }}
    </div>
</div>
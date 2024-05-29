<x-slot:title>
    Panel de administracion - Proveedores
</x-slot>
<div class="relative">

    {{-- TOATS DEL CRUD --}}
    <div class="fixed bottom-5 right-5 z-30">
        <x-toast
        wire:model="createSuccess"
        class="!max-w-sm"
        x-effect="if($wire.createSuccess) setTimeout(()=> $wire.createSuccess = false, 3000)">
            <div class="p-3">
                <span class="font-semibold">Proveedor Creado Existosamente</span><br>
                {{ $form->proveedor?->nombre ?? 'El proveedor' }}&nbsp;fue agregado a la tabla
            </div>
        </x-toast>

        <x-toast
        message="Proveedor editado con éxito"
        wire:model="editSuccess"
        x-effect="if($wire.editSuccess) setTimeout(()=> $wire.editSuccess = false, 3000)"/>
        
        <x-toast
        wire:model="deleteSuccess"
        x-effect="if($wire.deleteSuccess) setTimeout(()=> $wire.deleteSuccess = false, 3000)">
        {{ $form->proveedor?->nombre ?? 'El proveedor' }}&nbsp;fue eliminado
        </x-toast>
    </div>

    {{-- MODAL PARA VISTA/MODIFICACION --}}
    <x-modal wire:model="modalOpen" 
    outsideTrigger
    :header="match($action) {
        'create' => 'Crear Nuevo proveedor',
        'edit' => 'Editar proveedor '.$form->nombre,
        'show' => 'Proveedor '.$form->nombre,
        default => 'Formulario de proveedores'
    }"
    >
        @if ($action == 'create' || $action == 'edit')
            <form 
                wire:submit="{{ $action }}">
                <x-dropdown
                   
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
                </x-dropdown>

                <x-dropdown 
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
                </x-dropdown>

                <x-dropdown 
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
                </x-dropdown>
                @if ($action == 'create')
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
            <x-dropdown
                x-init="expanded = true"
                class="!px-0 py-4"
                :persistent="false">
                <x-slot:trigger>
                    <x-disclosure-button>
                        Datos Generales
                    </x-disclosure>
                </x-slot>
                <x-utils.text-info
                    title="Nombre">
                    {{ $form->nombre }}
                </x-utils>
                <x-utils.text-info
                    title="RFC">
                    {{ $form->rfc }}
                </x-utils>

                <x-utils.text-info
                    title="Razon Social">
                    {{ $form->razon_social }}
                </x-utils>
                <x-utils.text-info
                    title="Giro de la empresa">
                    {{ $form->giro_empresa }}
                </x-utils>
            </x-dropdown>

            <x-dropdown 
                class="!px-0 py-4"
                {{-- class="px-4 pb-2 pt-4 text-sm text-gray-500" --}}
                :persistent="false">

                <x-slot:trigger>
                    <x-disclosure-button>
                        Datos de contacto
                    </x-disclosure-button>
                </x-slot>
                
                <x-utils.text-info
                    title="Direccion">
                    {{ $form->proveedor->direccion() }}
                </x-utils>

                <x-utils.text-info
                    title="Correo">
                    {{ $form->correo }}
                </x-utils>

                <x-utils.text-info
                    title="Telefono">
                    {{ $form->telefono }}
                </x-utils>
                
            </x-dropdown>


            <x-modal-footer></x-modal-footer>
        @endif
    </x-modal>

    {{-- BUSQUEDA  Y CREACION--}}
    <div class="flex items-center pb-4 md:pb-5">
        <x-input.search 
        class="w-80 !p-0"
        placeholder="Busca proveedores"
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
            'RFC' => ['rfc', $sortCol, $sortAsc],
            'Direccion',// => ['total', $sortCol, $sortAsc],
            'Telefono' => ['telefono', $sortCol, $sortAsc],
            'Correo' => ['correo', $sortCol, $sortAsc],
            'Razon Social',// => ['razon_social', $sortCol, $sortAsc],
            'Giro de la empresa',// => ['', $sortCol, $sortAsc],
            'Registrado' => ['created_at', $sortCol, $sortAsc],
            'Accion'
            ]">
            @foreach ($proveedores as $proveedor)
            <tr 
            class="hover:bg-gray-50"
            wire:key="{{ $proveedor->id }}">
                <td class="whitespace-nowrap p-3 text-sm">
                    <div class="flex gap-1">
                    {{ $proveedor->nombre }}
                    </div>
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    <div>{{ $proveedor->rfc }}</div>
                </td>

                <td class="whitespace-nowrap p-3 text-sm">
                    <x-utils.tooltip>
                        <x-slot:trigger>
                            <x-table.truncable-col>
                                {{ $proveedor->direccion()  }}
                            </x-table>
                        </x-slot>
                        {{ $proveedor->direccion() }}
                    </x-utils>
                </td>

                <td class="whitespace-nowrap p-3 text-sm">
                    <div>{{ $proveedor->telefono }}</div>
                </td>

                <td class="whitespace-nowrap p-3 text-sm">
                    <div>{{ $proveedor->correo }}</div>
                </td>

                <td class="whitespace-nowrap p-3 text-sm">
                    <div>{{ $proveedor->razon_social }}</div>
                </td>

                <td class="whitespace-nowrap p-3 text-sm">
                    <div>{{ $proveedor->giro_empresa }}</div>
                </td>
    
                <td class="whitespace-nowrap p-3 text-sm">
                    {{ $proveedor->fechaLegible('created_at') }}
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
                            wire:click="setAction('show', {{ $proveedor->id }})"
                            text="Mostrar"/>
                        </x-table>
                        <x-table.closable>
                            <x-table.button 
                            wire:click="setAction('edit', {{ $proveedor->id }})" text="Editar"/>
                        </x-table>
                        <x-table.closable>
                            <x-table.button
                            wire:confirm.prompt="Estas Seguro?\n\nEscribe DELETE Para Confirmar|DELETE"
                            wire:click="delete({{ $proveedor->id }})" text="Eliminar"/>
                        </x-table>
                    </x-table>
                </td>
            </tr>
            @endforeach
        </x-table>
        @if ($proveedores->isEmpty())
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
            Resultados: {{ $proveedores->total() }}
        </div>

        {{ $proveedores->links('components.pagination') }}
    </div>
</div>


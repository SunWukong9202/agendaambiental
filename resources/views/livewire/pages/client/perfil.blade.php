<x-slot:title>
    Modulo Gestion Ambiental - Perfil
</x-slot>
<div>
    <div x-data="{ show: false }">
        <x-icon.bars 
        @click="show = true"
        class="fixed right-2 hidden top-1 mt-2 mr-2 text-white"/>

        <div 

        class="fixed left-5 flex flex-col gap-4">
            <x-button
            x-bind:class="$wire.see == 'profile' ? '' : '!bg-white !text-black !border !border-black'"
            {{-- x-bind:class="$wire.see == 'profile' ? 'bl-2 bl-blue-200' : ''" --}}
            wire:click="$set('see', 'profile')"
            >
                Perfil           
            </x-button>
    
            <x-button
            x-bind:class="$wire.see == 'solicitudes' ? '' : '!bg-white !text-black !border !border-black'"

            wire:click="$set('see', 'solicitudes')"
            >
                Mis Solicitudes           
            </x-button>
    
            <x-button
            x-bind:class="$wire.see == 'donaciones' ? '' : '!bg-white !text-black !border !border-black'"

            wire:click="$set('see', 'donaciones')"
            >
                Mis Donaciones           
            </x-button>
        </div>
    </div>



    <div class="max-w-6xl ml-44 mr-auto mt-4 md:mt-10">

        <div x-cloak x-show="$wire.see == 'profile'">
            <h3 class="mb-4 text-lg font-bold leading-none tracking-tight text-gray-500 md:text-4xl dark:text-white py-4">
                Bienvenido {{ $form->nombre }}
            </h3>
            <x-table.dropdown                   
                x-init="expanded = true"
                class="!px-0 py-4"
                :persistent="false">
                    <x-slot:trigger>
                        <x-disclosure-button>
                            Datos Generales
                        </x-disclosure>
                    </x-slot>
                    <x-utils.text-info 
                    title="Nombre"
                    content="{{ $form->user->nombre_completo }}"
                    />
        
                    <x-utils.text-info 
                    title="Clave"
                    content="{{ $form->clave }}"
                    />
        
                    <x-utils.text-info 
                    title="Genero"
                    content="{{ $form->genero }}"
                    />
        
                    <x-utils.text-info 
                    title="Procedencia"
                    content="{{ $form->procedencia }}"
                    />
                </x-table.dropdown>

            <x-table.dropdown                   
                x-init="expanded = true"
                class="!px-0 py-4"
                :persistent="false">
                    <x-slot:trigger>
                        <x-disclosure-button>
                            Informacion de contacto
                        </x-disclosure>
                    </x-slot>
                    <x-utils.text-info 
                    title="Correo"
                    content="{{ $form->correo }}"
                    />
        
                    <x-utils.text-info 
                    title="Telefono"
                    content="{{ $form->telefono }}"
                    />
            </x-table.dropdown>
        </div>

        <div x-cloak x-show="$wire.see == 'solicitudes'">
            <x-tabs class="!max-w-full bg-marine rounded-xl !ml-auto !mr-0 mb-4" withOutRoutes>
                <x-tab-button 
                wire:click="$set('show_in_sol', 'reactivos')"
                :active="$show_in_sol == 'reactivos'"
                text="Reactivos" />

                <x-tab-button 
                wire:click="$set('show_in_sol', 'articulos')"
                :active="$show_in_sol == 'articulos'"
                text="Articulos" />
            </x-tabs>

            <x-loading.wrapper>
                <x-slot:show>
                    <x-loading class="!w-14 !h-14 !fill-marine-600"/>
                </x-slot>
                @if ($solicitudes->total() == 0)
                    <div class="min-h-80 flex items-center justify-center">
                        Oops... No tienes solicitudes
                    </div>
                @else
                <x-table 
                class="p-8"
                :columns="[
                    'Nombre',
                    'Cantidad',
                    'Estado',
                    'Solicitada',
                    ]">
                    @foreach ($solicitudes as $solicitud)
                    <tr 
                    class="hover:bg-gray-50"
                    wire:key="{{ $solicitud->id }}">
                        @if ($show_in_sol == 'reactivos')
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="flex gap-1">
                                {{ $solicitud?->reactivo->nombre ?? $solicitud->otro_reactivo }}
                                </div>
                            </td>
                        @else
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="flex gap-1">
                                {{ $solicitud?->articulo->nombre ?? $solicitud->otro_articulo }}
                                </div>
                            </td>
                        @endif

                        @if ($show_in_sol == 'reactivos')
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div>{{ $solicitud->cantidad }}</div>
                            </td>
                        @else
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div> 1 </div>
                            </td>
                        @endif

                        <td class="whitespace-nowrap p-3 text-sm">
                            @if ($solicitud->estado)
                                <x-utils.badge
                                class="flex items-center">
                                    Aprobada
                                    <x-icon.check  class="ml-2 !w-4 !h-4"/>
                                </x-utils>
                            @else
                                <x-utils.badge 
                                class="flex"
                                type="in-progress" >
                                    En Curso
                                </x-utils>
                            @endif
                        </td>
            
                        <td class="whitespace-nowrap p-3 text-sm">
                            <span 
                            x-text="flatpickr.formatDate(new Date('{{ $solicitud->created_at->toIso8601String() }}'), 'F j, Y h:i K')"
                            class="inline-block ml-auto"></span>

                        </td>
                    </tr>
                    @endforeach
                </x-table>
                @endif
            </x-loading>
            
            <div class="pt-4 flex justify-between items-center">
                <div class="text-gray-700 text-sm">
                    Resultados: {{ $solicitudes->total() }}
                </div>
        
                {{ $solicitudes->links('components.pagination') }}
            </div>
        </div>
        
        <div x-cloak x-show="$wire.see == 'donaciones'">

            <x-tabs class="!max-w-full bg-marine rounded-xl !ml-auto !mr-0 mb-4" withOutRoutes>
                <x-tab-button 
                wire:click="$set('show', 'reactivos')"
                :active="$show == 'reactivos'"
                text="Reactivos" />

                <x-tab-button 
                wire:click="$set('show', 'residuos')"
                :active="$show == 'residuos'"
                text="Residuos" />

                <x-tab-button 
                wire:click="$set('show', 'libros')"
                :active="$show == 'libros'"
                text="Libros/Cambalache" 
                />
            </x-tabs>

            <x-loading.wrapper>
                <x-slot:show>
                    <x-loading class="!w-14 !h-14 !fill-marine-600"/>
                </x-slot>
                @if ($donaciones->total() == 0)
                    <div class="min-h-80 flex items-center justify-center">
                        Oops... No tienes donaciones
                    </div>
                @else
                {{-- nombre acopio, acopio --}}
                    @foreach ($donaciones as $donacion)
                    @if ($show == 'reactivos')
                    <x-table.dropdown                   
                    {{-- x-init="expanded = true" --}}
                    class="!px-0 py-4"
                    :persistent="false">
                        <x-slot:trigger>
                            <x-disclosure-button>
                            {{ 'Donacion #'.($donacion->donacion?->id ?? '00')
                                .': '.($donacion->donacion?->reactivo?->nombre) }}                          
                            </x-disclosure>
                        </x-slot>
                            
                        <div class="flex gap-4 mt-4">
                            <div class="">
                                @if ($donacion->donacion->foto == null)
                                    @if (rand(0, 1))
                                        <x-icon.flask class="w-32 h-16"></x-icon>
                                    @else
                                        <x-icon.tube class="w-32 h-16"></x-icon> 
                                    @endif
                                @else
                                    image
                                @endif
                            </div>
                            <div class="bg-gray-50 shadow-sm p-4 flex gap-4 justify-between rounded-lg w-full">
                                <x-utils.text-info
                                title="Cantidad">
                                    {{ $donacion->donacion?->cantidad ?? '00' .' '.($donacion->donacion?->reactivo->unidad ?? '')}}
                                </x-utils>
                                <x-utils.text-info
                                title="Donada">
                                    <span 
                                    x-text="flatpickr.formatDate(new Date('{{ $donacion->donacion->created_at->toIso8601String() }}'), 'F j, Y h:i K')"
                                    class="inline-block ml-auto"></span>
                                </x-utils>
                                <x-utils.text-info
                                title="Por">
                                {{ $donacion->donacion?->user->nombre ?? 'no definido'}}
                                </x-utils>
                                
                                <x-utils.text-info
                                title="Facultad">
                                {{ $donacion->donacion?->fac_proc ?? 'no definido'}}
                                </x-utils>
            
                                <x-utils.text-info
                                title="Laboratorio">
                                {{ $donacion->donacion?->lab_proc ?? 'no definido'}}
                                </x-utils>
                            </div>
                        </div>

                        <div class="flex gap-4 mb-4 mt-8">
                            <div class="p-4 bg-gray-50 shaodw-sm w-full">
                                <x-utils.text-info
                                title="Condicion">
                                {{ $donacion->donacion?->condicion->name ?? 'no definido'}}
                                </x-utils>
                                <x-utils.text-info
                                title="Envase">
                                {{ $donacion->donacion?->envase ?? 'no definido'}}
                                </x-utils>
                                <x-utils.text-info
                                title="Peso">
                                {{ $donacion->donacion?->peso ?? 'no definido'}}
                                </x-utils>
                                <x-utils.text-info
                                title="Estado quimico">
                                {{ $donacion->donacion?->estado->name ?? 'no definido'}}
                                </x-utils>
                            </div>
            
                            <div class="p-4 bg-gray-50 shadow-sm w-full">
                                <x-utils.text-info
                                title="Propiedades">
                                    @foreach (\App\Enums\CRETIB::cases() as $propiedad)
                                    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                        <input id="bordered-checkbox-1" type="checkbox" disabled
                                        @checked($donacion->donacion?->CRETIB?->contains(fn($prop) => $prop == $propiedad))
                                        name="bordered-checkbox-{{ $donacion->donacion?->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="bordered-checkbox-1" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $propiedad->label() }}</label>
                                    </div>
                                    @endforeach
                                </x-utils>
                            </div>
                        </div>

                    </x-table.dropdown> 
                    @else
                    <x-table.dropdown                   
                    {{-- x-init="expanded = true" --}}
                    class="!px-0 py-4"
                    :persistent="false">
                        <x-slot:trigger>
                            <x-disclosure-button>
                                {{ $donacion->de_residuos ? 'Donacion de residuos' : 'Donacion de libros/cambalache' }}
                            </x-disclosure>
                        </x-slot>
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-4">
                            <x-table.dropdown                   
                            {{-- x-init="expanded = true" --}}
                            class="!px-0 py-4"
                            :persistent="false">
                                <x-slot:trigger>
                                    <x-disclosure-button>
                                        Informacion del Acopio
                                    </x-disclosure>
                                </x-slot>
                                <div class="flex ">
                                    <x-utils.text-info 
                                    class="w-full"
                                    title="Nombre:"
                                    content="{{ $donacion->acopio->nombre }}"
                                    />

                                    <x-utils.text-info
                                    class="w-full"
                                    title="Fecha:"
                                    >
                                        <span 
                                        x-text="flatpickr.formatDate(new Date('{{ $donacion->acopio->ini_evento->toIso8601String() }}'), 'F j, Y h:i K')"
                                        class="inline-block ml-auto"></span>
                                    </x-utils>                            
                                </div>

                                <div class="flex justify-between">
                                    <x-utils.text-info
                                    class="w-full"
                                    title="Sede:"
                                    >
                                        {{ $donacion->acopio->sede }}
                                    </x-utils> 
                                    
                                    <x-utils.text-info 
                                    class="w-full"
                                    title="Capturista:"
                                    content="{{ $donacion->capturista->nombre_completo }}"
                                    />
                                </div>

                            </x-table.dropdown>

                            <x-table.dropdown                   
                            {{-- x-init="expanded = true" --}}
                            class="!px-0 py-4"
                            :persistent="false">
                                <x-slot:trigger>
                                    <x-disclosure-button>
                                        Detalle
                                    </x-disclosure>
                                </x-slot>
                                
                                {{-- {{ $donacion->es_residuo }} --}}

                                @if ($show == 'residuos')
                                    <x-utils.text-info 
                                    title="Donaste:"
                                    >
                                    @foreach ($donacion->residuos as $residuo)
                                        <p>
                                        {{ $residuo->donacion->cantidad }} {{ $residuo->unidad }} de {{ $residuo->categoria }}
                                        </p>
                                    @endforeach
                                    </x-utils>
                                @else
                                    <x-utils.text-info 
                                    title="Donaste:"
                                    content="{{ $donacion->donados }} Libros"
                                    />

                                    <x-utils.text-info 
                                    title="Tomaste:"
                                    content="{{ $donacion->tomados }} Libros"
                                    />
                                @endif
                            </x-table.dropdown>
                        </div>
                    </x-table.dropdown> 
                    @endif
                               
                    @endforeach
                @endif
            </x-loading>
            
            <div class="pt-4 flex justify-between items-center">
                <div class="text-gray-700 text-sm">
                    Resultados: {{ $donaciones->total() }}
                </div>
        
                {{ $donaciones->links('components.pagination') }}
            </div>
        </div>
    
    </div>
</div>
<div>
        {{-- HABILITAR MODAL SI APLICABLE --}}

        <x-modal wire:model="modalOpen" 
        outsideTrigger
        class="max-w-3xl"
        :header="match('show') {
            'show' => 'Donacion #'.($donacion?->id ?? '00')
                .': '.($donacion?->reactivo->nombre),
            default => 'Detalle de donacion'
        }"
        >    
            <div class="flex gap-4 mb-4 md:mb-5">
                <div class="bg-gray-50 shadow-sm p-4 rounded-lg w-full">
                    <x-utils.text-info
                    title="Cantidad">
                        {{ $donacion?->cantidad ?? '00' .' '.($donacion?->reactivo->unidad ?? '')}}
                    </x-utils>
                    <x-utils.text-info
                    title="Donada">
                    {{ $donacion?->fechaLegible('created_at') ?? now() }}
                    </x-utils>
                    <x-utils.text-info
                    title="Por">
                    {{ $donacion?->user->nombre ?? 'no definido'}}
                    </x-utils>
                    
                    <x-utils.text-info
                    title="Facultad">
                    {{ $donacion?->fac_proc ?? 'no definido'}}
                    </x-utils>

                    <x-utils.text-info
                    title="Laboratorio">
                    {{ $donacion?->lab_proc ?? 'no definido'}}
                    </x-utils>
                </div>

                <div class="p-4 bg-gray-50 shaodw-sm w-full">
                    <x-utils.text-info
                    title="Condicion">
                    {{ $donacion?->condicion->name ?? 'no definido'}}
                    </x-utils>
                    <x-utils.text-info
                    title="Envase">
                    {{ $donacion?->envase ?? 'no definido'}}
                    </x-utils>
                    <x-utils.text-info
                    title="Peso">
                    {{ $donacion?->peso ?? 'no definido'}}
                    </x-utils>
                    <x-utils.text-info
                    title="Estado quimico">
                    {{ $donacion?->estado->name ?? 'no definido'}}
                    </x-utils>
                </div>

                <div class="p-4 bg-gray-50 shadow-sm w-full">
                    <x-utils.text-info
                    title="Propiedades">
                        @foreach (\App\Enums\CRETIB::cases() as $propiedad)
                        <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                            <input id="bordered-checkbox-1" type="checkbox" 
                            @checked($donacion?->CRETIB->contains(fn($prop) => $prop == $propiedad))
                            name="bordered-checkbox-{{ $donacion?->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="bordered-checkbox-1" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $propiedad->label() }}</label>
                        </div>
                        @endforeach
                    </x-utils>
                </div>
            </div>
            <x-modal-footer></x-modal-footer>
        </x-modal>


    {{-- BUSQUEDA --}}
    <div class="flex flex-wrap items-center pb-4 md:pb-5">
        <x-input.search 
        class="w-80 !p-0"
        placeholder="Busca solicitudes"
        wire:model.live.debounce.350ms="search">
        <x-icon.circle class="cursor-pointer" wire:click="clear"/>
        </x-input>

        {{-- <x-button wire:click="test">
            toast
        </x-button> --}}
    </div>

    {{-- TABLA CON INDICADORES DE CARGA Y OTRAS UTILIDADES --}}

    <x-loading.wrapper>
        <x-slot:show>
            <x-loading class="!w-14 !h-14 !fill-marine-600"/>
        </x-slot>
            <x-table
            :columns="[
                '',
                'Clave' => ['users.clave', $sortCol, $sortAsc],
                'Donador' => ['users.nombre', $sortCol, $sortAsc],    
                'Cantidad' => ['cantidad', $sortCol, $sortAsc],
                'Reactivo' => ['reactivos.nombre', $sortCol, $sortAsc],
                'Condicion' => ['condicion', $sortCol, $sortAsc],
                'Caducidad' => ['caducidad', $sortCol, $sortAsc],
                'Donado' => ['created_at', $sortCol, $sortAsc]
                ]">
                @foreach ($donaciones as $donacion)
                <tr 
                wire:click="show({{ $donacion->id }})"
                class="hover:bg-gray-50 cursor-pointer"
                wire:key="{{ $donacion->id }}">
                    <td class="whitespace-nowrap p-3 text-sm">
                        @if ($donacion->foto == null)
                            @if (rand(0, 1))
                                <x-icon.flask class="w-16 h-16"></x-icon>
                            @else
                                <x-icon.tube class="w-16 h-16"></x-icon> 
                            @endif
                        @else
                            foto
                        @endif
                    </td>
                    <td class="whitespace-nowrap p-3 text-sm">
                        <div class="flex gap-1">
                        {{ $donacion->user->clave }}
                        </div>
                    </td>

                    <td class="whitespace-nowrap p-3 text-sm">
                        <div>{{ $donacion->user->nombre}}</div>
                    </td>

                    <td class="whitespace-nowrap p-3 text-sm">
                        {{ $donacion->cantidad .' '.($donacion->reactivo?->unidad ?? '')}}
                    </td>
        
        
                    <td class="whitespace-nowrap p-3 text-sm">
                        <div>{{ $donacion->reactivo->nombre }}</div>
                    </td>

                    <td class="whitespace-nowrap p-3 text-sm">
                        <div>
                            {{ $donacion->condicion->name }}
                        </div>
                    </td>

                    <td class="whitespace-nowrap p-3 text-sm">
                        <div>
                            {{ $donacion->fechaLegible('caducidad') }}
                        </div>
                    </td>

                    <td class="whitespace-nowrap p-3 text-sm">
                        <div>
                            {{ $donacion->fechaLegible('created_at') }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </x-table>
            @if ($donaciones->isEmpty())
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
            Resultados: {{ $donaciones->total() }}
        </div>

        {{ $donaciones->links('components.pagination') }}
    </div>
</div>

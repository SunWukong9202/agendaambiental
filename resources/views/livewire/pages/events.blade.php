<x-slot:title>
    Panel de administracion - Acopios
</x-slot>

<div class="relative">

    {{-- TOATS DEL CRUD --}}
    <div class="fixed bottom-5 right-5 z-30">
        <x-toast
        x-cloak
        wire:model="actionMessage"
        class="!max-w-sm"
        x-effect="if($wire.actionMessage) setTimeout(()=> $wire.actionMessage = false, 6000)">
            <div class="p-3">
                {!! session('actionMessage') ?? $deletedMessage !!}
            </div>
        </x-toast>
    </div>

    {{-- BUSQUEDA  Y CREACION--}}
    <div class="flex flex-wrap items-center pb-4 md:pb-5">
        <x-input.search
        x-show="!$wire.seeActives"
        class="w-full sm:w-80 !p-0 order-3 sm:order-1"
        placeholder="Busca acopios"
        wire:model.live.debounce.350ms="search">
        <x-icon.circle class="cursor-pointer" wire:click="clear"/>
        </x-input>

        {{-- <x-button wire:click="test">
            toast
        </x-button> --}}

        <div class="ml-auto order-2 flex gap-4 mb-2 sm:mb-0">
            @if (!empty($this->activos))
                <x-button
                wire:click="$toggle('seeActives')"
                x-bind:class="$wire.seeActives ? 'flex items-center font-semibold !px-2' : 'animate-pulse flex items-center font-semibold !px-2'">
                {{-- class="animate-pulse flex items-center font-semibold !px-2" --}}
                    <span x-text="$wire.seeActives ? 'Regresar' : 'Ver Acopios Activos'">
                    </span>
                </x-button>
            @endif

            <x-button
            wire:click="setAction('create')"
            class="flex items-center font-semibold !px-2">
                <x-icon.plus class="!w-5 !h-5 mr-2"/>
                Nuevo
                <x-icon.angle-down
                class="text-white ml-4 -rotate-90"
                />
            </x-button>
        </div>

    </div>

    <div x-show="$wire.seeActives">
        @if (empty($this->activos))
        
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 mt-4">
                @foreach ($this->activos as $activo)
                    <x-card
                    footerClasses="!py-2 flex flex-row-reverse"
                    class="flex flex-col"
                    title="{{ $activo->nombre }}"
                    subtitle="Sede: {{ $activo->sede }}"
                    >
                        {{ $activo->descripcion }}
                        <x-slot:footer>
                            <x-button 
                            href="{{ route('admin.acopios.activos', ['acopio' => $activo->id]) }}"
                            class="ml-auto !py-0 !pr-0 inline-flex !bg-transparent !text-black hover:!text-marine-500 group">
                                Entrar 
                                <x-icon.arrow-down class="-rotate-90 !ml-2 group-hover:!text-marine-500"/>
                            </x-button>
                        </x-slot>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
    
    <div x-show="!$wire.seeActives">
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
        
                    <td class="whitespace-wrap p-3 text-sm">
                        <x-utils.tooltip>
                            <x-slot:trigger>
                                <x-table.truncable-col>
                                    {{ $acopio->descripcion  }}
                                </x-table>
                            </x-slot>
                            {{ $acopio?->descripcion ?? ''}}
                        </x-utils>
                    </td>

                    <td class="whitespace-nowrap p-3 text-sm">
                        <div>{{ $acopio->sede }}</div>
                    </td>
        
                    <td 
                    {{-- x-text="$store.utils.formatDateToLocal('{{ $acopio->ini_evento->toIso8601String() }}')" --}}
                    x-text="flatpickr.formatDate(new Date('{{ $acopio->ini_evento->toIso8601String() }}'), 'F j, Y h:i K')"
                    class="whitespace-nowrap p-3 text-sm">
                        {{-- {{ $acopio->fechaLegible('ini_evento') }} --}}
                    </td>

                    <td 
                    x-text="flatpickr.formatDate(new Date('{{ $acopio->created_at->toIso8601String() }}'), 'F j, Y h:i K')"
                    {{-- x-text="flatpickr.formatDate(new Date('{{ $acopio->created_at }}') , 'F j, Y H:i')" --}}
                    class="whitespace-nowrap p-3 text-sm">
                        {{-- {{ $acopio->fechaLegible('created_at') }} --}}
                    </td>

                    <td x-cloak>
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


</div>
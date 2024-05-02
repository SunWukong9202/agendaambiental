    <div class="">

        <x-modal wire:model="modalOpen" 
        outsideTrigger
        :header="match($action) {
            'edite' => 'Editar Reactivo '.$actionable->nombre,
            'show' => 'Reactivo '.$actionable->nombre,
            default => 'Formulario de Reactivos'
        }"
        >
        
            <x-slot:footer>
                Hello
            </x-slot>
        </x-modal>
        <div class="flex">
            <x-input.search 
            class="w-80"
            placeholder="Busca Reactivos"
            wire:model.live.debounce.350ms="search">
            <x-icon.circle class="cursor-pointer" wire:click="clear"/>
            </x-input>
        </div>
    
        <x-loading.wrapper>
            <x-slot:show>
                <x-loading class="!w-14 !h-14 !fill-amber-400"/>
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
                        {{ $reactivo->estado ? 'Visible' : 'Oculto' }}
                    </td>
        
                    <td class="whitespace-nowrap p-3 text-sm">
                        {{ $reactivo->fechaLegible('created_at') }}
                    </td>
                    <td>
                        <x-table.dropdown>
                            <x-slot:trigger>
                                <x-table.button class="!px-2 rounded-lg">
                                    <x-icon.dots-vertical class="rotate-90"/>
                                </x-table>
                            </x-slot>
                            <x-table.closable>
                                <x-table.button 
                                wire:click="show({{ $reactivo->id }})"
                                text="Mostrar"/>
                            </x-table>
                            <x-table.button 
                            wire:click="edite({{ $reactivo->id }})" text="Editar"/>
                            <x-table.button
                            wire:click="delete({{ $reactivo->id }})" text="Eliminar"/>
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

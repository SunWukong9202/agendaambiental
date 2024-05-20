<div class="relative">
    {{-- HABILITAR TOASTS SI APLICABLE --}}

    <div class="fixed bottom-5 right-5 z-30">
        <x-toast
        message="Solicitud Procesada con exito"
        wire:model="editSuccess"
        x-effect="if($wire.editSuccess) setTimeout(()=> $wire.editSuccess = false, 3000)"/>
        
        <x-toast
        wire:model="deleteSuccess"
        x-effect="if($wire.deleteSuccess) setTimeout(()=> $wire.deleteSuccess = false, 3000)">
        La solicitud del usuario {{ $form->solicitud?->user->nombre ?? 'La solicitud' }}&nbsp;fue eliminada
        </x-toast>
    </div>

    {{-- HABILITAR MODAL SI APLICABLE --}}

    <x-modal wire:model="modalOpen" 
    outsideTrigger
    :header="match($action) {
        'show' => 'Solicitud #'.($form->solicitud->id ?? '00')
            .': '.($form->solicitud->reactivo?->nombre ?? $form->solicitud->otro_reactivo),
        default => 'Formulario de Solicitudes'
    }"
    >
        {{-- <div>
            @error('form.unidad') <span class="text-red-600">{{ $message }}</span> @enderror
        </div> --}}

        @if ($action == 'edit')
            <form wire:submit="edit">
                <div class="flex gap-4">
                    
                </div>
                <x-modal-footer>
                    <div class="ml-auto">
                        <x-loading.wrapper class="!justify-end inset-y-0 right-2">
                            <x-button type="submit" class="ml-auto">
                                Crear
                            </x-button>
                            <x-slot:show>
                                <x-loading class="!fill-marine-600 !w-4 !h-4"/>
                            </x-slot>
                        </x-loading>
                    </div>
                </x-modal-footer>
            </form>
        @elseif ($action == 'show')
            <div class="flex gap-4 mb-4 md:mb-5">
                <div class="bg-slate-100 pt-4 px-4 rounded-lg min-w-[150px]">
                 <x-utils.text-info
                    title="Cantidad">
                        {{ $form->solicitud->cantidad .' '.($form->solicitud->reactivo?->unidad ?? '')}}
                  </x-utils>
                  <x-utils.text-info
                    title="Solicitada">
                    {{ $form->solicitud->fechaLegible('created_at') }}
                  </x-utils>
                  <x-utils.text-info
                    title="Por">
                    {{ $form->solicitud->user->nombre }}
                  </x-utils>
                  @if ($form->solicitud->estado)
                    <x-utils.text-info
                    title="Aceptada">
                        {{ $form->solicitud->fechaLegible('updated_at') }}
                    </x-utils>
                  @else
                    <x-utils.text-info
                    title="Estado">
                        En Curso
                    </x-utils>
                  @endif
                  
                </div>
                <div class="p-4 grow-[1]">
                    <x-utils.text-info
                    title="Comentario">
                    {{ $form->solicitud->comentario ?? 'Comentario no disponible' }}
                  </x-utils>
                </div>
            </div>
            <x-modal-footer></x-modal-footer>
        @endif
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

        <x-drawer
        outsideTrigger
        wire:model="drawerOpen"
        class="!top-10 pb-14 shadow-lg"
        :title="'Solicitud #'.($form->solicitud?->id ?? '00')
            .': '.($form->solicitud?->reactivo?->nombre 
            ?? $form->solicitud?->otro_reactivo ?? 'Anonimo')"
        >
            {{-- <x-slot:button>
                <x-button>
                    click
                </x-button>
            </x-slot> --}}

            <form wire:submit="edit" >
                <x-modal-footer>
                    <div class="ml-auto">
                        <x-loading.wrapper class="!justify-end inset-y-0 right-2">
                            <x-button type="submit" class="ml-auto">
                                Aprobar
                            </x-button>
                            <x-slot:show>
                                <x-loading class="!fill-marine-600 !w-4 !h-4"/>
                            </x-slot>
                        </x-loading>
                    </div>
                </x-modal-footer>

                {{-- <div>
                    @error('reactivo_id') <span class="text-red-600">{{ $message }}</span> @enderror
                </div> --}}

                <x-input.text                    
                    class="my-4"
                    x-mask:dynamic="$money($input, '.', '', 2)"
                    wire:model.stop="form.cantidad"
                    label="Cantidad Solicitada" 
                    error="form.cantidad" />

                @if (!$withReactive)
                
                    <x-utils.alert :type="$errors->has('reactivo_id') ? 'danger' : 'info'">
                        @error('reactivo_id')
                            {{ $message }}
                        @else
                        <span class="font-medium">Debes buscar</span> el reactivo que corresponda al de la solicitud <br>
                        Si no lo encuentras abajo puedes crealo
                        @enderror
                    </x-utils>
                    <x-button class="block !ml-auto mb-4">
                        Crear Reactivo
                    </x-button>

                    <x-input.search 
                    class="!p-0 mb-4"
                    placeholder="Busca reactivos"
                    wire:model.live.stop.debounce.350ms="drawerSearch">
                    <x-icon.circle class="cursor-pointer" wire:click="clear('drawer')"/>
                    </x-input>

                    @foreach ($reactivos as $reactivo)
                    <x-card.radio
                        name="reactivos"
                        wire:model="reactivo_id"
                        value="{{ $reactivo->id }}"
                        :title="$reactivo->nombre"   
                    >
                        {{ $reactivo->grupo .' - '. $reactivo->formula}}
                        <br>Disponible:
                        {{ $reactivo->total }}
                    </x-card>
                    @endforeach
                @else
                <div class="bg-slate-100 p-4 rounded-lg">
                    <x-utils.text-info
                       title="Cantidad disponible:">
                           {{ ($form->solicitud->reactivo?->total ?? '00').' '.($form->solicitud->reactivo?->unidad ?? '')}}
                     </x-utils>
                     
                   </div>
                @endif
            </form>
        </x-drawer>

    </div>

    {{-- TABS PARA LOS DOS TIPOS DE SOLICITUDES --}}
    <x-tabs class="!max-w-full bg-marine rounded-xl !ml-auto !mr-0 mb-4" withOutRoutes>
        <x-tab-button 
        wire:click="switchTab"
        text="Normales" :active="$withReactive"/>

        <x-tab-button 
        wire:click="switchTab"
        text="Especiales" :active="!$withReactive"/>
    </x-tabs>

    {{-- TABLA CON INDICADORES DE CARGA Y OTRAS UTILIDADES --}}

    <x-loading.wrapper>
        <x-slot:show>
            <x-loading class="!w-14 !h-14 !fill-marine-600"/>
        </x-slot>

            <x-table
            {{-- Arreglo temporal para los dropdown en las fials especiales --}}
            @class(['min-h-[280px]' => !$solicitudes->isEmpty()])
            :columns="[
                'Clave' => ['users.clave', $sortCol, $sortAsc],
                'Solicitante' => ['users.nombre', $sortCol, $sortAsc],
                                
                'Reactivo' => $withReactive 
                                ? ['reactivos.nombre', $sortCol, $sortAsc]
                                : ['otro_reactivo', $sortCol, $sortAsc],
                'Comentario',
                'Cantidad' => ['cantidad', $sortCol, $sortAsc],
                'Estado',
                'Solicitado' => ['created_at', $sortCol, $sortAsc],
                'Accion'
                ]">
                @foreach ($solicitudes as $solicitud)
                <tr 
                class="hover:bg-gray-50"
                wire:key="{{ $solicitud->id }}">
                    <td class="whitespace-nowrap p-3 text-sm">
                        <div class="flex gap-1">
                        {{ $solicitud->clave }}
                        </div>
                    </td>

                    <td class="whitespace-nowrap p-3 text-sm">
                        <div>{{ $solicitud->user->nombre}}</div>
                    </td>
        
                    <td class="whitespace-nowrap p-3 text-sm">
                        <div>{{ $solicitud->reactivo?->nombre ?? $solicitud->otro_reactivo}}</div>
                    </td>

                    <td class="whitespace-nowrap p-3 text-sm">
                        <div class="truncate md:max-w-40 lg:max-w-52" style="max-width: 200px;">
                            {{ $solicitud->comentario }}
                        </div>
                        
                    </td>
        
                    <td class="whitespace-nowrap p-3 text-sm">
                        {{ $solicitud->cantidad .' '.($solicitud->reactivo?->unidad ?? '')}}
                    </td>
        
                    <td class="whitespace-nowrap p-3 text-sm">
                        @if ($solicitud->estado)
                            <x-utils.badge
                            class="flex items-center">
                                Aprobada
                                <x-icon.check  class="ml-2 !w-4 !h-4"/>
                            </x-utils>
                        @else
                            <x-table.dropdown>
                                <x-slot:trigger>
                                    <button class="flex items-center">
                                        <x-utils.badge 
                                        class="flex"
                                        type="in-progress" >
                                            En Curso
                                            <x-icon.angle-down 
                                            x-bind:class="open ? '-rotate-180': 'rotate-0'"   
                                            class="ml-2 mt-[2px]"/>
                                        </x-utils>
                                    </button>
                                </x-slot>
                                <x-table.closable>
                                    <x-table.button 
                                    wire:click="setAction({{ $solicitud->id }}, 'edit')"
                                    text="Aprobar"/>
                                </x-table>
                            </x-table>
                        @endif
                        
                    
                    </td>
        
                    <td class="whitespace-nowrap p-3 text-sm">
                        {{ $solicitud->fechaLegible('created_at') }}
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
                                wire:click="setAction({{ $solicitud->id }}, 'show')"
                                text="Detalle"/>
                            </x-table>
                            <x-table.closable>
                                <x-table.button
                                wire:confirm.prompt="Estas Seguro?\n\nEscribe DELETE Para Confirmar|DELETE"
                                wire:click="delete({{ $solicitud->id }})" text="Eliminar"/>
                            </x-table>
                        </x-table>
                    </td>
                </tr>
                @endforeach
            </x-table>
            @if ($solicitudes->isEmpty())
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
            Resultados: {{ $solicitudes->total() }}
        </div>

        {{ $solicitudes->links('components.pagination') }}
    </div>
</div>

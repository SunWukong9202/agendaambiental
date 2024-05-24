<div>
    {{-- <pre>
        {{ $acopio->nombre  }}
    </pre> --}}

    <form 
        x-modelable="step"
        {{-- wire:model.live="step" --}}
        x-data="{ step: 1 }">
        <x-form.stepper>
            <x-form.step isActive="{{ $step == 1 }}" option="usuario" />
            <x-form.step isActive="{{ $step == 2 }}" option="donacion" isLastOne />
        </x-form>

        <div class="fixed top-16 right-3 z-30">
            <x-toast
            message="Donador registrado con éxito"
            wire:model="signUpSucces"
            x-effect="if($wire.signUpSucces) setTimeout(()=> $wire.signUpSucces = false, 5000)"
            />
        </div>

        <div  x-cloak x-show="step === 1">
            <x-utils.alert class="mt-4 block text-[18px]">
                <span class="font-medium">Selecciona</span> el tipo de usuario para poder
                continuar <br> 
                <span x-show="$wire.isExtern">
                    Puedes buscar por correo si el usuario ya fue registrado previamente
                </span>
            </x-utils>

            <x-utils.alert
            x-data="{show: false}"
            x-show="show"
            x-cloak
            x-modelable="show" 
            wire:model="form.not_found"
            x-effect="if($wire.form.not_found) setTimeout(()=> $wire.form.not_found = false, 5000)"
            class="mt-4 block text-[18px]" type="warning">
                <span class="font-medium">Sin coincidencias</span> <br>
                Asegurate de que la clave esta bien escrita 
            </x-utils>

            <x-tabs class="!max-w-full bg-marine rounded-xl !ml-auto !mr-0 mb-4" withOutRoutes>
                <x-tab-button 
                wire:click="switchTab"
                text="Usuario Externo" :active="$isExtern"/>

                <x-tab-button 
                wire:click="switchTab"
                text="Usuario Interno" :active="!$isExtern"/>
            </x-tabs>

            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-4 md:mt-5">
                <!-- Mostrar 'Clave' solo si no es externo -->
                @if (!$isExtern)
                    <x-input.text 
                    wire:model.stop.blur="form.clave"
                    label="Clave*" error="form.clave" />
                @endif
            
                <!-- 'Correo' y 'Telefono' al tope si es externo -->
                <x-input.text
                x-bind:class="isExtern ? 'order-1' : ''"
                wire:model.stop="form.correo"
                label="Correo*" error="form.correo" />
            
                <x-input.text 
                x-bind:class="isExtern ? 'order-2' : ''"
                wire:model.stop="form.telefono"
                label="Telefono*" error="form.telefono" />
            
                <!-- Otros campos mantienen su orden pero bajan si es externo -->
                <x-input.text 
                x-bind:class="isExtern ? 'order-3' : ''"
                wire:model.stop="form.nombre"
                label="Nombre*" error="form.nombre" />
            
                <x-input.text 
                x-bind:class="isExtern ? 'order-4' : ''"
                wire:model.stop="form.ap_pat"
                label="Apellido Paterno*" error="form.ap_pat" />
            
                <x-input.text 
                x-bind:class="isExtern ? 'order-5' : ''"
                wire:model.stop="form.ap_mat"
                label="Apellido Materno*" error="form.mat" />
            
                <x-input.select 
                x-bind:class="isExtern ? 'order-6' : ''"
                wire:model.stop="form.genero"
                label="Genero*" 
                error="form.genero">
                    <option value="" disabled>Selecciona el genero del usuario</option>
                    @foreach (['Femenino', 'Masculino', 'Otro'] as $gender)
                        <option value="{{ $gender }}">{{ $gender }}</option>
                    @endforeach
                </x-input.select>
            
                <!-- Mostrar 'Procedencia' solo si no es externo -->
                @if (!$isExtern)
                    <x-input.text 
                    wire:model.stop="form.procedencia"
                    label="Procedencia*" error="form.procedencia" />
                @endif
            </div>
            
        <div class="items-center" x-cloak x-show="step === 2">
            
            <x-tabs class="!max-w-full bg-marine rounded-xl !ml-auto !mr-0 mb-4" withOutRoutes>
                <x-tab-button 
                wire:click="switchTab"
                text="Usuario Externo" :active="$isExtern"/>

                <x-tab-button 
                wire:click="switchTab"
                text="Usuario Interno" :active="!$isExtern"/>
            </x-tabs>

        </div>

        <div class="bg-neutro-300 justify-around mt-4">
            <x-button 
            x-cloak x-show="step > 1" @click="step--">
                Anterior
            </x-button>

            <x-button
            x-cloak x-show="step < 2 && $wire.isExtern && !$wire.registrado" wire:click="registrar">
                Registrar
            </x-button> 

            <x-button x-cloak x-show="step < 2 && ($wire.registrado || !$wire.isExtern)" @click="step++">
                Siguiente
            </x-button>

            <x-button x-cloak x-show="step == 2">
                Enviar
            </x-button>
        </div>

    </form>
</div>

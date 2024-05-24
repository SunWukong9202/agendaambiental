<div>
    <x-utils.breadcrumb 
    :routes="[
        'Acopios' => 'admin.events',
        'Acopio',
    ]"
    />

    <h2 class="mb-4 text-2xl font-bold leading-none tracking-tight text-gray-500 md:text-4xl dark:text-white py-4">

        {{ 
            match($action) 
            {
                'create' => 'Crear Nuevo acopio',
                'edit' => 'Editar Acopio: ' .$form->nombre,
                'show' => 'Acopio: ' .$form->nombre,
            }           
        }}
    </h2>

    @if ($action == 'create' || $action == 'edit')
        <form 
        wire:submit="{{ $action }}"

        >
            <div class="flex gap-4 flex-wrap sm:flex-nowrap">
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
                <span class="font-medium">Esta opcion</span> te permite
                programar la fecha en que el acopio sera creado y publicado
                <br>
                El Acopio estara disponible todo el dia y se cerrara automaticamente.
            </x-utils>
            
            <div class="bg-white hidden" x-ref="datepicker_btn">
                <button 
                type="button" class="flex items-center justify-center px-4 py-2 w-full rounded-lg font-medium bg-white hover:bg-gray-100" >
                    <x-icon.check class="mr-2 text-green-400"/>
                    Aceptar
                </button>
            </div>
            <div x-data="{
                initialDate: '',
                show: false
            }" x-init="
                initialDate = $wire.action == 'edit'
                    ? flatpickr.formatDate(new Date($wire.form.ini_evento), 'Y-m-d H:i')
                    : '';
                show = !initialDate ? true : $store.utils.isGreaterDate(new Date(initialDate), new Date());
            ">
                <x-utils.alert 
                x-show="!show"
                class="mt-4" type="warning">
                    <span class="font-medium">El evento ya finalizo</span> <br>
                    Una vez que el evento ya se llevo a cabo no se permite modificar la fecha
                    de publicacion.
                </x-utils>

                <x-input.text 
                x-cloak 
                x-bind:disabled="!show"
                x-init="
                    if(!show) {
                        $refs.publish_date.value = flatpickr.formatDate(new Date(initialDate), 'F j, Y h:i K');
                        return;
                    }
                    let selected = false;
                    let minInitial = initialDate <= new Date() ? initialDate : 'today';
                    let min = $wire.action == 'edit' ? minInitial  : 'today';
            
                    console.log(initialDate);
                    const conf = {
                        altInput: true,
                        defaultDate: initialDate,
                        enableTime: true,
                        minDate: min,
                        altFormat: 'F j, Y h:i K',
                        dateFormat: 'Y-m-d H:i',
                        onReady: (dates, dateStr, instance) => {
                            if($wire.action == 'create') {
                                instance.setDate(new Date(), 'Y-m-d H:i');
                            }
                        },
                        onClose: function(selectedDates, dateStr, instance) {
                            if (!selected && !initialDate) {
                                instance.clear();
                            }
                            if(selectedDates.length > 0) {
                                let date = new Date(selectedDates[0]);
                                $wire.form.ini_evento = date.toISOString()
                            }
                        },
                        onChange: (selectedDates, dateStr, instance) => {
                            selected = true;
                            if(selectedDates.length > 0) {
                                let date = new Date(selectedDates[0]);
                                $wire.form.ini_evento = date.toISOString()
                            }
                            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                            if(!isMobile) {
                                const btn = document.querySelector('[x-ref=datepicker_btn]');
                                btn.classList.remove('hidden');
                                btn.addEventListener('click', () => instance.close())
                                instance.calendarContainer.appendChild(btn);
                            }
                        }
                    }
                    flatpickr($refs.publish_date, conf);
                "
                class="mb-4"
                wire:model.stop="form.ini_evento" 
                label="Fecha de publicacion" 
                x-ref="publish_date"
                error="form.ini_evento"
                />
            </div>
                    
            <x-modal-footer>
                <div class="ml-auto">
                    <x-loading.wrapper class="!justify-end inset-y-0 right-2">
                        <x-button type="submit" class="ml-auto !px-10 py-2 !mr-0 !mb-0">
                            {{ $action == 'edit' ? 'Guardar' : 'Agregar' }}
                        </x-button>
                        <x-slot:show>
                            <x-loading class="!fill-marine-600 !w-4 !h-4"/>
                        </x-slot>
                    </x-loading>
                </div>
            </x-modal-footer>
        </form>
    @elseif($action == 'show')
        <div>
            <x-utils.text-info 
            title="Nombre"
            content="{{ $form->nombre }}"
            />

            <x-utils.text-info 
            title="Sede"
            content="{{ $form->sede }}"
            />

            <x-utils.text-info 
            title="Descripcion"
            content="{{ !$form->descripcion ? 'No Provista' : $form->descripcion }}"
            />

            <x-utils.text-info 
            x-text="flatpickr.formatDate(new Date('{{ $form->ini_evento->toIso8601String() }}'), 'F j, Y h:i K')"
            title="Fecha de publicacion" />
        </div>
    @endif
</div>

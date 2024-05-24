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
            <x-button>
                Perfil           
            </x-button>
    
            <x-button>
                Mis Solicitudes           
            </x-button>
    
            <x-button>
                Mis Donaciones           
            </x-button>
        </div>
    </div>



    <div class="max-w-6xl mx-auto mt-4 md:mt-10">
        
        <h3 class="mb-4 text-lg font-bold leading-none tracking-tight text-gray-500 md:text-4xl dark:text-white py-4">
            Bienvenido {{ $form->nombre }}
        </h3>
    
        <div class="flex flex-wrap sm:flex-nowrap gap-4 h-60">

            @foreach ([
                'Electronicos' => 'solicitudes|articulos',
                'Reactivos' => 'solicitudes|reactivos',
            ] as $option => $route)
                <a 
                href="{{ route(explode('|', $route)[0], ['type' => explode('|', $route)[1]]) }}"
                class="shadow-lg rounded-lg p-4 hover:bg-gray-100 w-full flex items-center justify-center">
                    {{ $option }} 
                </a>
            @endforeach

        </div>
    </div>
</div>
<x-layouts.client>
    <x-slot:title>
        Modulo Gestion Ambiental - Inicio
    </x-slot>

    <div class="max-w-6xl mx-auto mt-4 md:mt-10">
        <div class="flex gap-4">
            <div>
                <img 
                class="w-80"
                src="{{ (\Faker\Factory::create('es_ES'))->imageUrl() }}" alt="">
            </div>
            <div class="text-gray-500 text-lg leading-snug ">
                <b>
                Bienvenido a la sección de solicitudes:
                </b> 
                <p>
                    Aquí podrás mandar tu solicitud y así
                    tener la posibilidad de adquirir uno o varios artículos.
                </p>
                <br>
                <b>Entre los que destacan:</b><br> 
                <p>
                    Electrónicos, material reciclable(plásticos, vidrio, papel, etc) y reactivos(químicos).
                    <br>
                    Verás el estado de tu solicitud en la sección "Mis solicitudes" dentro de tu perfil o espera a recibir un correo para saber si tu solicitud fue aceptada o no.
                </p>
            </div>
        </div>
        
        <h2 class="mb-4 text-2xl font-bold leading-none tracking-tight text-gray-500 md:text-4xl dark:text-white py-4">
            Haz tu Solicitud
        </h2>
    
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

        <h2 class="mb-4 text-2xl font-bold leading-none tracking-tight text-gray-500 md:text-4xl dark:text-white py-4">
            Haz tu Donacion
        </h2>
    
        <div class="flex flex-wrap sm:flex-nowrap gap-4 h-60">

                <a 
                href="{{ route('solicitudes', ['type' => 'donacion']) }}"
                class="shadow-lg rounded-lg p-4 hover:bg-gray-100 w-full flex items-center justify-center">
                    Donaciones
                </a>

        </div>
    </div>
</x-layouts>
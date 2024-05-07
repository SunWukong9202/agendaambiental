<x-layouts.client>
    <x-slot:title>
        Bienvenido - {{ auth()?->user()->nombre ?? '' }}
    </x-slot>
    <div>
        Aqui deberia el perfil del usuario {{ auth()?->user()->nombre ?? '' }}
        <br><br>
        <ul>
            <li>
                Puede incluir un historial de donaciones
            </li>
            <li>
                historial de solicitudes
            </li>
            <li>
                etc.
            </li>
        </ul>
    </div>
</x-layouts>
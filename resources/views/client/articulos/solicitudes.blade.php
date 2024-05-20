<x-layouts.client 
enableTALL="true"
>
    <div class="lg:max-w-7xl mx-auto">
        <h1 class="mb-4 font-medium text-3xl text-gray-500">
            <span class="font-semibold text-3xl text-gray-700">Solicitudes: </span>
            Puedes solicitar los siguientes articulos
        </h1>
        <form action="">
            <x-input.text-area
            label="Comentario"
            placeholder="Por favor agrega un comentario"
            class="mb-4"
            />
            <div class="grid grid-cols-4 gap-4">
                @foreach ($articulos as $articulo)
                    <x-card.radio
                        name="articulo_id"
                        value="{{ $articulo->id }}"
                        class="w-full"
                        title="{{ $articulo->nombre }}"
                    >
                        <span class="text-gray-400">Cantidad: </span> {{ $articulo->cantidad }}
                        <br>
                        {{ $articulo->created_at }}
                        <br>
                        {{ $articulo->updated_at }}
                    
                        <x-button type="submit" class="block mt-5">
                            Solicitar
                        </x-button>
                    </x-card>
                @endforeach
            </div>
        </form>
    </div>
</x-layouts>
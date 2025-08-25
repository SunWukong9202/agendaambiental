<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')

</head>
<body>

    @php
        $page = 1;
        $i = 0;
        $groupedDeliveries = $deliveries->groupBy(function ($delivery) {
            return $delivery->waste->unit;
        });
        $keys = $groupedDeliveries->keys();
        $currentKey = $keys->shift();
        $group = clone $groupedDeliveries[$currentKey];

    @endphp

    @while (true)
        <div class="flex flex-col h-screen mx-4 font-roboto text-slate-600 font-normal">
            @if ($page == 1)            
                <div class="flex items-center justify-between pl-4 my-8">
                    <h1 class="font-semibold text-2xl italic">
                        {{ __('Reporte de entregas') }}
                    </h1>
                
                    <div 
                        class="max-w-sm w-full rounded-bl-full bg-slate-900 pr-4"
                    >
                        <img 
                            src="{{ public_path('images/logoagenda.jpg') }}" 
                            class="w-48 ml-auto py-8"    
                        >
                    </div>
                </div>

                <div class="p-4 border border-gray-700 rounded-lg relative">
                    <h2 class="font-semibold text-lg absolute -top-4 left-1/2 -translate-x-1/2 text-center px-4 bg-white">Proveedor</h2>
                
                    <div class="flex gap-x-8 gap-y-4 mt-4">
                        <div class="flex-1 flex justify-between">
                            <div class="flex flex-col gap-4">
                                <div>
                                    {{ $to->name }} <br>
                                    {{ $to->business_name . " (" . $to->business_activity . ")"}}
                                </div>
                
                                <div>
                                    <h3 class="font-semibold text-base">RFC: </h3>
                                    {{ $to->tax_id }}
                                </div>
                            </div>
                
                            <div class="flex flex-col gap-4">
                                <div>
                                    <h3 class="font-semibold text-base">Correo: </h3>
                                    {{ $to->email }}
                                </div>
                                
                                <div>
                                    <h3 class="font-semibold text-base">Telefono: </h3>
                                    {{ $to->phone_number }}
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-base">Direccion: </h3>
                            Calle: {{ $to->street }}, Ext: #{{ $to->ext_number }}, Int: #{{ $to->int_number }} <br>
                            Colonia: {{ $to->neighborhood }} <br>
                            Municipio: {{ $to->town }}, Estado: {{ $to->state }} <br>
                            CP {{ $to->postal_code }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="relative overflow-x-auto mt-8">
                
                @if ($group->isNotEmpty())
                    <table class="w-full text-sm text-left rtl:text-right text-slate-900">
                        <thead class="text-x uppercase bg-slate-900 text-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-s-lg">
                                    Residuo
                                </th>
                                <th scope="col" class="px-6 py-3 border-0">
                                    Registrada por
                                </th>
                                <th scope="col" class="px-6 py-3 border-0">
                                    Emitada
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-r-lg">
                                    Cantidad
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @while ($i < min($page * 8, $deliveries->count()))
                                @php                                    
                                    $delivery = $group->shift();
                                @endphp
                                <tr class="bg-white dark:bg-gray-800">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $delivery->waste->category }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $delivery->user->user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $delivery->dateTime('created_at') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $delivery->quantity ." ". $delivery->waste->unit }}
                                    </td>
                                </tr>

                                @php
                                    $i = $i+1;
                                @endphp
                            @endwhile
                        </tbody>
                        @if ($group->isEmpty())
                            <tfoot class="border-t border-slate-900">
                                <tr class="font-semibold text-gray-900 dark:text-white">
                                    <th scope="row" class="px-6 py-3 text-base">Total</th>
                                    <td class="px-6 py-3">{{ $groupedDeliveries[$currentKey]->sum('quantity') ." ". $currentKey }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                @else
                    @php
                        if($keys->isNotEmpty() > 0) {
                            $currentKey = $keys->shift();
                            $group = clone $groupedDeliveries[$currentKey];
                            continue;
                        }
                    @endphp
                @endif
            </div>

            @if ($i == $deliveries->count())
                <div class="mt-auto mb-16 flex justify-center gap-16 items-end h-32">
                    <div class="flex-1 max-w-sm">
            
                        <p class="border-t border-black p-2 text-center">
                            {{ $to->name }}
                        </p>
                    </div>
            
                    <div class="flex-1 max-w-sm">
                        
                        @isset(auth()->user()->CMUser->signature_url)
                            <img src="{{ public_path("storage/" . auth()->user()->CMUser->signature_url) }}" class="w-20 mx-auto">
                        @endisset 
                            
                        <p class="border-t border-black p-2 text-center">
                            {{ $from->name }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        @php
            $page = $page+1;
        @endphp

        @if ($i < $deliveries->count())
            @pageBreak
        @else 
            @break
        @endif
    @endwhile

    
</body>
</html>

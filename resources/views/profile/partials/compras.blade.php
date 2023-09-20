
<div class="mx-auto w-5/6 p-5 rounded bg-gray-700 text-gray-400 mb-5">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table id="MisCompras" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Factura Nº
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Fecha de la factura
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facturas as $factura)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $factura->id }}
                        </th>
                        <td class="px-4 py-4">
                            {{ $factura->fecha_creacion }}
                        </td>
                        <td class="px-6 py-4">
                            ${{ $factura->total_precio }}
                        </td>
                        <td class="px-6 py-4">
                            @if (!$factura->bool_pagado)
                                <a href="{{ url('factura/'.$factura->id_mercadopago) }}" class="bg-red-500 text-white font-bold py-1 px-2 rounded hover:bg-red-600">{{ $factura->estado }}</a>
                            @else
                                <a href="{{ url('factura/'.$factura->id_mercadopago) }}" class="bg-green-500 text-white font-bold py-1 px-2 rounded hover:bg-green-600">{{ $factura->estado }}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mx-auto w-5/6 p-5 rounded bg-gray-700 text-gray-400 mb-5">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table id="MisCompras" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Factura Nº
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha de la factura
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha de vencimiento
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
                            {{ $factura->id_mercadopago }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $factura->date_created }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $factura->date_of_expiration }}
                        </td>
                        <td class="px-6 py-4">
                            ${{ $factura->total_precio }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ url('factura/'.$factura->id_mercadopago) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $factura->estadoTicket() }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
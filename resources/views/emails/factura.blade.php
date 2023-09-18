<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <title>Ecommerce</title>
</head>
<body>

  <div class="container mx-auto border my-10 w-2/3 p-10">
    <div class="flex flex-cols-2 justify-between">
      <p class="text-2xl font-bold">Ecommerce</p>
      <p class="text-xl font-bold">{{ $ticket->estadoTicket() }}</p>
    </div>
    <p class="font-xl font-bold">Factura nro: {{ $ticket->id }}</p>
    <hr class="my-5">
    <div class="flex flex-cols-2 justify-between">
      <div class="text-left">
        <p class="font-xl font-bold">Facturado a</p>
        <p>{{ $ticket->User->name }}</p>
        <p>{{ $ticket->direccion }}</p>
        <p>Salta, Salta, 4400</p>
        <p>Argentina</p>
        <p class="font-xl font-bold">Fecha de la factura</p>
        <p>{{ $ticket->date_created }}</p>
      </div>
      <div class="text-right">
        <p class="font-xl font-bold">Pagar a</p>
        <p>Ecommerce, Salta, Argentina</p>
        <br>
        <br>
        <br>
        <p class="font-xl font-bold">Método de pago</p>
        <p>{{ $ticket->MetodoDePago() }}</p>
      </div>
    </div>

    <div class="border mt-10 mx-auto px-1">
      <p class="text-3xl font-bold m-5">Productos/Servicios</p>
      <hr class="mb-1">
      <div class="grid grid-cols-2 justify-between">
        <p class="font-bold text-left">Descripción</p>
        <p class="font-bold text-right">Importe</p>
      </div>
      <hr class="mb-1">

      <!-- Codigo repetitivo !-->
      @forelse ($ticket->Compras() as $compra)
        <div class="flex flex-cols-2 justify-between">
          <div class="grid grid-cols-3 gap-5">
            <p>(x{{ $compra->cantidad }}) {{ $compra->Producto->titulo }}</p>
            <p>{{ $compra->Color->color }}</p>
            <p>{{ $compra->Talle->talle }}</p>
          </div>
          <p>${{ $compra->Producto->precio }}.00 ARS</p>
        </div>
        <hr class="mb-1">
      @empty
        <p>No hay compras lpm</p>
      @endforelse
      <!-- fin de codigo repetitivo !-->

      <hr class="mb-1">
      <div class="grid grid-cols-2 justify-between">
        <p class="font-bold text-right w-4/5">Sub Total</p>
        <p class=" text-right">${{ $ticket->total_precio }}.00 ARS</p>
      </div>
      <hr class="mb-1">
      <div class="grid grid-cols-2 justify-between">
        <p class="font-bold text-right w-4/5">Crédito</p>
        <p class=" text-right">$0.00 ARS</p>
      </div>
      <hr class="mb-1">
      <div class="grid grid-cols-2 justify-between mb-3">
        <p class="font-bold text-right w-4/5">Total</p>
        <p class=" text-right">${{ $ticket->total_precio }}.00 ARS</p>
      </div>
    </div>

    <div class="grid grid-cols-4 my-2 text-center">
      <p class="font-bold">Fecha Transacción</p>
      <p class="font-bold">Método/Gateway</p>
      <p class="font-bold">ID Transacción</p>
      <p class="font-bold">Total</p>
    </div>
    <hr class="mb-1">
    <div class="grid grid-cols-4 my-2 text-center">
      <p>Monday, June 6th, 2022</p>
      <p>Tarjeta de crédito/débito, Pago Facil y Rapipago</p>
      <p>{{ $ticket->id_mercadopago }}</p>
      <p>${{ $ticket->total_precio }}.00ARS</p>
    </div>
  </div>
</body>
</html>

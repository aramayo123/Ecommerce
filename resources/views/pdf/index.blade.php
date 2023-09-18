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

  <div class="">
    <p class="text-2xl font-bold inline-block">Ecommerce</p>
    <p class="text-xl font-bold inline-block" style="margin-left: 10%">{{ $ticket->estadoTicket() }}</p>

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
      <p class="font-bold text-left inline-block" style="margin-right: 70%">Descripción</p>
      <p class="font-bold text-right inline-block">Importe</p>

      <hr class="mb-1">
      <!-- Codigo repetitivo !-->
      @forelse ($ticket->Compras() as $compra)
        <p class="inline-block mx-2">(x{{ $compra->cantidad }}) {{ $compra->Producto->titulo }}</p>
        <p class="inline-block mx-2">{{ $compra->Color->color }}</p>
        <p class="inline-block mx-2">{{ $compra->Talle->talle }}</p>
        <p class="inline-block" style="margin-left: 35%;">${{ $compra->Producto->precio }}.00 ARS</p>
        <hr class="mb-1">
      @empty
        <p>No hay compras lpm</p>
      @endforelse
      

      <hr class="mb-1">
      <p class="font-bold text-right w-4/5 inline-block" style="margin-left: 40%">Sub Total</p>
      <p class="text-right inline-block" style="margin-left: 20%">${{ $ticket->total_precio }}.00 ARS</p>

      <hr class="mb-1">
      <p class="font-bold text-right w-4/5 inline-block" style="margin-left: 40%">Crédito</p>
      <p class=" text-right inline-block" style="margin-left: 20%">$0.00 ARS</p>

      <hr class="mb-1">
      <p class="font-bold text-right w-4/5 inline-block" style="margin-left: 40%">Total</p>
      <p class=" text-right inline-block" style="margin-left: 20%">${{ $ticket->total_precio }}.00 ARS</p>

    </div>

  </div>
</body>
</html>

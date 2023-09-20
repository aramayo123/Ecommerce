@include('layouts.header')
@php

    require base_path('vendor/autoload.php');
    MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));
    $preference = new MercadoPago\Preference();
    $item = new MercadoPago\Item();
    $item->title = 'Compra de productos';
    $item->quantity = 1;
    $item->unit_price = (int) $total_precios;
    $preference->back_urls = [
        'success' => route('terminar'),
        'failure' => route('terminar'),
        'pending' => route('terminar'),
    ];
    $preference->auto_return = 'approved';
    $preference->metadata = [
        'direccion' => $direccion,
        'telefono' => $telefono,
        'ciudad' => $ciudad,
        'provincia' => $provincia,
        'pais' => $pais,
        'codigo_postal' => $codigo_postal,
        'user_id' => Auth::user()->id,
        'email' => Auth::user()->email,
        'lista_productos' => $lista_productos,
        'id_productos' => $id_productos,
        'total_precios' => $total_precios,
    ];
    $preference->items = [$item];
    $preference->save();
@endphp


<div class="container mx-auto w-4/6 bg-gray-700 text-white rounded my-10 p-10">
    <p class="text-center">En esta instancia si deseas cancelar, o seguir con tu compra puedes hacerlo volviendo hacia atras</p>
    <div class="w-96 mx-auto" id="wallet_container">

    </div>
</div>

@include('layouts.footer')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
        locale: 'es-AR'
    });
    const bricksBuilder = mp.bricks();
    mp.bricks().create("wallet", "wallet_container", {
        initialization: {
            preferenceId: '{{ $preference->id }}',
            redirectMode: "self"
        },
    });
</script>
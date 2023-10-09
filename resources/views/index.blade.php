
@include('layouts.header')
@php
    use App\Models\Producto;
    $reversed_1 = Producto::all();
    $productos = $reversed_1->reverse();
    $productos->all();
@endphp
<div class="container mx-auto lg:mt-2 lg:mb-2">
    @if( $message = Session::get('exito'))
        <div class="w-4/5 mx-auto my-5 bg-green-500">
            <p class="p-2 m-2 text-center">{{ $message }}</p>
        </div>
    @endif

    <p class="text-center text-white font-bold text-2xl hover:text-gray-200"> No sabes que elegir? </p>
    <p class="text-center text-white font-bold text-sm hover:text-gray-300"  >y descubri nuestros productos</p>

    <!-- UI card from https://uxplanet.org/ultimate-guide-for-designing-ui-cards-59488a91b44f -->
    <div class="bg-gray-800 flex flex-col justify-center m-4">
        <div class="relative m-3 flex flex-wrap mx-auto justify-center">

            @forelse ($productos as $producto)
                <a href="{{ route('productos.show', $producto->id) }}" class="relative max-w-sm min-w-[340px] bg-white shadow-md rounded-3xl p-2 mx-1 my-3 cursor-pointer">
                    <div class="overflow-x-hidden rounded-2xl relative">
                        @if ($producto->foto_1 != null)
                            <img class="h-40 rounded-2xl w-full object-cover" src="{{ asset('img_products/' . $producto->foto_1) }}">
                        @else
                            <img class="h-40 rounded-2xl w-full object-cover" src="https://pixahive.com/wp-content/uploads/2020/10/Gym-shoes-153180-pixahive.jpg">
                        @endif
                        <p class="absolute right-2 top-2 bg-white rounded-full p-2 cursor-pointer group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:opacity-50 opacity-70" fill="none" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        </p>
                    </div>
                    <div class="mt-4 pl-2 mb-2 flex justify-between ">
                        <div>
                        <p class="text-lg font-semibold text-gray-900 mb-0">{{ $producto->titulo }}</p>
                        <p class="text-md text-gray-800 mt-0">$ {{ $producto->precio }}</p>
                        </div>
                        <div class="flex flex-col-reverse mb-1 mr-4 group cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:opacity-70" fill="none" viewBox="0 0 24 24" stroke="gray">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-center text-white font-bold text-2xl hover:text-gray-200"> No hay productos para mostrar </p>
            @endforelse
        </div>
    </div>
</div>

@include('layouts.footer')

<script>
    const message = '<?php if($msg){ echo $msg; }?>';
    console.log(message)
    if(message){
        let icon, title;
        if(message === 'created' || message === 'sucess'){
            icon = 'success';
            if(message === 'created'){
                title = 'La factura ha sido creado con exito. Revisa tus compras';
            }else{
                title = 'El pago ha sido realizado con exito!';
            }
        }else if(message === 'failure'){
            icon = 'error';
            title = 'El pago no ha podido completarse!';
        }else{ // pending
            icon = 'warning';
            title = 'El pago ha quedado pendiente!';
        }
        Swal.fire({
            position: 'cencer',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 1500
        })
    }
    
</script>
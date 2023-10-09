@php
    use App\Models\Producto;
    $productos = Producto::All();
    $array_json = json_encode($productos);
@endphp

    <footer class="bg-white lg:rounded-lg shadow dark:bg-gray-900 ">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="https://flowbite.com/" class="flex items-center mb-4 sm:mb-0">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Ecommerce</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6 ">Ayuda</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">Politica y privacidad</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6 ">Licencia</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contacto</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://flowbite.com/" class="hover:underline">Elkiller3d™</a>. Todos los derechos reservados.</span>
        </div>
    </footer>
</div>
<script>
    const menuButtom = document.querySelector('#mobile-menu');
    if(menuButtom)
        menuButtom.addEventListener('click', e => {
            const menu = document.querySelector('#mobile-links');
            menu.classList.toggle('hidden');
        })

    const stockProductos = <?php if (!empty($array_json)) {
        echo $array_json;
    } ?>;

    var carrito = []; // var global, let function, const constante

    function VaciarCarrito(){
        carrito.length = 0;
        mostrarCarrito()
    }

    document.addEventListener("DOMContentLoaded", () => {
        carrito = [];
        var data = JSON.parse(localStorage.getItem("carrito"))
        if (data) {
            var fecha = new Date().getHours();
            if (data.fecha - fecha > 0)
                carrito = data.data
            else {
                localStorage.removeItem("carrito");
                carrito = []
            }
        }
        mostrarCarrito();
    });
    const agregarProducto = (id, colores_arr) => {
        var cantidad_total = 0;
        colores_arr.forEach((element) => {
            element.talles.forEach((cant) => {
                cantidad_total += parseInt(cant.cantidad);
            })
        })
        let existe = carrito.some(prod => prod.id === id)
        if (existe) {
            carrito.forEach((producto) => {
                if (producto.id === id){
                    producto.cantidad = cantidad_total;
                    producto.colores_arr = colores_arr;
                }
            })
        } else {
            let item = stockProductos.find((product) => product.id === id)
            let copia_item = JSON.parse(JSON.stringify(item)) // hacemos una copia
            copia_item.cantidad = cantidad_total
            copia_item.colores_arr = colores_arr;
            carrito.push(copia_item)
        }
        mostrarCarrito();
    };
    const numerito_carrito = document.querySelector('#cantidad_carrito');
    function mostrarCarrito(){
        const cuerpo = document.querySelector('#cuerpo-carrito');
        if(!carrito.length){
            cuerpo.innerHTML = `
            <p class="text-left text-white font-2xl">MI COMPRA</p>
            <div class="mx-auto">
                <p class="font-bold text-white text-2xl m-5 p-5"> Tu carrito esta vacio </p>
                <a href="{{ url('/') }}" class="font-bold mx-auto py-2 px-4 bg-black text-white rounded-full hover:bg-white hover:text-black mb-10">Seguir comprando</a>
            </div>
            `;
            guardarStorage();
            return;
        }

        cuerpo.innerHTML = `
              <p class="text-left text-white font-2xl">MI COMPRA</p>
              <hr class="w-full my-2 mx-auto">
              <div id="elementos-carrito" class="px-2"></div>
              <hr class="my-2 mx-auto px-2">
              <div id="subTotal"></div>
              <div class="flex flex-cols-2 justify-between px-2">
                <p>Descuentos</p>
                <p>Gratis</p>
              </div>
              <hr class="my-2 mx-auto">
              <div id="precioTotal"></div>
              <a href="{{ route('procesar') }}" class="font-bold mx-auto py-2 px-4 bg-black text-white rounded-full hover:bg-white hover:text-black">Iniciar compra</a>
              <button>Seguir comprando</button>
            `;
            
        const content_cart = document.querySelector('#elementos-carrito');
        if (content_cart) {
            content_cart.innerHTML = "";
            var sumador = 1;
            carrito.forEach((prod) => {
                var element_generic = '';
                prod.colores_arr.forEach((element) => {
                    var nombre_color = element.nombre_color;
                    element.talles.forEach((talle) => {
                        element_generic += `<p class="inline-block">${talle.cantidad} <strong style="background-color: ${nombre_color};" class="rounded-full h-4 w-4 mx-auto inline-block"></strong> ${talle.nombre_talle} | </p>`;
                    })
                });
                content_cart.innerHTML +=
                    `
                    <div class="flex flex-cols-3 gap-5 h-24">
                        <img src="{{ asset('img_products/') }}/${prod.foto_1}" width="37" height="25" class="pl-2 object-contain object-center w-1/6 h-6/6">
                        <div class="text-left w-5/6 px-3">
                            <a href="{{ url('productos/${prod.id}') }}"><p>${prod.titulo}</p></a>
                            <div>
                                ${element_generic}
                            </div>
                        </div>
                        <div class="text-right w-2/6 mx-3 my-3">
                            <button class="py-3" onclick="eliminarProducto(${prod.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                            </svg>
                            </button>
                            <p class="font-bold">$ ${prod.precio} </p>
                            <p class="font-bold">Envio: $ ${prod.precio_envio}</p>
                        </div>
                    </div>
                `;
                if(sumador < carrito.length)
                    content_cart.innerHTML += `<hr class="my-2 mx-auto w-5/6">`;
                
                sumador++;
            })
        }
        const precioTotal = document.querySelector('#precioTotal');
        const total = carrito.reduce((acc, prod) => acc + prod.cantidad * prod.precio,0);
        if (precioTotal) {
            precioTotal.innerHTML = `
                <div class="flex flex-cols-2 justify-between px-2 mb-5">
                    <p>Total</p>
                    <p>$ ${total}</p>
                </div>
            `;
        }
        const subtotal = document.querySelector('#subTotal');
        if (subtotal) {
            subtotal.innerHTML = `
                <div class="flex flex-cols-2 justify-between px-2">
                  <p>Subtotal</p>
                  <p>$ ${total}</p>
                </div>
            `;
        }
        numerito_carrito.innerHTML = carrito.length;
        guardarStorage();
        //console.log(carrito)
    }
    function eliminarProducto(id) {
        carrito = carrito.filter((juego) => juego.id !== id);
        mostrarCarrito();
    }

    function guardarStorage() {
        const data = {
            data: carrito,
            fecha: new Date().getHours() + 1
        }
        localStorage.setItem("carrito", JSON.stringify(data));
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

</body>
</html>


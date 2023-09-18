@include('layouts.header');

<div class="mx-auto container bg-gray-800 mb-10 mt-10 flex flex-cols-2 justify-between">   
    <div class="w-5/12 mx-auto p-5 text-white">
        <p class="mx-auto rounded m-5 p-5 bg-gray-700 text-white">Para completar el pago necesitamos los siguientes datos</p>
        <form action="{{ route('payment') }}" method="post" class="mx-auto rounded m-5 p-5 bg-gray-700 text-gray-400">
            @csrf
            <div class="mb-6">
                <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Direccion: </label>
                <x-text-input type="text" id="direccion" name="direccion" :value="old('direccion')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ejemplo: Don emilio manzana j piso 3 casa 2"/>
                @error('direccion')
                    <p class="p-2 text-left text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefono: </label>
                <x-text-input type="number" id="telefono" name="telefono" :value="old('telefono')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ejemplo: +5493875123456"/>
                @error('telefono')
                    <p class="p-2 text-left text-red-500">{{ $message }}</p>
                @enderror
            </div>
           <div id="inputs-restantes">

           </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
               Confirmar
            </button>
        </form>
    </div>
    <div class="w-7/12 p-5">
        <div class="mx-auto rounded m-5 p-5 bg-gray-700 text-gray-400">
            <div class="grid grid-cols-4 text-center">
                <p class="font-bold">Producto</p>
                <p class="font-bold">Color</p>
                <p class="font-bold">Talle</p>
                <p class="font-bold">Precio</p>
            </div>
            <hr class="my-2">
           
            <!-- Empieza el codigo repetitivo !-->
            <div id="carrito-extra">

            </div>
            <!-- Termina el codigo repetitivo !-->

            <div class="flex flex-cols-4 text-center">
                <p class="font-bold text-right w-4/5 px-10">Total</p>
                <p class="">$900.00 ARS</p>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer');
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const seccion = document.querySelector('#carrito-extra');
        const inputs = document.querySelector('#inputs-restantes');
        seccion.innerHTML = ``;
        inputs.innerHTML = ``;
        carrito.forEach((prod, i) => {
            inputs.innerHTML += `
                <input type="text" class="hidden" name="id_productos[]" value="${prod.id}">
            `;
            prod.colores_arr.forEach((color, j) => {
                var nombre_color = color.nombre_color;
                inputs.innerHTML += `
                    <input type="text" class="hidden" name="productos[${i}][${j}][]" value="${color.id_color}">
                `;
                color.talles.forEach((talle) => {
                    seccion.innerHTML += `
                        <div class="grid grid-cols-4 text-center">
                            <p>(x${talle.cantidad}) ${prod.titulo}</p>
                            <p>${nombre_color}</p>
                            <p>${talle.nombre_talle}</p>
                            <p>$ ${prod.precio}</p>
                        </div>
                        <hr class="my-2">
                    `;
                    inputs.innerHTML += `
                        <input type="text" class="hidden" name="productos[${i}][${j}][]" value="${talle.id_talle} ${talle.cantidad}">
                    `;
                })
            });
        });
        const total = carrito.reduce((acc, prod) => acc + prod.cantidad * prod.precio,0);
        inputs.innerHTML += `
            <input type="text" class="hidden" name="total_precios" value="${total}">
        `;
        //console.log(inputs)
    });

    
</script>
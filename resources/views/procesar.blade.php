@include('layouts.header');

<div class="mx-auto container bg-gray-800 mb-10 mt-10 flex flex-cols-2 justify-between">   
    <div class="w-5/12 mx-auto p-5 text-white">
        <p class="mx-auto rounded m-5 p-5 bg-gray-700 text-white">Para completar el pago necesitamos los siguientes datos</p>
        
        @if ($errors->any())
            <div class="mx-auto rounded m-5 p-5 bg-gray-700 text-white">
                @foreach ( $errors->all() as $error)
                    <p class="text-red-500">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form action="{{ route('payment') }}" method="post" class="mx-auto rounded m-5 p-5 bg-gray-700 text-gray-400">
            @csrf
            <div class="mb-6">
                <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Direccion: <p class="inline-block text-red-500">*</p></label>
                <x-text-input type="text" id="direccion" name="direccion" :value="old('direccion')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Direccion"/>
            </div>
            <div class="mb-6">
                <label for="contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contacto: <p class="inline-block text-red-500">*</p></label>
                <div>
                    <select name="caracteristica" id="caracteristica" class="inline-block text-black rounded font-bold">
                        <option value="+54" class="font-bold">+54</option>
                        <option value="+55" class="font-bold">+55</option>
                    </select>
                    <x-text-input type="text" class="inline-block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-4/5 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="contacto" name="contacto" :value="old('contacto')" placeholder="Contacto"/>
                </div>
            </div>

            <div class="mb-6 flex flex-cols-3 gap-1">
                <div>
                    <label for="ciudad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad: <p class="inline-block text-red-500">*</p></label>
                    <x-text-input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="ciudad" name="ciudad" :value="old('ciudad')" placeholder="Ciudad"/>
                </div>
                <div>
                    <label for="provincia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Provincia: <p class="inline-block text-red-500">*</p></label>
                    <x-text-input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="provincia" name="provincia" :value="old('provincia')" placeholder="Provincia"/>
                </div>
                <div>
                    <label for="codigo_postal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo Postal: <p class="inline-block text-red-500">*</p></label>
                    <x-text-input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="codigo_postal" name="codigo_postal" :value="old('codigo_postal')" placeholder="Codigo Postal"/>
                </div>
            </div>
            <div class="mb-6">
                <label for="pais" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pais: <p class="inline-block text-red-500">*</p></label>
                <select id="pais" name="pais"  class="font-bold bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" class="font-bold">Selecciona un pais</option>
                    <option value="Argentina" <?php if(old('pais') == 'Argentina') echo 'selected'; ?> class="font-bold">Argentina</option>
                    <option value="Chile" <?php if(old('pais') == 'Chile') echo 'selected'; ?> class="font-bold">Chile</option>
                    <option value="Brazil" <?php if(old('pais') == 'Brazil') echo 'selected'; ?> class="font-bold">Brazil</option>
                    <option value="Mexico" <?php if(old('pais') == 'Mexico') echo 'selected'; ?> class="font-bold">Mexico</option>
                </select>
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
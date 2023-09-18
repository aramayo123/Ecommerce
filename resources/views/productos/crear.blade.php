@include('layouts.header')


<div class="container mx-auto lg:mt-2 lg:mb-2">

    @if( $message = Session::get('exito'))
        <div class="w-4/5 mx-auto my-5 bg-green-500">
            <p class="p-2 m-2 text-center">{{ $message }}</p>
        </div>
    @endif

    @if( $message = Session::get('error'))
        <div class="w-4/5 mx-auto my-5 bg-red-500">
            <p class="p-2 m-2 text-center">{{ $message }}</p>
        </div>
    @endif

    
    <form method="post" action="{{ route('productos.store') }}" enctype="multipart/form-data" class="mx-auto w-1/2 rounded m-5 p-5 bg-gray-700 text-gray-400">
        @csrf

        <div class="mb-6">
            <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titulo del producto</label>
            <x-text-input type="text" id="titulo" name="titulo" :value="old('titulo')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: Jean blanco"/>
            @error('titulo')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Elige una categoria</label>
            <select name="categoria" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto_1">Elige una foto</label>
            <input name="foto_1" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="foto_1" type="file">
            @error('foto_1')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto_2">Elige una foto</label>
            <input name="foto_2" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="foto_2" type="file">
            @error('foto_2')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto_3">Elige una foto</label>
            <input name="foto_3" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="foto_3" type="file">
            @error('foto_3')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="caracteristicas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Caracteristicas del producto</label>
            <x-text-input type="text" id="caracteristicas" name="caracteristicas" :value="old('caracteristicas')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: El producto posee un pantalon extra"/>
            @error('caracteristicas')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio del producto</label>
            <x-text-input type="number" id="precio" name="precio" :value="old('precio')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0.0"/>
            @error('precio')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="precio_envio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio de envio del producto</label>
            <x-text-input type="number" id="precio_envio" name="precio_envio" :value="old('precio_envio')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0.0"/>
            @error('precio_envio')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <p class="text-gray-300 my-2 font-medium">Estado del producto: </p>
            <fieldset>
                <legend class="sr-only">Countries</legend>
                <div class="flex items-center mb-4">
                  <input id="country-option-1" type="radio" name="active" value="1" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" checked>
                  <label for="country-option-1" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Activado
                  </label>
                </div>
                <div class="flex items-center mb-4">
                  <input id="country-option-2" type="radio" name="active" value="0" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                  <label for="country-option-2" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Desactivado
                  </label>
                </div>
              </fieldset>
            @error('active')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <button id="BotonAddColor" class="my-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar Color</button>
            <div class="mx-auto grid grid-cols-1 gap-4 border-2 border-sky-500 p-2 rounded">
                <div id="div_color_0">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="colores[0][]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Color del producto en HEXADECIMAL</label>
                            <input type="text" id="colores[0][]" name="colores[0][]" value="#" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: #FFFF">
                        </div>
                        <div class="pt-8">
                            <button class="block talles bg-black text-white rounded py-1 px-1 w-10 my-2" id="boton_talle_0">+</button>
                            <input type="text" id="input_talle_0_0" name="colores[0][]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: Talle S">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crear producto</button>
    </form>
  
</div>

@include('layouts.footer')
<script>
    const AgregarColor = document.querySelector('#BotonAddColor');
    var CantidadColores = 0;
    var CantidadTalles = [0];
    const BotonesTalles = [];
    ActivarBoton(document.getElementById('boton_talle_0'));
    AgregarColor.addEventListener("click", function(event){
        event.preventDefault();
        Nodo = document.getElementById("div_color_"+CantidadColores);
        CantidadColores ++;
        CantidadTalles.push(0);
        var newDiv = document.createElement("div");
        newDiv.id = 'div_color_'+CantidadColores;
        newDiv.innerHTML = `
            <div class=" grid grid-cols-2 gap-4">
                <div>
                    <label for="colores[${CantidadColores}][]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Color del producto en HEXADECIMAL</label>
                    <input type="text" id="colores[${CantidadColores}][]" name="colores[${CantidadColores}][]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: #FFFF" value="#">
                </div>
                <div class="pt-8">
                    <button class="block talles bg-black text-white rounded py-1 px-1 w-10 my-2" id="boton_talle_${CantidadColores}">+</button>
                    <input type="text" id="input_talle_${CantidadColores}_${CantidadTalles[CantidadColores]}" name="colores[${CantidadColores}][]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: Talle S">
                </div>
            </div>
            <div class="mt-5 bg-sky-500 rounded h-1 w-full"></div>
        `;
        var parentDiv = Nodo.parentNode;
        parentDiv.insertBefore(newDiv, Nodo);
        ActivarBoton(document.getElementById('boton_talle_'+CantidadColores));
    });
   
    function ActivarBoton(element) {
        element.addEventListener("click", function(event){
            event.preventDefault();
            var aux = element.id.split('_');
            var id = aux[2];
            Nodo = document.getElementById("input_talle_"+id+'_'+CantidadTalles[id]);
            const NuevoTalle = document.createElement("input");
            NuevoTalle.type = "text";
            NuevoTalle.name = "colores["+id+"][]";
            NuevoTalle.className  = "talle__ my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500";
            CantidadTalles[id] += 1;
            NuevoTalle.placeholder = "Ej: Talle S";
            NuevoTalle.id  = "input_talle_"+id+'_'+CantidadTalles[id];
            var parentDiv2 = Nodo.parentNode;
            parentDiv2.insertBefore(NuevoTalle, Nodo);
        });
    }
</script>

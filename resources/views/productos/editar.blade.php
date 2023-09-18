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

    
    <form method="post" action="{{ route('productos.update', $producto) }}" enctype="multipart/form-data" class="mx-auto w-1/2 rounded m-5 p-5 bg-gray-700 text-gray-400">
        @csrf
        @method('patch')

        <div class="mb-6">
            <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titulo del producto</label>
            <x-text-input type="text" id="titulo" name="titulo" value="{{ $producto->titulo }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: Jean blanco"/>
            @error('titulo')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Elige una categoria</label>
            <select name="categoria" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ $categoria->id == $producto->id_categoria ? 'selected':'' }}>{{ $categoria->nombre }}</option>
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
            <x-text-input type="text" id="caracteristicas" name="caracteristicas" value="{{ $producto->caracteristicas }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: El producto posee un pantalon extra"/>
            @error('caracteristicas')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio del producto</label>
            <x-text-input type="number" id="precio" name="precio" value="{{ $producto->precio }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0.0"/>
            @error('precio')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="precio_envio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio de envio del producto</label>
            <x-text-input type="number" id="precio_envio" name="precio_envio" value="{{ $producto->precio_envio }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0.0"/>
            @error('precio_envio')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <p class="text-gray-300 my-2 font-medium">Estado del producto: </p>
            <fieldset>
                <legend class="sr-only">Countries</legend>
                <div class="flex items-center mb-4">
                  <input id="country-option-1" type="radio" name="active" value="1" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" {{ $producto->active == '1' ? 'checked':'' }} >
                  <label for="country-option-1" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Activado
                  </label>
                </div>
                <div class="flex items-center mb-4">
                  <input id="country-option-2" type="radio" name="active" value="0" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"  {{ $producto->active == '0' ? 'checked':'' }} >
                  <label for="country-option-2" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Desactivado
                  </label>
                </div>
              </fieldset>
            @error('active')
                <p class="p-2 text-left text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
    </form>
  
</div>

@include('layouts.footer')

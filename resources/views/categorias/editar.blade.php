@include('layouts.header')


<div class="container mx-auto lg:mt-2 lg:mb-2">

    @if( $message = Session::get('exito'))
        <div class="w-4/5 mx-auto my-5 bg-green-500">
            <p class="p-2 m-2 text-center">{{ $message }}</p>
        </div>
    @endif
    
    <form action="{{ route('categorias.update', $categoria) }}" method="post" class="mx-auto w-1/2 rounded m-5 p-5 bg-gray-700 text-gray-400">
        @csrf
        @method('patch')
        <div class="mb-6">
            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de la categoria</label>
            <input type="text" id="nombre" name="nombre" value="{{ $categoria->nombre }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej: Ropa" required >
        </div>
        @error('nombre')
            <div class="mb-6 bg-red-400 rounded border-1 border-black text-white">
                <p class="p-2 text-center">{{ $message }}</p>
            </div>
        @enderror
        
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
    </form>
  
</div>

@include('layouts.footer')
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

    @if(count($categorias))
        <div class="w-4/5 mx-auto my-5 bg-gray-700 text-gray-400 rounded">
            <div class="flex flex-cols-2 justify-between">
                <a class="p-2 m-2 bg-blue-500 rounded text-white" href="{{ route('productos.create') }}">Crear producto</a>
                <a class="p-2 m-2 bg-blue-500 rounded text-white" href="{{ route('categorias.create') }}">Crear Categoria</a>
            </div>
        </div>

        <div class="w-4/5 mx-auto my-5">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table id="myTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Producto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Categoria
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Foto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex flex-cols-2 justify-between">
                                    <p>Colores</p>
                                    <p>Talles</p>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Precio
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $producto->titulo }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $producto->Categoria->nombre }}
                                </td>
                                <td class="px-2 py-4">
                                    <img class="mx-auto rounded" src="{{ asset('img_products/' . $producto->foto_1) }}" width="50">
                                </td>
                                <td class="px-3 py-4">
                                    @forelse ($producto->MostrarColores() as $color)
                                        <div class="flex flex-cols-2 justify-between">
                                            <div style="background-color: {{ $color->color }};" class="rounded-full h-4 w-4 mx-auto px-2"></div>
                                            <div class="grid grid-cols-1">
                                                @forelse ($producto->MostrarTalles($color->id) as $talle)
                                                    <strong >{{ $talle->talle }}</strong>
                                                @empty
                                                    <p>No hay talles asociados a este color</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    @empty
                                        <p>No hay colores</p>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4">
                                    ${{ $producto->precio }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($producto->active)
                                        Activado
                                    @else
                                        Desactivado
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('productos.destroy', $producto) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" value="Borrar" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    </form>
                                    <a href="{{ route('productos.edit', $producto) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <h1>No hay productos</h1>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="w-4/5 mx-auto my-5 bg-gray-700 text-gray-400 rounded">
            <div class="flex flex-cols-2 justify-between">
                <p class="p-2 m-2 ">Necesitas crear una categoria</p>
                <a class="p-2 m-2 bg-blue-500 rounded text-white" href="{{ route('categorias.create') }}">Crear categoria</a>
            </div>
        </div>
    @endif
</div>
@include('layouts.footer')
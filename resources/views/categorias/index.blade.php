@include('layouts.header')

<div class="container mx-auto lg:mt-2 lg:mb-2">

    @if( $message = Session::get('exito'))
        <div class="w-4/5 mx-auto my-5 bg-green-500">
            <p class="p-2 m-2 text-center">{{ $message }}</p>
        </div>
    @endif
     

    <div class="w-4/5 mx-auto my-5 bg-gray-700 text-gray-400 rounded">
        <div class="flex flex-cols-2 justify-between">
            <a class="p-2 m-2 bg-blue-500 rounded text-white" href="{{ route('categorias.create') }}">Crear Categoria</a>
            <a class="p-2 m-2 bg-blue-500 rounded text-white" href="{{ route('productos.create') }}">Crear producto</a>
        </div>
    </div>

    @if (count($categorias))
        <div class="w-4/5 mx-auto my-5">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table id="myTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha de creacion
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    #{{ $categoria->id }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $categoria->nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $categoria->created_at }}
                                </td>
                                <td class="px-6 py-4 text-left">
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                        Eliminar
                                        </button>
                                        <div id="popup-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full max-w-md max-h-full">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                        </svg>
                                                        <span class="sr-only">Cerrar modal</span>
                                                    </button>
                                                    <div class="p-6 text-center">
                                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                        </svg>
                                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estás seguro de que deseas eliminar esta categoria?</h3>
                                                        <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                            Eliminar
                                                        </button>
                                                        <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="w-4/5 mx-auto my-5 bg-gray-700 text-gray-400 rounded">
            <div class="flex flex-cols-2 justify-between">
                <p class="p-2 m-2 ">No existen categorias creadas</p>
                <a class="p-2 m-2 bg-blue-500 rounded text-white" href="{{ route('categorias.create') }}">Crear categoria</a>
            </div>
        </div>
    @endif
</div>

@include('layouts.footer')
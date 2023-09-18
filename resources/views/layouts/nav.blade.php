
<nav class="rounded flex items-center justify-between flex-wrap bg-gray-700 p-5 ">
  <div class="flex items-center flex-shrink-0 text-white mr-6">
    <svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
    <span class="font-semibold text-xl tracking-tight">Ecommerce</span>
  </div>
  <div class="block lg:hidden">
    <button id="mobile-menu" class="flex items-center px-3 py-2 border rounded text-white border-teal-400 hover:text-white hover:border-white">
      <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
    </button>
  </div>
  <div class="w-full hidden lg:block flex-grow lg:flex lg:items-center lg:w-auto" id="mobile-links">
    <div class="text-sm lg:flex-grow">
      <a href="#" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-10">
      </a>
      <a href="#" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-10">
      </a>
      <a href="#" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-10">
      </a>
      <a href="#" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-10">
      </a>
      <a href="#" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-10">
      </a>
      <a href="#" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-10">
      </a>

      <a href="{{ url('/') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-4">
        Shop
      </a>
      <a href="#" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-4">
        Contacto
      </a>
      @auth
        <a href="{{ url('/profile') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-4">
          Perfil
        </a>
        <form method="POST" action="{{ route('logout') }}" class="inline-block">
          @csrf
          <button class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-4" type="submit">Cerrar sesion</button>
        </form>
      @else
        <a href="{{ url('/login')}}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-4">
          Logear
        </a> 
        <a href="{{ url('/register')}}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-white mx-4">
          Registrarse
        </a> 
      @endauth
    </div>
    <div>
      <button type="button" data-modal-target="carrito" data-modal-toggle="carrito" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
          </svg>
          <p class="font-bold text-xs" id="cantidad_carrito"></p>
        </div>
      </button>
    </div>
  </div>
</nav>
<div id="carrito" data-modal-placement="top-right" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative w-5/6">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="carrito">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Cerrar modal</span>
          </button>
          <div id="cuerpo-carrito" class="p-6 text-center px-5 mx-5 text-white">
            
          </div>
      </div>
  </div>
</div>
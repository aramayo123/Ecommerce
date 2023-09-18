@include('layouts.header')
<style>
    .errorMensaje{
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
</style>
<div class="container mx-auto lg:mt-2 lg:mb-2">

    @if( $message = Session::get('exito'))
        <div class="w-4/5 mx-auto my-5 bg-green-500">
            <p class="p-2 m-2 text-center">{{ $message }}</p>
        </div>
    @endif

    <form class="mx-auto w-5/12 rounded m-5 p-5 bg-gray-700 text-gray-400" method="POST" action="{{ route('register') }}" >
        @csrf
        <!-- Name -->
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
        <x-text-input id="name" class="my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="errorMensaje" />

        <!-- Email Address -->
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo electrónico</label> 
        <x-text-input id="email" class="my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="errorMensaje" />
            
        <!-- Password -->
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
        <x-text-input id="password" class="my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="errorMensaje" />

        <!-- Confirm Password -->
        <label for="passwordConfirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmar contraseña</label>
        <x-text-input id="password_confirmation" class="my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="errorMensaje" />

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="enviarPerfil boton">
                {{ __('Register') }}
            </x-primary-button>
        </div>    
    </form>
</div>

@include('layouts.footer')
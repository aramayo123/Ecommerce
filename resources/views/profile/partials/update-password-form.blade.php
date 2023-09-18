<form method="post" action="{{ route('password.update') }}" class="mx-auto w-5/6 p-5 rounded bg-gray-700 text-gray-400 mb-5">
    @csrf
    @method('put')

    <!-- CURRENT PASSWORD !--> 
    <div class="mb-6">
        <label for="current_password" class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña actual</label>
        <x-text-input name="current_password" id="current_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="password" autocomplete="current-password" />
        @foreach ( $errors->updatePassword->get('current_password') as $error)
            <p class="p-2 text-left text-red-500">{{ $error }}</p>
        @endforeach
    </div>

    <!-- NEW PASSWORD !-->
    <div class="mb-6">
        <label for="password" class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña nueva</label>
        <x-text-input name="password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" autocomplete="new-password" />
        @foreach ( $errors->updatePassword->get('password') as $error)
            <p class="p-2 text-left text-red-500">{{ $error }}</p>
        @endforeach
    </div>
    

    <!-- CONFIRM PASSWORD !-->
    <div class="mb-6">
        <label for="password_confirmation" class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmar contraseña</label>
        <x-text-input name="password_confirmation" type="password" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" autocomplete="new-password" />
        @foreach ( $errors->updatePassword->get('password_confirmation') as $error)
            <p class="p-2 text-left text-red-500">{{ $error }}</p>
        @endforeach
    </div>

    <x-primary-button class="btn btn-success">GUARDAR</x-primary-button>
    @if (session('status') === 'password-updated')
        <div class="alert alert-success" role="alert" style="max-width: 70%; " id="alertsuccess">
            Se han actualizado sus datos correctamente.
        </div>
    @endif
</form>



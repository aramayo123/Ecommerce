<form method="post" action="{{ route('profile.update') }}" class="mx-auto w-5/6 p-5 rounded bg-gray-700 text-gray-400 mb-5">
    @csrf
    @method('patch')

    <!-- NOMBRE Y APELLIDO !-->
    <div class="mb-6">
        <label for="name" class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre completo</label>
        <x-text-input type="text" id="name" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
        @error('name')
            <p class="p-2 text-left text-red-500">{{ $message }}</p>
        @enderror
    </div>

     <!-- EMAIL !-->
    <div class="mb-6">
        <label for="email" class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }}</label>
        <x-text-input type="email" id="email" name="email" :value="old('email', $user->email)" required autofocus autocomplete="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
        @error('email')
            <p class="p-2 text-left text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- EMAIL VERIFICATION !-->
    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <!-- BUTTON EMAIL VERIFICATION !-->
        <p class="text-white">{{ __('Your email address is unverified.') }}
            <button form="send-verification" class="text-white bg-red-700 rounded font-bold px-2 py-1 my-2">Verificar email</button>
        </p>
        <!-- MESSAGE EMAIL VERIFICATION SEND !-->
        @if (session('status') === 'verification-link-sent')
            <p class="text-white">
                {{ __('A new verification link has been sent to your email address.') }}
            </p>
        @endif
    @endif

    <button type="submit" class="text-white bg-green-700 font-bold px-2 py-1 my-2 rounded">Guardar</button>

    <!-- MESSAGE DATA SAVED !-->
    <?php if(session('status') === 'profile-updated'){ ?>
        <div class="text-green-600 font-bold" role="alert">
            Se han actualizado sus datos correctamente.
        </div>
    <?php } ?>

</form>
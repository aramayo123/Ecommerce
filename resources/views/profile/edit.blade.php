@include('layouts.header')


<div class="container mx-auto lg:mt-2 lg:mb-2">
  <div class="w-full mx-auto my-10 flex flex-cols-2 ">
    <div class="bg-gray-700 inline-block w-1/5 my-5 text-center h-1/2 py-5">
      @if(Auth::user()->avatar)
        <img src="{{ asset('img_profile/'.Auth::user()->avatar) }}" class="mx-auto rounded-full" width="150">
      @else
        <img src="{{ asset('img_profile/default.jpg') }}" class="mx-auto my-2 rounded-full" width="150">
      @endif
      <p class="text-xl text-white my-2">Configurar perfil</p>
      <p class="text-xl text-white"><button id="b-info-personal">Informacion personal</button></p>
      <hr class="mx-3 my-1">
      <p class="text-xl text-white"><button id="b-update-password">Cambiar contraseña</button></p>
      <hr class="mx-3 my-1">
      <p class="text-xl text-white"><button id="b-compras">Mis compras</button></p>
      <hr class="mx-3 my-1">
      <p class="text-xl text-white"><button id="b-borrar-cuenta">Borrar cuenta</button></p>
    </div>
    <div id="informacion-personal" class="hidden inline-block w-full text-center pt-5">
      @include('profile.partials.update-avatar')
      @include('profile.partials.update-profile-information-form')
    </div>
    <div id="update-password" class="hidden inline-block w-full text-center pt-5">
      @include('profile.partials.update-password-form')
    </div>
    <div id="compras" class="hidden inline-block w-full text-center pt-5">
      @include('profile.partials.compras')
    </div>
    <div id="borrar-cuenta" class="hidden bg-green-500 inline-block w-full text-center pt-5">
      @include('profile.partials.delete-user-form')
    </div>
  </div>
</div>

@include('layouts.footer')

<script>
  const boton_informacion_personal = document.querySelector('#b-info-personal');
  const boton_update_password = document.querySelector('#b-update-password');
  const boton_compras = document.querySelector('#b-compras');
  const boton_borrar_cuenta = document.querySelector('#b-borrar-cuenta');
  const contenido_informacion_personal = document.querySelector('#informacion-personal');
  const contenido_update_password = document.querySelector('#update-password');
  const contenido_compras = document.querySelector('#compras');
  const contenido_borrar_cuenta = document.querySelector('#borrar-cuenta');

  boton_informacion_personal.addEventListener("click", function() {
    contenido_informacion_personal.classList.remove("hidden");
    contenido_update_password.classList.add("hidden");
    contenido_compras.classList.add("hidden");
    contenido_borrar_cuenta.classList.add("hidden");
  });
  boton_update_password.addEventListener("click", function() {
    contenido_informacion_personal.classList.add("hidden");
    contenido_update_password.classList.remove("hidden");
    contenido_compras.classList.add("hidden");
    contenido_borrar_cuenta.classList.add("hidden");
  });
  boton_compras.addEventListener("click", function() {
    contenido_informacion_personal.classList.add("hidden");
    contenido_update_password.classList.add("hidden");
    contenido_compras.classList.remove("hidden");
    contenido_borrar_cuenta.classList.add("hidden");
  });
  boton_borrar_cuenta.addEventListener("click", function() {
    contenido_informacion_personal.classList.add("hidden");
    contenido_update_password.classList.add("hidden");
    contenido_compras.classList.add("hidden");
    contenido_borrar_cuenta.classList.remove("hidden");
  });



</script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
  
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<script>
  $(document).ready( function () {
      $('#MisCompras').DataTable();
  } );
</script>
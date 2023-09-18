<form method="post" action="{{ route('profile.updateavatar') }}" enctype="multipart/form-data" class="mx-auto w-5/6 p-5 rounded bg-gray-700 text-gray-400 mb-5">
    @csrf

    @if (\Session::has('update_avatar'))
        <p class="text-green-600 font-bold">
            {!! \Session::get('update_avatar') !!}
        </p>
    @endif

    <div class="imgContainer">
        <img id="imagenSeleccionada" class="rounded-full m-3 mx-auto object-contain object-center w-2/6 h-6/6" width="100">
    </div>

    <input class="mb-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="avatar" type="file" name="avatar">
    @error('avatar')
        <p class="p-2 text-left text-red-500">{{ $message }}</p>
    @enderror
    <button type="submit" class="text-white bg-green-700 font-bold px-2 py-1 my-2 rounded">Guardar</button>
</form>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function (e) {
        $('#avatar').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src',e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
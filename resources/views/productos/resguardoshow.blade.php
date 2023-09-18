@include('layouts.header')
<style>
    #form {
        width: 250px;
        margin: 0 auto;
        height: 50px;
    }

    #form p {
        text-align: center;
    }

    #form label {
        font-size: 20px;
    }

    input[type="radio"] {
        display: none;
    }

    label {
        color: grey;
    }

    .clasificacion {
        direction: rtl;
        unicode-bidi: bidi-override;
    }

    label:hover:not(.estrellita),
    label:hover:not(.estrellita) ~ label {
        color: orange;
    }

    input[type="radio"]:checked ~ label {
        color: orange;
    }
</style>
<div class="container mx-auto lg:mt-2 lg:mb-2">
    <br>
    <div style="box-shadow: 9px 8px 20px -7px rgba(247, 247, 247, 0.68);"  class="grid grid-cols-1 bg-gray-900 w-3/5 mx-auto rounded">
        <br>
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-y-5 gap-x">
            <div class="mx-auto mt-2">
                <img id="imgChange" class="w-full rounded h-96" src="{{ asset('img_products/' . $producto->foto_1) }}" width="200" height="100">
            </div>

            <div class="mx-auto grid grid-cols-3 gap-5">
                <img id="img1" class="mx-auto w-10/12 rounded hover:cursor-pointer" src="{{ asset('img_products/' . $producto->foto_1) }}" width="200">
                <img id="img2" class="mx-auto w-10/12 rounded hover:cursor-pointer" src="{{ asset('img_products/' . $producto->foto_2) }}" width="200">
                <img id="img3" class="mx-auto w-10/12 rounded hover:cursor-pointer" src="{{ asset('img_products/' . $producto->foto_3) }}" width="200">
            </div>

            <div class="grid grid-cols-1 mx-auto text-white font-bold w-full">
                <div>
                    <p class="text-center  text-2xl">{{ $producto->titulo }}</p>
                </div>
                <div class="grid grid-rows-1 w-5/6 lg:w-1/2 mx-auto gap-2">
                    <div class="grid grid-cols-2">
                        <p class="">Color: </p>
                        <p class="">Talle: </p>
                    </div>
                    @foreach ($producto->MostrarColores() as $color)
                        <div class="grid grid-cols-2 text-sm contenedor-colores">
                            <div class="w-1/3" >
                                <label for="{{ $color->color }}">
                                    <div onclick="pintar({{ $color->id }})" id="div_color_{{ $color->id }}" class="bg-white mx-auto rounded-xl text-black gap-2 p-2 hover:cursor-pointer hover:bg-black border-solid border-2 border-sky-500">
                                        <div style="background-color: {{ $color->color }};" class="rounded-full h-4 w-4 mx-auto"></div>
                                    </div>
                                    <input class="hidden input_color" type="checkbox" id="{{ $color->color }}" value="{{ $color->id }}">
                                </label>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($producto->MostrarTalles($color->id) as $talle)
                                    <div>
                                        <label for="{{ $talle->id }}">
                                            <div onclick="pintar_2({{ $talle->id }})" id="div_{{ $talle->id }}" class="w-full grid grid-cols-1 bg-white mx-auto rounded-xl text-black gap-2 hover:cursor-pointer hover:bg-black hover:text-white border-solid border-2 border-sky-500">
                                                <p class="mx-auto p-2">
                                                    {{ $talle->talle }}
                                                </p>
                                            </div>
                                            <input class="hidden input_talle" type="checkbox" id="{{ $talle->id }}" value="{{ $color->id }}" placeholder="{{ $talle->talle }}">
                                        </label>
                                        <div class="hidden mt-2" id="seccion_talle_{{ $talle->id }}">
                                            <button onclick="restar('{{ $talle->id }}')" class="bg-black text-white rounded px-2 hover:pointer-cursor">-</button>
                                            <input id="talle_{{ $talle->id }}" placeholder="{{ $color->id }}" type="number" class="input_cantidad text-black text-center rounded border-2 border-sky-500 w-9" readonly value="0">
                                            <button onclick="sumar('{{ $talle->id }}')" class="bg-black text-white rounded px-2 hover:pointer-cursor">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <div id="Mensajes"></div>
                </div>
                <div class="grid grid-cols-3 mx-auto w-5/6 lg:w-1/2">
                    <div class="grid grid-row-1">
                        <p class="text-md">Precio: </p>
                        <p class="text-4xl">${{ $producto->precio }}</p>
                        <p>Envio: ${{ $producto->precio_envio }}</p>
                    </div>
                    <div class="col-span-2">
                        <button onclick="CheckAgregar({{ $producto->id }})" 
                            class="w-3/4 bg-blue-500 rounded-lg p-3 ml-10 mt-5">Agregar al carrito</button>
                    </div>
                    
                </div>
                <br>
            </div>
        </div>
    </div>

    <div class="mx-auto w-1/2 mt-10 font-bold">
        <button id="cont1" class="border-solid border-2 border-sky-500 m-2 bg-white rounded-xl p-2" >Caracteristicas</button>
        <button id="cont2" class="border-solid border-2 border-sky-500 m-2 bg-white rounded-xl p-2" >Reseñas</button>
        <button id="cont3" class="border-solid border-2 border-sky-500 m-2 bg-white rounded-xl p-2">Envio</button>
    </div>
    <div id="content1" class="text-white mx-auto w-1/2 my-5 border-solid border-2 border-sky-500 rounded p-5">
        <strong class="text-xl">Parrafo 1</strong>
        <p class="text-lg">{{ $producto->caracteristicas }}</p>
    </div>
    <div id="content2" class="text-white mx-auto w-1/2 my-5 border-solid border-2 border-sky-500 rounded p-5">
        <strong class="text-xl">Reseñas</strong>
        <div id="pintar_comentarios" class="h-44 overflow-auto">
            @php
                $contador = 1;
            @endphp
            @foreach ($producto->Comentarios() as $comentario)
                <div class="mx-auto w-full rounded m-5 bg-gray-700 text-gray-400">
                    <div class="mb-6">
                        <div class="flex flex-cols-2">
                            <div>
                                @if($comentario->User->avatar)
                                    <img src="{{ asset('img_profile/'.$comentario->User->avatar) }}" class="rounded-full m-3" width="37">
                                @else
                                    <img src="{{ asset('img_profile/default.jpg') }}" class="rounded-full m-3" width="37">
                                @endif
                            </div>
                            <div class="m-2 w-full">
                                <p class="pt-2 text-white text-xs font-bold ">{{ $comentario->User->name }} </p>
                                <p class="pt-1">{{ $comentario->comentario }}</p>
                                <div class="text-right">
                                    <p class="clasificacion">
                                        <input id="rate_{{ $contador }}_5" type="radio" disabled value="5" {{ $comentario->estrellas == 5 ? 'checked':'' }}>
                                        <label class="estrellita" for="rate_{{ $contador }}_5" class="text-xl">★</label>
                                        <input id="rate_{{ $contador }}_4" type="radio" disabled value="4" {{ $comentario->estrellas == 4 ? 'checked':'' }}>
                                        <label class="estrellita" for="rate_{{ $contador }}_4" class="text-lg">★</label>
                                        <input id="rate_{{ $contador }}_3" type="radio" disabled value="3" {{ $comentario->estrellas == 3 ? 'checked':'' }}>
                                        <label class="estrellita" for="rate_{{ $contador }}_3" class="text-base">★</label>
                                        <input id="rate_{{ $contador }}_2" type="radio" disabled value="2" {{ $comentario->estrellas == 2 ? 'checked':'' }}>
                                        <label class="estrellita" for="rate_{{ $contador }}_2" class="text-sm">★</label>
                                        <input id="rate_{{ $contador }}_1" type="radio" disabled value="1" {{ $comentario->estrellas == 1 ? 'checked':'' }}>
                                        <label class="estrellita" for="rate_{{ $contador }}_1" class="text-xs">★</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $contador ++;
                @endphp
            @endforeach
        </div>
        <div id="comentario_exito">

        </div>
        @if(Auth::check())
            <form id="form_comentario" method="post" action="{{ url('/producto/comentario') }}" class="mx-auto w-full rounded m-5 p-5 bg-gray-700 text-gray-400">
                @csrf
                <input type="text" id="id_producto" class="hidden" name="producto" value="{{ $producto->id }}">
                <input type="text" id="id_user" class="hidden" name="user" value="{{ Auth::id() }}">
                <div class="mb-6">
                    <label for="comentario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">¿Qué te pareció tu producto?</label>
                    <x-text-input type="text" id="comentario" name="comentario" :value="old('comentario')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Dejanos un comentario..."/>
                    <div id="error_comentario">

                    </div>
                </div>
                
                <p class="clasificacion">
                    <input id="radio1" type="radio" name="estrellas" value="5" class="radios">
                    <label for="radio1" class="text-xl">★</label>
                    <input id="radio2" type="radio" name="estrellas" value="4" class="radios">
                    <label for="radio2" class="text-lg">★</label>
                    <input id="radio3" type="radio" name="estrellas" value="3" class="radios">
                    <label for="radio3" class="text-base">★</label>
                    <input id="radio4" type="radio" name="estrellas" value="2" class="radios">
                    <label for="radio4" class="text-sm">★</label>
                    <input id="radio5" type="radio" name="estrellas" value="1" class="radios">
                    <label for="radio5" class="text-xs">★</label>
                </p>
                <div id="error_estrellas">
                    
                </div>
                <button onclick="Conectar()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Comentar</button>
            </form>
        @else
        <div class="mx-auto w-full rounded m-5 p-5 bg-gray-700 text-gray-400">
            <p class="text-center hover:text-white">Inicia sesion para dejar un comentario</p>
        </div>
        @endif
    </div>
    <div id="content3" class="text-white mx-auto w-1/2 my-5 border-solid border-2 border-sky-500 rounded p-5">
        <strong class="text-xl">Envio</strong>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe accusamus in aspernatur repellendus quasi neque tempora expedita culpa. Voluptatibus hic esse molestiae, vel odit unde harum voluptate molestias corporis illum.</p>
    </div>
    <br>
</div>
<script>
    function pintar(id){
        const element = document.querySelector('#div_color_'+id)
        if(element.classList.contains('bg-white'))
            agregar(element);
        else
            remover(element);
    }
    function pintar_2(id){
        const contenedor = document.querySelector('#seccion_talle_'+id);
        const element = document.querySelector('#div_'+id)
        if(element.classList.contains('bg-white')){
            agregar(element);
            contenedor.classList.remove("hidden");
            contenedor.children[1].value = 1;
        }else{
            remover(element);
            contenedor.classList.add("hidden");
            contenedor.children[1].value = 0;
        }
    }
    let img1 = document.getElementById('img1');
    let img2 = document.getElementById('img2');
    let img3 = document.getElementById('img3');
    let imgChange = document.getElementById('imgChange');
    img1.onclick = function(){
        imgChange.src= '{{ asset('img_products/' . $producto->foto_1) }}';
    }
    img2.onclick = function(){
        imgChange.src= '{{ asset('img_products/' . $producto->foto_2) }}';
    }
    img3.onclick = function(){
        imgChange.src= '{{ asset('img_products/' . $producto->foto_3) }}';
    }
    function sumar(valor){
        const cant = document.querySelector('#talle_'+valor);
        const cantidadValor = (cant.value);
        let cantidadV= parseInt(cantidadValor)
        if(cantidadV < 100){
            cantidadV++;
            cant.value = cantidadV
        }
    }
    function restar(valor){
        const cant = document.querySelector('#talle_'+valor);
        const cantidadValor = (cant.value);
        let cantidadV= parseInt(cantidadValor);
        if(cantidadV>1){
            cantidadV--;
            cant.value = cantidadV
        }
    }
    let cont1 = document.getElementById('cont1');
    let cont2 = document.getElementById('cont2');
    let cont3 = document.getElementById('cont3');
    let contenido1 = document.getElementById('content1');
    let contenido2 = document.getElementById('content2');
    let contenido3 = document.getElementById('content3');
    contenido1.style.display='block';
    contenido2.style.display='none';
    contenido3.style.display='none';
    agregar(cont1);
    function agregar(element) {
        element.classList.remove("bg-white");
        element.classList.remove("text-black");
        element.classList.add("bg-black");
        element.classList.add("text-white");
    }
    function remover(element) {
        element.classList.remove("bg-black");
        element.classList.remove("text-white");
        element.classList.add("bg-white");
        element.classList.add("text-black");
    }
    cont1.onclick = function(){
        agregar(cont1)
        remover(cont2)
        remover(cont3)
        contenido1.style.display='block';
        contenido2.style.display='none';
        contenido3.style.display='none';
    }
    cont2.onclick = function(){
        agregar(cont2);
        remover(cont1);
        remover(cont3);
        contenido1.style.display='none';
        contenido2.style.display='block';
        contenido3.style.display='none';
    }
    cont3.onclick = function(){
        agregar(cont3);
        remover(cont2);
        remover(cont1);
        contenido1.style.display='none';
        contenido2.style.display='none';
        contenido3.style.display='block';
    }

    const input_colores = document.querySelectorAll('.input_color');
    const input_talles = document.querySelectorAll('.input_talle');
    const input_cantidades = document.querySelectorAll('.input_cantidad');

    function MensajesExitosErrores(mensaje, color, opacidad){
        var Mensajes = document.querySelector('#Mensajes');
        Mensajes.innerHTML = `
            <div class="bg-${color}-${opacidad} rounded border-2 border-white text-black font-bold">
                <p class="p-2">
                    ${mensaje}
                </p>
            </div>
        `;
    }

    var lastTimeout;
    var lastTimeout_2;

    var lastTimeCom;
    var lastTimeEstre;
    var lastTimeExito;

    const CheckAgregar = (id) => {
        var colores_arr = [];
        var cont_colors = 0;
        var cont_talles = 0;
        input_colores.forEach((input) => { 
            if(input.checked){
                cont_colors++
                colores_arr.push({ 
                    nombre_color: input.id,
                    id_color: input.value, 
                    talles: []
                });// aca ponemos el id del color
            }
        });
        input_talles.forEach((input) => { 
            if(input.checked){
                cont_talles++
                let item = colores_arr.find((element) => element.id_color == input.value);
                if(item){
                    let copia_item = JSON.parse(JSON.stringify(item)) // hacemos una copia
                    copia_item.talles.push({
                        nombre_talle: input.placeholder,
                        id_talle: input.id,
                    });
                    const indice = colores_arr.findIndex((element) => element.id_color == input.value)
                    colores_arr[indice] = copia_item;
                }
            }
        });
        input_cantidades.forEach((input) => { 
            if(input.value >= 1){
                let item = colores_arr.find((element) => element.id_color === input.placeholder);
                if(item){
                    let copia_item = JSON.parse(JSON.stringify(item)) // hacemos una copia
                    var id = input.id.split('_');
                    const caca = copia_item.talles.find((element) => element.id_talle == id[1])
                    if(caca){
                        caca.cantidad = input.value;
                        const indice = colores_arr.findIndex((element) => element.id_color == input.placeholder)
                        if(indice) colores_arr[indice] = copia_item;
                    }
                }
            }
        });
        if(!cont_colors){
            MensajesExitosErrores("Debes seleccionar almenos un color", "red", "600");
            return
        }
        if(!cont_talles){
            MensajesExitosErrores("Debes seleccionar almenos un talle", "red", "600");
            return
        }
        var contenedores = document.querySelectorAll('.contenedor-colores');
        var error_general = false;
        contenedores.forEach(element => {
            if(element.children[0].children[0].children[1].checked){ // obtengo el campo de color, siempre que este chequeado
                const hijos = element.children[1].children;
                var se_puede = false;
                for (let i = 0; i < hijos.length; i++) {
                    const hijo = hijos[i];
                    if(hijo.children[0].children[1].checked) // si selecciono
                        se_puede = true
                }
                if(!se_puede){
                    error_general = true;
                    errores = "Debes seleccionar almenos un talle";
                }
            }else{// si no esta seleccionado y alguno de sus hijos esta seleccionado fue
                const hijos = element.children[1].children;
                for (let i = 0; i < hijos.length; i++) {
                    const hijo = hijos[i];
                    if(hijo.children[0].children[1].checked){ // si selecciono
                        errores = "Debes seleccionar un color tambien";
                        error_general = true;
                    }
                }
            }
        });
        if(error_general){
            MensajesExitosErrores(errores, "red", "600");
            return
        }
        agregarProducto(id,colores_arr);
        MensajesExitosErrores("El producto fue agregado al carrito con exito!", "green", "600");
        numerito_carrito.innerHTML = carrito.length;
        clearTimeout(lastTimeout);
        lastTimeout = setTimeout(() => {
            Mensajes.innerHTML = "";
        }, 3000);
    
        return
    }



    function Conectar(){
        const inputs = document.querySelectorAll('.radios');
        var estrellas = 0;
        inputs.forEach((element) => {
            if(element.checked)
                estrellas = parseInt(element.value);
        });
        const id_producto = document.querySelector('#id_producto').value;
        const id_user = document.querySelector('#id_user').value;
        const comentario = document.querySelector('#comentario').value;

        var urlRaiz = window.location.origin;
        const API_URL = urlRaiz+'/producto/comentar?producto='+id_producto+'&user='+id_user+'&comentario='+comentario+'&estrellas='+estrellas;
        const xhr = new XMLHttpRequest();

        const error_comentario = document.querySelector('#error_comentario');
        const error_estrellas = document.querySelector('#error_estrellas');
        const comentario_exito = document.querySelector('#comentario_exito');

        function Respuesta(){
            if(this.readyState === 4 && this.status === 200){
                //console.log(this.response)
                const data = JSON.parse(this.response);
                //console.log(data);
                repintar(data);
                comentario_exito.innerHTML = `
                <div class="w-4/5 mx-auto my-5 bg-green-500">
                    <p class="p-2 m-2 text-center">Comentario publicado exitosamente!</p>
                </div>
                `;
                clearTimeout(lastTimeExito);
                    lastTimeExito = setTimeout(() => {
                    comentario_exito.innerHTML = "";
                }, 3000);
            }else if(this.status === 404){
                //console.log(this.response)
                switch(this.response){
                    case '404':
                        error_comentario.innerHTML = `<p class="p-2 text-left text-red-500">El comentario debe tener una longitud minima de 10 caracteres</p>`;
                        clearTimeout(lastTimeCom);
                            lastTimeCom = setTimeout(() => {
                            error_comentario.innerHTML = "";
                        }, 3000);
                        break;
                    case '405':
                        error_estrellas.innerHTML = `<p class="p-2 text-right text-red-500">Debes elegir almenos una estrella</p>`;
                        clearTimeout(lastTimeEstre);
                            lastTimeEstre = setTimeout(() => {
                            error_estrellas.innerHTML = "";
                        }, 3000);
                        break;
                }
            }
        }
        xhr.addEventListener("load", Respuesta);
        xhr.open("GET", API_URL);
        xhr.send();
    }

    function repintar(data){
        const contenedor = document.querySelector('#pintar_comentarios');
        const formulario = document.querySelector("#form_comentario");
        formulario.reset();
        contenedor.innerHTML = ``;
        var cont = 0;
        data.forEach((element) =>{
            var radio = element.estrellas;
            contenedor.innerHTML += `
            <div class="mx-auto w-full rounded m-5 bg-gray-700 text-gray-400">
                <div class="mb-6">
                    <div class="flex flex-cols-2">
                        <div>
                            <img src="{{ asset('img_profile/') }}/${element.avatar_autor ? element.avatar_autor : 'default.jpg'}" class="rounded-full m-3" width="37">
                        </div> 
                        <div class="m-2 w-full">
                            <p class="pt-2 text-white text-xs font-bold ">${element.autor} </p>
                            <p class="pt-1">${element.comentario}</p>
                            <div class="text-right">
                                <p class="clasificacion">
                                    <input id="rate_${cont}_5" type="radio" disabled value="5" ${element.estrellas == 5 ? 'checked':''}>
                                    <label class="estrellita" for="rate_${cont}_5" class="text-xl">★</label>
                                    <input id="rate_${cont}_4" type="radio" disabled value="4" ${element.estrellas == 4 ? 'checked':''}>
                                    <label class="estrellita" for="rate_${cont}_4" class="text-lg">★</label>
                                    <input id="rate_${cont}_3" type="radio" disabled value="3" ${element.estrellas == 3 ? 'checked':''}>
                                    <label class="estrellita" for="rate_${cont}_3" class="text-base">★</label>
                                    <input id="rate_${cont}_2" type="radio" disabled value="2" ${element.estrellas == 2 ? 'checked':''}>
                                    <label class="estrellita" for="rate_${cont}_2" class="text-sm">★</label>
                                    <input id="rate_${cont}_1" type="radio" disabled value="1" ${element.estrellas == 1 ? 'checked':''}>
                                    <label class="estrellita" for="rate_${cont}_1" class="text-xs">★</label>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
            cont++;
        })
    }
</script>
@include('layouts.footer')


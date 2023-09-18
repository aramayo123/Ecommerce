<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index():View
    {
        $reversed_1 = Producto::all();
        $productos = $reversed_1->reverse();
        $productos->all();

        $reversed_2 = Categoria::all();
        $categorias = $reversed_2->reverse();
        $categorias->all();

        return view('productos.index', compact('productos', 'categorias'));
    }
    public function create():View
    {
        $reversed_2 = Categoria::all();
        $categorias = $reversed_2->reverse();
        $categorias->all();
        return view('productos.crear', compact('categorias'));
    }
    public function store(ProductoRequest $request):RedirectResponse
    {
        $SubProductos = $request->input("colores");
        for ($i = 0; $i < count($SubProductos); $i++) {
            for ($j = 0; $j < count($SubProductos[$i]); $j++) {
                if($SubProductos[$i][$j] == null){
                    return redirect()->route('productos.create')->with('error', 'No puedes dejar en blanco ningun campo de color ni de talle');
                }
            }
        }

        $foto_1 = "";
        $foto_2 = "";
        $foto_3 = "";

        if($request->foto_1 != null){
            $foto_1 = time().".".$request->foto_1->extension();
            $request->foto_1->move(public_path("img_products"),$foto_1);
        }
        if($request->foto_2 != null){
            $foto_2 = (time()+1).".".$request->foto_2->extension();
            $request->foto_2->move(public_path("img_products"),$foto_2);
        }
        if($request->foto_3 != null){
            $foto_3 = (time()+2).".".$request->foto_3->extension();
            $request->foto_3->move(public_path("img_products"),$foto_3);
        }
        $SubProductos = $request->input("colores");
        $producto = new Producto();
        $producto->titulo = $request->titulo;
        $producto->id_categoria = $request->categoria;
        $producto->foto_1 = $foto_1;
        $producto->foto_2 = $foto_2;
        $producto->foto_3 = $foto_3;
        $producto->caracteristicas = $request->caracteristicas;
        $producto->cantidad = 1;
        $producto->precio = $request->precio;
        $producto->precio_envio = $request->precio_envio;
        $producto->active = $request->active;
        $producto->save();
        $producto->CrearColores($SubProductos);
        
        return redirect()->route('productos.index')->with('exito', 'El producto ha sido creado con exito!');
    }
    public function show(Producto $producto):View
    {
        return view('productos.show', compact('producto'));
    }
    public function edit(Producto $producto):View
    {
        $reversed_2 = Categoria::all();
        $categorias = $reversed_2->reverse();
        $categorias->all();
        return view('productos.editar', compact('producto', 'categorias'));
    }
    public function update(ProductoRequest $request, Producto $producto):RedirectResponse
    {
        //
        $foto_1 = "";
        $foto_2 = "";
        $foto_3 = "";

        if($request->foto_1 != null){
            $foto_1 = time().".".$request->foto_1->extension();
            $request->foto_1->move(public_path("img_products"),$foto_1);
        }
        if($request->foto_2 != null){
            $foto_2 = (time()+1).".".$request->foto_2->extension();
            $request->foto_2->move(public_path("img_products"),$foto_2);
        }
        if($request->foto_3 != null){
            $foto_3 = (time()+2).".".$request->foto_3->extension();
            $request->foto_3->move(public_path("img_products"),$foto_3);
        }

        $producto->titulo = $request->titulo;
        $producto->id_categoria = $request->categoria;
        
        if($foto_1 != null)
            $producto->foto_1 = $foto_1;
        if($foto_2 != null)
            $producto->foto_2 = $foto_2;
        if($foto_3 != null)
            $producto->foto_3 = $foto_3;

        $producto->caracteristicas = $request->caracteristicas;
        $producto->precio = $request->precio;
        $producto->precio_envio = $request->precio_envio;
        $producto->active = $request->active;
        $producto->update();
        return redirect()->route('productos.index')->with('exito', 'El producto ha sido actualizado con exito!');
    }
    public function destroy(Producto $producto):RedirectResponse
    {
        if($producto->foto_1 != null){
            unlink(public_path('img_products/'.$producto->foto_1));
        }

        if($producto->foto_2 != null){
            unlink(public_path('img_products/'.$producto->foto_2));
        }
        if($producto->foto_3 != null){
            unlink(public_path('img_products/'.$producto->foto_3));
        }
        Producto::destroy($producto->id);
        return redirect()->route('productos.index')->with('exito', 'El producto ha sido eliminado con exito!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Categoria;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{
    public function index()
    {
        $reversed = Categoria::all();
        $categorias = $reversed->reverse();
        $categorias->all();
        return view('categorias.index', compact('categorias'));
    }
    public function create():View
    {
        return view('categorias.crear');
    }
    public function store(CategoriaRequest $request):RedirectResponse
    {
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->save();
        return redirect()->route('categorias.index')->with('exito','La categoria ha sido creada con exito');
    }
    public function show(Categoria $categoria):View
    {
        //
        return view('categorias.show', compact('categoria'));
    }
    public function edit(Categoria $categoria):View
    {
        return view('categorias.editar', compact('categoria'));
    }
    public function update(CategoriaRequest $request, Categoria $categoria):RedirectResponse
    {
        $categoria->nombre = $request->nombre;
        $categoria->update();

        return redirect()->route('categorias.index')->with('exito','La categoria ha sido actualizada con exito');
    }
    public function destroy(Categoria $categoria):RedirectResponse
    {
        //
        Categoria::destroy($categoria->id);
        return redirect()->route('categorias.index')->with('exito', 'La categoria ha sido eliminada con exito!');
    }
}

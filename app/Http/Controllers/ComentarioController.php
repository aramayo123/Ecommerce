<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ComentarioRequest;
use App\Models\Comentario;
use Illuminate\Http\RedirectResponse;

class ComentarioController extends Controller
{

    public function EliminarComentario(Comentario $comentario):RedirectResponse
    {
        Comentario::destroy($comentario->id);
        return redirect()->route('productos.show')->with('exito', 'Comentario eliminado con exito!');
    }
    public function CrearComentario(Request $request){
        if(strlen($request->comentario) < 10) 
            return response()->json(404, 404);

        if(intval($request->estrellas) <= 0) 
            return response()->json(405, 404);
           
        $comentario = new Comentario();
        $comentario->producto_id = $request->producto;
        $comentario->user_id = $request->user;
        $comentario->comentario = $request->comentario;
        $comentario->estrellas = $request->estrellas;
        //$comentario->autor = $request->autor;
        //$comentario->avatar_autor = $request->avatar_autor;
        $comentario->save();
        $comentarios = Comentario::where('producto_id', $request->producto)->orderBy('created_at', 'desc')->get();
        //$comentarios = array_reverse($comentarios);
        foreach($comentarios as $comentario){
            $comentario->autor = $comentario->User->name;
            $comentario->avatar_autor = $comentario->User->avatar;
        }
        return response()->json($comentarios, 200);
    }
}

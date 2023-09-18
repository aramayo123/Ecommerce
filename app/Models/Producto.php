<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Color;
use App\Models\Talle;
class Producto extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'titulo',
        'id_categoria',
        'foto_1',
        'foto_2',
        'foto_3',
        'caracteristicas',
        'cantidad',
        'precio',
        'precio_envio',
        'active',
    ];
    public function Categoria(): HasOne
    {
        return $this->HasOne(Categoria::class, 'id', 'id_categoria');
    }
    public function CrearColores(Array $colores){
        for ($i = 0; $i < count($colores); $i++) {
            $this->CrearTalles($colores[$i]);
        }
    }
    public function CrearTalles(Array $talles){
        $NewColor = new Color();
        $NewColor->id_producto = $this->id;
        $NewColor->color = $talles[0];
        $NewColor->save();
        for ($i = 1; $i < count($talles); $i++) {
            $newTalle = new Talle();
            $newTalle->color_id = $NewColor->id;
            $newTalle->talle = $talles[$i];
            $newTalle->save();
        }
    }
    public function MostrarColores(){
        $colores = Color::where('id_producto', $this->id)->orderBy('created_at', 'desc')->get();
        return $colores;
    }
    public function MostrarTalles($id){
        $talles = Talle::where('color_id', $id)->orderBy('created_at', 'desc')->get();
        return $talles;
    }
    public function Comentarios()
    {
        $comentarios = Comentario::where('producto_id', $this->id)->orderBy('created_at', 'desc')->get();
        return $comentarios;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\Producto;

class Comentario extends Model
{
    use HasFactory;

    protected $autor;
    protected $avatar_autor;

    protected $fillable = [
        'producto_id',
        'user_id',
        'comentario',
    ];
    public function Producto(): HasOne
    {
        return $this->HasOne(Producto::class, 'id', 'producto_id');
    }
    public function User(): HasOne
    {
        return $this->HasOne(User::class, 'id', 'user_id');
    }
}

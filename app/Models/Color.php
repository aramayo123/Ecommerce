<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Color extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'id_producto',
        'color',
    ];
    
    public function Producto():HasOne
    {
        return $this->HasOne(Producto::class, 'id', 'id_producto');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Compra extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'id_ticket',
        'id_producto',
        'id_color',
        'id_talle',
        'cantidad',
    ];

    public function Ticket(): HasOne
    {
        return $this->HasOne(Ticket::class, 'id', 'id_ticket');
    }
    public function Producto(): HasOne
    {
        return $this->hasOne(Producto::class, 'id', 'id_producto');
    }
    public function Color(): HasOne
    {
        return $this->hasOne(Color::class, 'id', 'id_color');
    }
    public function Talle(): HasOne
    {
        return $this->hasOne(Talle::class, 'id', 'id_talle');
    }
}

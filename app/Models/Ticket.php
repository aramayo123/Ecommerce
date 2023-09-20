<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'id_mercadopago',
        'url_payment',
        'user_id',
        'contacto',
        'direccion',
        'total_precio',
        'ciudad',
        'provincia',
        'codigo_postal',
        'pais',
        'bool_pagado',
        'bool_acreditado',
        'bool_cancelado',
        'estado',
        'estado_detallado',
        'fecha_creacion',
        'hora_creacion',
        'fecha_del_pago',
        'hora_del_pago',
    ];
    public function User():HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function Compras(){
        $compras = Compra::where('id_ticket', $this->id)->get();
        return $compras;
    }
}

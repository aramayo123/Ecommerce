<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rol extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'nombre',
    ];

    public function users(): BelongsToMany
    {
        //                          model,      table,      clave_foreign   clave_relacionada
        return $this->belongsToMany(User::class,'role_users', 'user_id', 'role_id');
    }
}

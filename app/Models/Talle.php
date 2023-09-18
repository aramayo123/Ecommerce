<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Talle extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'color_id',
        'talle',
    ];

    public function Color():HasOne
    {
        return $this->HasOne(Color::class, 'id', 'color_id');
    }
}

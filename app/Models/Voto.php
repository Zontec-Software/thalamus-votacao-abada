<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'nome_completo',
        'mac_address',
    ];

    protected $casts = [
        'pessoa_id' => 'integer',
    ];
}


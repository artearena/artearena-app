<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutosConfeccao extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto',
        'tempo_colaborador',
        'tempo_cronometrado',
        'tempo_empresa',
        'tempo_mercado',
    ];
}
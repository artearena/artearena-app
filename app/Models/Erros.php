<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Erro extends Model
{
    use HasFactory;

    protected $fillable = [
        'departamento',
        'data',
        'responsavel',
        'pedido',
        'tipo_produto',
        'tipo_erro',
        'erro',
        'consequencia_erro',
        'custo',
        'descontado',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoLista extends Model
{
    protected $fillable = [
        'produto_nome',
        'sexo',
        'arte_aprovada',
        'pacote',
        'camisa',
        'calcao',
        'meiao',
        'nome_jogador',
        'numero',
        'tamanho',
        'gola',
        // Adicione outros campos conforme necessário
    ];
}


<?php

use Illuminate\Database\Eloquent\Model;

class ProdutoLista extends Model
{
    protected $table = 'produtos_lista_uniforme';

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
        'id_lista',
    ];

    // Defina os campos booleanos
    protected $casts = [
        'camisa' => 'boolean',
        'calcao' => 'boolean',
        'meiao' => 'boolean',
    ];
}


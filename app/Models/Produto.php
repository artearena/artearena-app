<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'DATA_CRIACAO',
        'NOME',
        'CODIGO',
        'PRECO',
        'PRECO_PROMOCIONAL',
        'UNIDADE',
        'GTIN',
        'TIPOVARIACAO',
        'LOCALIZACAO',
        'PRECO_CUSTO',
        'PRECO_CUSTO_MEDIO',
        'SITUACAO',
        'ALTURA',
        'COMPRIMENTO',
        'LARGURA',
        'TEMPO_CONFECCAOMIN',
    ];
}

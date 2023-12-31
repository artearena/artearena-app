<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoListView extends Model
{
    protected $table = 'view_pedido_lista';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'cliente_id',
        'vendedor',
        'produto_nome',
        'quantidade',
        'sexo',
        'arte_aprovada',
        'lista_aprovada',
        'pacote',
        'camisa',
        'calcao',
        'meiao',
        'nome',
        'numero',
        'tamanho',
        'id_lista',
    ];

}
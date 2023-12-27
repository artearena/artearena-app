<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoPedido extends Model
{
    use HasFactory;

    protected $table = 'pedido_produtos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'pedido_id',
        'produto_nome',
        'quantidade',
        'preco_unitario',
        'sexo',
        'arte_aprovada',
        'lista_aprovada',
        'pacote',
        'camisa',
        'calcao',
        'meiao',
        'nome_jogador',
        'numero',
        'tamanho',
        'id_lista',
    ];

    public function pedido()
    {
        return $this->belongsTo(PedidoInterno::class, 'pedido_id', 'id');
    }
}
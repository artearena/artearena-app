<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoPedido extends Model
{
    protected $table = 'produtos_pedido';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'pedido_id',
        'produto_nome',
        'quantidade',
        'preco_unitario',
    ];

    public function pedido()
    {
        return $this->belongsTo(PedidoInterno::class, 'pedido_id', 'id');
    }
}
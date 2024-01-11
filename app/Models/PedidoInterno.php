<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoInterno extends Model
{
    protected $table = 'pedido_tiny_interno';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'cliente_id',
        'Vendedor',
        'forma_pagamento',
        'transportadora',
        'valor_frete',
        'observacao',
        'marcador',
        'data_venda',
        'id_orcamento',
    ];

    public function produtos()
    {
        return $this->hasMany(ProdutoPedido::class, 'pedido_id', 'id');
    }
    
}

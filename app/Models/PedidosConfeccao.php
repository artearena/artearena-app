<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosConfeccao extends Model
{
    use HasFactory;
    protected $table = 'pedidos_confeccao';

    protected $fillable = [
        'produtos',
        'confecção',
        'fase',
        'tempo_por_peca',
        'pronto',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcessoTemporario extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'acesso_temporario';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',
        'validade',
        'pedido_id',
    ];

    /**
     * Verifica se um link temporário foi criado para um pedido específico.
     *
     * @param int $pedidoId O ID do pedido a ser verificado.
     * @return bool True se um link temporário existe para o pedido, False caso contrário.
     */
    public static function linkCriadoParaPedido($pedidoId)
    {
        return self::where('pedido_id', $pedidoId)->exists();
    }
}

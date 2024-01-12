<?php

// app/Models/Pedido.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoExterno extends Model
{
    protected $table = 'pedido_tiny_externo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'numero',
        'numero_ecommerce',
        'data_pedido',
        'data_prevista',
        'nome_cliente',
        'valor',
        'id_vendedor',
        'nome_vendedor',
        'situacao',
        'codigo_rastreamento',
        'url_rastreamento',
    ];
    public static function obterSomaTotalPorVendedor($dataInicial, $dataFinal, $situacoes)
    {
        return self::select('id_vendedor', 'nome_vendedor')
            ->selectRaw('CONCAT("R$ ", FORMAT(SUM(CASE WHEN situacao <> "Cancelado" THEN valor ELSE 0 END), 2)) AS soma_total_reais')
            ->whereBetween('data_pedido', [$dataInicial, $dataFinal])
            ->whereIn('situacao', $situacoes)
            ->groupBy('id_vendedor', 'nome_vendedor')
            ->get();
    }
    // Adicione outras relações ou métodos conforme necessário
}

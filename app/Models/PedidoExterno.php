<?php

// app/Models/Pedido.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return self::select(
                'id_vendedor', 
                'nome_vendedor', 
                'data_pedido',
                DB::raw('SUM(valor) AS soma_total'),
                DB::raw('SUM(COALESCE((SELECT SUM(valor_frete) FROM pedido_externo_info WHERE numero = pedido_tiny_externo.numero), 0)) AS soma_total_frete')
            )
            ->selectRaw('CONCAT("R$ ", FORMAT(SUM(COALESCE(valor - (SELECT COALESCE(SUM(valor_frete), 0) FROM pedido_externo_info WHERE numero = pedido_tiny_externo.numero), 0)), 2)) AS soma_total_reais')
            ->whereBetween('data_pedido', [$dataInicial, $dataFinal])
            ->whereIn('situacao', $situacoes)
            ->groupBy('id_vendedor', 'nome_vendedor')
            ->get();
    }
    
    
    public static function obterSomaTotalPorVendedorEData($dataInicial, $dataFinal, $situacoes, $idVendedor = null)
    {
        // Configuração da localização fora da consulta principal
        DB::statement('SET lc_time_names = "pt_BR"');

        // Consulta principal
        $query = self::select('id_vendedor', 'nome_vendedor')
            ->selectRaw('YEAR(data_pedido) AS ano')
            ->selectRaw('MONTHNAME(data_pedido) AS mes')
            ->selectRaw('SUM(CASE WHEN situacao <> "Cancelado" THEN valor ELSE 0 END) AS soma_total_reais')
            ->whereBetween('data_pedido', [$dataInicial, $dataFinal])
            ->whereIn('situacao', $situacoes);

        if ($idVendedor !== null) {
            $query->where('id_vendedor', $idVendedor);
        }

        // Executa a consulta   
        return $query->groupBy('id_vendedor', 'nome_vendedor', 'ano', 'mes')->get();
    }

    public function vendedor()
    {
        return $this->belongsTo(Usuario::class, 'id_vendedor', 'id_vendedor');
    }
}

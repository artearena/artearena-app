<?php

// app/Http/Controllers/PedidoController.php

namespace App\Http\Controllers;

use App\Models\PedidoExterno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoExternoController extends Controller
{
    public function index(Request $request)
    {
        $dataInicial = $request->input('dataInicial', date('Y-m-01'));
        $dataFinal = $request->input('dataFinal', date('Y-m-d'));
        $situacoes = $request->input('situacao', ['Aprovado', 'Entregue', 'Cancelado', 'Não entregue', 'Dados incompletos', 'Enviado', 'Pronto para envio']);

        // Obter o id_vendedor do usuário autenticado
        $idVendedor = Auth::user()->id_vendedor;

        // Obter dados do gráfico para o vendedor autenticado
        $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        // Obter dados do gráfico para o vendedor autenticado
        $dadosGrafico = PedidoExterno::obterSomaTotalPorVendedorEData($dataInicial, $dataFinal, $situacoes, $idVendedor);

        // Preencher o array de data com os valores reais para cada mês
        $data = [];

        foreach ($meses as $mes) {
            // Inicializar o valor para o mês como 0
            $data[$mes] = 0;

            // Encontrar o item correspondente ao mês nos dados retornados da query
            $item = collect($dadosGrafico)->first(function ($item) use ($mes) {
                return strtolower($mes) === strtolower($item->mes);
            });

            // Se encontrou o item, atualiza o valor do mês
            if ($item) {
                $data[$mes] = floatval(str_replace(',', '', $item->soma_total_reais));
            }

        }

        // Obter dados do gráfico para o vendedor autenticado sem filtrar por mês
        $dados = PedidoExterno::obterSomaTotalPorVendedor($dataInicial, $dataFinal, $situacoes);

        // Carregar a visão com os dados
        return view('pages.tiny.relatorio', compact('dados', 'dadosGrafico', 'dataInicial', 'dataFinal', 'situacoes', 'meses', 'data'));
    }


    public function show($id)
    {
        $pedido = PedidoExterno::find($id);

        if ($pedido) {
            return response()->json($pedido);
        } else {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }
    }
}


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
        $dataInicial = $request->input('dataInicial', date('Y-m-d'));
        $dataFinal = $request->input('dataFinal', date('Y-m-d'));
        $situacoes = $request->input('situacao', ['Aprovado', 'Entregue', 'Cancelado', 'Não entregue', 'Dados incompletos', 'Enviado', 'Pronto para envio']);

        // Obter o id_vendedor do usuário autenticado
        $idVendedor = Auth::user()->id_vendedor;

        // Obter dados do gráfico para o vendedor autenticado
        $dadosGrafico = PedidoExterno::obterSomaTotalPorVendedorEData($dataInicial, $dataFinal, $situacoes, $idVendedor);

        // Organizar os dados por mês
        $dadosPorMes = $dadosGrafico->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->data_pedido)->format('F'); // 'F' retorna o nome do mês
        });

        // Criar um array com os rótulos dos meses
        $meses = $dadosPorMes->keys()->toArray();

        // Preencher o array de data com os valores reais para cada mês
        $data = [];

        foreach ($meses as $mes) {
            $data[$mes] = $dadosPorMes->get($mes)->sum(function ($item) {
                return is_numeric($item->soma_total_reais) ? $item->soma_total_reais : 0;
            });
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


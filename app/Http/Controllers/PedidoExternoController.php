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
        $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

        // Obter dados do gráfico para o vendedor autenticado
        $dadosGrafico = PedidoExterno::obterSomaTotalPorVendedorEData($dataInicial, $dataFinal, $situacoes, $idVendedor);

        // Preencher o array de data com os valores reais para cada mês
        $data = [];

        foreach ($meses as $mes) {
            // Verificar se o mês está nos dados retornados da query
            if (isset($dadosGrafico[$mes])) {
                // Preencher com o valor correspondente
                $data[$mes] = $dadosGrafico[$mes];
            } else {
                // Tratar os meses não retornados como 0
                $data[$mes] = 0;
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


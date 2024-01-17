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
        // Obter os demais dados para o gráfico (se necessário)
        $dataInicial = $request->input('dataInicial', date('Y-m-01'));
        $dataFinal = $request->input('dataFinal', date('Y-m-t'));
        $situacoes = $request->input('situacao', ['Aprovado', 'Entregue', 'Cancelado', 'Não entregue', 'Dados incompletos', 'Enviado', 'Pronto para envio']);

        // Obter o id_vendedor do usuário autenticado
        $idVendedor = Auth::user()->id_vendedor;

        // Obter dados do gráfico para o vendedor autenticado
        $dadosGrafico = PedidoExterno::obterSomaTotalPorVendedor($dataInicial, $dataFinal, $situacoes, $idVendedor);
        $dados = PedidoExterno::obterSomaTotalPorVendedor($dataInicial, $dataFinal, $situacoes);

        // Processar dados para o gráfico
        $labels = $dadosGrafico->pluck('nome_vendedor')->toArray();
        $data = $dadosGrafico->pluck('soma_total_reais')->toArray();

        // Carregar a visão com os dados
        return view('pages.tiny.relatorio', compact('dados', 'dadosGrafico', 'dataInicial', 'dataFinal', 'situacoes', 'labels', 'data'));
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


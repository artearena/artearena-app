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
        // Obter os dados para o gráfico (se necessário)
        $dataInicial = $request->input('dataInicial', date('Y-m-01'));
        $dataFinal = $request->input('dataFinal', date('Y-m-t'));
        $situacoes = $request->input('situacao', ['Aprovado', 'Entregue', 'Cancelado', 'Não entregue', 'Dados incompletos', 'Enviado', 'Pronto para envio']);

        // Obter o id_vendedor do usuário autenticado
        $idVendedor = Auth::user()->id_vendedor;

        // Obter dados do gráfico para o vendedor autenticado
        $dadosGrafico = PedidoExterno::obterSomaTotalPorVendedorEData($dataInicial, $dataFinal, $situacoes, $idVendedor);
        $dados = PedidoExterno::obterSomaTotalPorVendedorEData($dataInicial, $dataFinal, $situacoes, $idVendedor);

        // Calcular o número de dias entre a data inicial e final
        $diferencaDias = (new \DateTime($dataFinal))->diff(new \DateTime($dataInicial))->days;

        // Processar dados para o gráfico
        $labels = $dadosGrafico->map(function ($item) use ($diferencaDias) {
            return $item->nome_vendedor . ' - ' . $item->data_pedido;
        })->toArray();

        // Remover "R$" e transformar em número
        $data = $dadosGrafico->map(function ($item) {
            return floatval(str_replace('R$ ', '', $item->soma_total_reais));
        })->toArray();

        // Ajustar a largura do gráfico com base na diferença de dias
        $larguraGrafico = $diferencaDias * 20; // Ajuste conforme necessário

        return view('pages.tiny.relatorio', compact('dados','dadosGrafico', 'dataInicial', 'dataFinal', 'situacoes', 'labels', 'data', 'larguraGrafico'));
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


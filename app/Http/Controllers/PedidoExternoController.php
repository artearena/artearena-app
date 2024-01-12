<?php

// app/Http/Controllers/PedidoController.php

namespace App\Http\Controllers;

use App\Models\PedidoExterno;
use Illuminate\Http\Request;

class PedidoExternoController extends Controller
{
    public function index(Request $request)
    {
        $dataInicial = $request->input('dataInicial', date('Y-m-01'));
        $dataFinal = $request->input('dataFinal', date('Y-m-t'));
        $situacoes = $request->input('situacao', ['Aprovado', 'Entregue']);

        // Adicione logs para verificar os valores
        \Log::info('Data Inicial: ' . $dataInicial);
        \Log::info('Data Final: ' . $dataFinal);
        \Log::info('Situações: ' . implode(', ', $situacoes));

        $dados = PedidoExterno::obterSomaTotalPorVendedor($dataInicial, $dataFinal, $situacoes);

        return view('pages.tiny.relatorio', compact('dados', 'dataInicial', 'dataFinal', 'situacoes'));
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


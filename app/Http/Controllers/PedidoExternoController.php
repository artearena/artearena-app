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
        $situacoes = $request->input('situacao', ['Aprovado', 'Entregue', 'Cancelado', 'Não entregue', 'Dados incompletos', 'Enviado', 'Pronto para envio']);

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


<?php

// app/Http/Controllers/PedidoController.php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoExternoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        return view('pages.tiny.relatorio', compact('pedidos'));

    }

    public function show($id)
    {
        $pedido = Pedido::find($id);

        if ($pedido) {
            return response()->json($pedido);
        } else {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }
    }
}

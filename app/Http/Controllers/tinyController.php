<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiny;

class PedidoController extends Controller
{
    public function relatorio()
    {
        $tiny = tiny::all();
        return view('pages.tiny.relatorio', compact('tiny'));
    }

    public function show($id)
    {
        $pedido = Pedido::find($id);
        return view('pedidos.show', compact('pedido'));
    }

    public function create()
    {
        return view('pedidos.create');
    }

    public function store(Request $request)
    {
        // Valide e salve os dados do novo pedido
    }

    public function edit($id)
    {
        $pedido = Pedido::find($id);
        return view('pedidos.edit', compact('pedido'));
    }

    public function destroy($id)
    {
        $pedido = Pedido::find($id);
        $pedido->delete();
        return redirect()->route('pedidos.index');
    }
}

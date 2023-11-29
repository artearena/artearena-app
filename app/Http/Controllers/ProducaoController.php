<?php

namespace App\Http\Controllers;

use App\Models\PedidosConfeccao;
use Illuminate\Http\Request;

class ProducaoController extends Controller
{
    public function index()
    {
        $pedidos = PedidosConfeccao::all();
        return view('pages.producao.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pages.producao.create');
    }

    public function store(Request $request)
    {
        $pedido = PedidosConfeccao::create($request->all());
        return redirect()->route('pages.producao.index')->with('success', 'Pedido criado com sucesso.');
    }

    public function show($id)
    {
        $pedido = PedidosConfeccao::findOrFail($id);
        return view('pages.producao.show', compact('pedido'));
    }

    public function edit($id)
    {
        $pedido = PedidosConfeccao::findOrFail($id);
        return view('pages.producao.edit', compact('pedido'));
    }

    public function update(Request $request, $id)
    {
        $pedido = PedidosConfeccao::findOrFail($id);
        $pedido->update($request->all());
        return redirect()->route('pages.producao.index')->with('success', 'Pedido atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $pedido = PedidosConfeccao::findOrFail($id);
        $pedido->delete();
        return redirect()->route('pages.producao.index')->with('success', 'Pedido excluído com sucesso.');
    }
}
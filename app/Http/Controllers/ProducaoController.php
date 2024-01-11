<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produto;
use App\Models\ProdutoPedido;
use App\Models\PedidoInterno;

use Illuminate\Http\Request;

class ProducaoController extends Controller
{
    public function index()
    {
        // Busque os pedidos na etapa 'C'
        $pedidos = Pedido::where('etapa', 'C')->get();

        // Inicialize um array para armazenar os produtos relacionados
        $produtos_confeccao = [];

        // Verifique se há pedidos na etapa 'C' antes de continuar
        if ($pedidos->isNotEmpty()) {
            // Obtenha os IDs dos pedidos na etapa 'C'
            $ids_pedidos_c = $pedidos->pluck('id')->toArray();

            // Consulta Eloquent para obter os produtos de confecção associados aos pedidos na etapa 'C'
            $produtos_confeccao = ProdutoPedido::whereHas('pedido', function ($query) use ($ids_pedidos_c) {
                $query->whereIn('cliente_id', $ids_pedidos_c);
            })->get();
        }

        // Carregue os produtos de info
        $produtos_info = Produto::all();

        return view('pages.producao.index', compact('pedidos', 'produtos_info', 'produtos_confeccao'));
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
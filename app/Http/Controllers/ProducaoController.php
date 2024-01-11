<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produto;

use Illuminate\Http\Request;

class ProducaoController extends Controller
{
    public function index()
    {
        // Busque todos os pedidos na etapa 'C'
        $pedidos = Pedido::where('etapa', 'C')->get();

                // Para cada pedido, obtenha os produtos de confeccao associados
        foreach ($pedidos as $pedido) {
            // Supondo que haja uma relação entre Pedidos e ProdutoPedido através de um método chamado produtosPedido
            $produtosPedido = $pedido->produtosPedido;

            // Verifique se $produtosPedido não é nulo antes de iterar sobre ele
            if ($produtosPedido) {
                // Para cada produtoPedido, obtenha o produto associado
                foreach ($produtosPedido as $produtoPedido) {
                    $produto = $produtoPedido->produto;

                    // Adicione o produto ao array
                    $produtos_confeccao[] = $produto;
                }
            }
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\PedidoInterno;
use App\Models\ProdutoPedido;
use App\Models\ListaUniforme;
use App\Models\ProdutoListaUniforme;
class ListaUniformeController extends Controller
{
    public function index()
    {
        return view('pages.listaUniformes.index');
    }

    public function indexCliente($id)
    {
        $pedido = PedidoInterno::findOrFail($id);
        $produtoPedidos = ProdutoPedido::where('pedido_id', $id)->get();
        $listaUniformes = ListaUniforme::where('id_pedido', $id)->get();
        $produtoListas = ProdutoListaUniforme::whereIn('id_lista', $listaUniformes->pluck('id'))->get();
        
        dd($pedido, $produtoPedidos, $produtoPedidos, $produtoListas);

        return view('pages.listaUniformes.index', compact('pedido', 'produtoPedidos', 'listaUniformes', 'produtoListas'));
    }
    
    public function create()
    {
        return view('listas_uniforme.create');
    }

    public function store(Request $request)
    {
        $lista = ListaUniforme::create($request->all());
        return redirect()->route('listas_uniforme.index')->with('success', 'Lista de uniforme criada com sucesso!');
    }

    public function edit(ListaUniforme $lista)
    {
        return view('listas_uniforme.edit', compact('lista'));
    }

    public function update(Request $request, ListaUniforme $lista)
    {
        $lista->update($request->all());
        return redirect()->route('listas_uniforme.index')->with('success', 'Lista de uniforme atualizada com sucesso!');
    }

    public function destroy(ListaUniforme $lista)
    {
        $lista->delete();
        return redirect()->route('listas_uniforme.index')->with('success', 'Lista de uniforme excluída com sucesso!');
    }
}
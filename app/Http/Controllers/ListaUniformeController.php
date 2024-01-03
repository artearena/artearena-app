<?php

namespace App\Http\Controllers;

use App\Models\ProdutoPedido;
use Illuminate\Http\Request;
use App\Models\ListaUniforme;

class ListaUniformeController extends Controller
{
    public function index()
    {
        $listasUniforme = ProdutoPedido::all();
        return view('pages.listaUniformes.index', compact('listasUniforme'));
    }

    public function indexCliente($id)
    {
        // Busca todos os produtos que têm o pedido_id igual ao $id
        $produtos = ProdutoPedido::where('pedido_id', $id)->get();
        return view('pages.listaUniformes.index', compact('produtos'));
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
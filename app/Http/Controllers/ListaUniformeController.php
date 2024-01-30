<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ProdutoPedido;
use App\Models\ProdutoLista;
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
    
    public function consultarListas($id)
    {
        // Busca todas as listas de uniforme associadas ao pedido
        $listasUniforme = ListaUniforme::where('pedido_id', $id)->with('produtos')->get();

        // Retorna os dados como JSON
        return response()->json($listasUniforme);
    }

    public function create()
    {
        return view('listas_uniforme.create');
    }

    public function store(Request $request)
    {
        $lista = ListaUniforme::create($request->all());

        $this->invalidateToken($request->token);

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
    public function invalidateToken($token)
    {
        // Remove o token do banco de dados
        DB::table('acesso_temporario')->where('token', $token)->delete();
    }
    public function hasListaUniforme($pedidoId)
    {
        return ListaUniforme::where('pedido_id', $pedidoId)->exists();
    }
}
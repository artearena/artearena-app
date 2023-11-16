<?php

namespace App\Http\Controllers;

use App\Models\PedidoListView;
use Illuminate\Http\Request;
use App\Models\ListaUniforme;

class ListaUniformeController extends Controller
{
    public function index()
    {
        $listasUniforme = PedidoListView::all();
        return view('pages.listaUniformes.index', compact('listasUniforme'));
    }

    public function indexCliente($id)
    {
        try {
            // Adicione este ponto de depuração para verificar se a rota está sendo acessada corretamente
            $produtos = PedidoListView::find($id);
        
            // Adicione este ponto de depuração para verificar os produtos obtidos
            dd($produtos);
        
            if ($produtos->isEmpty()) {
                dd("avisa que ta vazio");
                $produtos = [];
            }
        
            return view('pages.listaUniformes.index', compact('produtos'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
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
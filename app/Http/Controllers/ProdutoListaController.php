<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoLista;

class ProdutoListaController extends Controller
{
    public function index()
    {
        $produtos = ProdutoLista::all();
        return view('produtos_lista.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos_lista.create');
    }

    public function store(Request $request)
    {
        ProdutoLista::create($request->all());
        return redirect()->route('produtos_lista.index')->with('success', 'Produto da lista criado com sucesso!');
    }

    public function show($id)
    {
        $produto = ProdutoLista::find($id);
        return view('produtos_lista.show', compact('produto'));
    }

    public function edit($id)
    {
        $produto = ProdutoLista::find($id);
        return view('produtos_lista.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        ProdutoLista::find($id)->update($request->all());
        return redirect()->route('produtos_lista.index')->with('success', 'Produto da lista atualizado com sucesso!');
    }

    public function destroy($id)
    {
        ProdutoLista::find($id)->delete();
        return redirect()->route('produtos_lista.index')->with('success', 'Produto da lista excluído com sucesso!');
    }

    
    

}

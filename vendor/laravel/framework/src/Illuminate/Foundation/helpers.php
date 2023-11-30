<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Adicione as regras de validação conforme necessário
        ]);

        Produto::create($request->all());

        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso.');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            // Adicione as regras de validação conforme necessário
        ]);

        $produto->update($request->all());

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso.');
    }
}

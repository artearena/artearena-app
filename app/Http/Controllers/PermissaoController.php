<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissao;

class PermissaoController extends Controller
{
    public function index()
    {
        $permissoes = Permissao::all();
        return view('pages.permissao.index', compact('permissoes'));
    }

    public function create()
    {
        // Lógica para carregar dados necessários, se necessário
        $telas = Tela::all(); // Substitua Tela pelo nome correto do seu modelo de tela
        return view('pages.permissao.create', compact('telas'));
    }

    public function store(Request $request)
    {
        // Lógica para armazenar nova permissão
        // Certifique-se de validar os dados do formulário
        // e de tratar a configuração_permissao de acordo com sua estrutura

        Permissao::create($request->all());

        return redirect()->route('pages.permissao.index')->with('success', 'Permissão criada com sucesso.');
    }

    public function edit($id)
    {
        $permissao = Permissao::findOrFail($id);
        // Lógica para carregar dados necessários, se necessário
        $telas = Tela::all(); // Substitua Tela pelo nome correto do seu modelo de tela
        return view('pages.permissao.edit', compact('permissao', 'telas'));
    }

    public function update(Request $request, $id)
    {
        // Lógica para atualizar permissão
        // Certifique-se de validar os dados do formulário
        // e de tratar a configuração_permissao de acordo com sua estrutura

        $permissao = Permissao::findOrFail($id);
        $permissao->update($request->all());

        return redirect()->route('pages.permissao.index')->with('success', 'Permissão atualizada com sucesso.');
    }

    public function destroy($id)
    {
        // Lógica para excluir permissão
        $permissao = Permissao::findOrFail($id);
        $permissao->delete();

        return redirect()->route('pages.permissao.index')->with('success', 'Permissão excluída com sucesso.');
    }
}

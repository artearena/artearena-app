<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissao;
use App\Models\Tela;

class PermissaoController extends Controller
{
    public function index()
    {
        $permissoes = Permissao::all();
        $telas = tela::all();

        return view('pages.permissao', compact('permissoes','telas'));
    }

    public function create()
    {
        $telas = Tela::all(); // Obtém todas as telas do banco de dados

        return view('pages.permissao.create', compact('telas'));
    }


    public function store(Request $request)
{
    // Validação dos campos do formulário
    $validatedData = $request->validate([
        'nome' => 'required',
        'configuracao_permissao' => 'nullable',
    ]);

    // Converter o array de IDs em uma string separada por vírgulas
    $configuracaoPermissao = implode(',', $validatedData['configuracao_permissao']);

    // Atualizar o campo 'configuracao_permissao' com a string de IDs
    $validatedData['configuracao_permissao'] = $configuracaoPermissao;

    // Criação da permissão no banco de dados
    $permissao = Permissao::create($validatedData);

    $telas = tela::all();
    $permissoes = Permissao::all();

    return view('pages.permissao', compact('telas','permissoes'));

}


    public function edit(Permissao $permissao)
    {
        return response()->json($permissao);
    }

    public function update(Request $request, Permissao $permissao)
    {
        // Validação dos campos do formulário
        $validatedData = $request->validate([
            'nome' => 'required',
            'configuracao_permissao' => 'nullable',
        ]);

        // Atualização da permissão no banco de dados
        $permissao->update($validatedData);

        return response()->json([
            'message' => 'Permissão atualizada com sucesso!',
            'permissao' => $permissao
        ], 200);
    }

    public function destroy(Permissao $permissao)
    {
        $permissao->delete();

        $telas = tela::all();
        $permissoes = Permissao::all();

        return view('pages.permissao', compact('telas','permissoes'));
    }
}

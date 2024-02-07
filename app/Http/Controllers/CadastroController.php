<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadastro;
use Illuminate\Support\Facades\DB;

class CadastroController extends Controller
{
    // Listar todos os registros
    public function index()
    {
        $registros = Cadastro::all();
        return view('pages.cadastro.index', compact('registros'));
    }

    public function getData()
    {
        $cadastros = Cadastro::all();

        return response()->json($cadastros);
    }
    
    public function consultarCadastros()
    {
        $cadastros = Cadastro::all();

        return view('pages.cadastro.consulta', compact('cadastros'));
    }
    
    // Exibir o formulário de criação
    public function create()
    {
        return view('pages.cadastro.create');
    }

    // Armazenar um novo registro
    public function store(Request $request)
    {
        try {
            if ($request->tipo_pessoa === 'juridica') {
                // Organize os campos para pessoa jurídica
                $request['email'] = $request['email_juridica'];
                $request['endereco'] = $request['endereco_juridica'];
                $request['numero'] = $request['numero_juridica'];
                $request['bairro'] = $request['bairro_juridica'];
                $request['cidade'] = $request['cidade_juridica'];
                $request['fone_fixo'] = $request['fone_fixo_juridica'];
                $request['cell'] = $request['cell_juridica'];
                $request['cep'] = $request['cep_juridica'];

                // Remova os campos originais da pessoa jurídica
                unset($request['email_juridica']);
                unset($request['endereco_juridica']);
                unset($request['numero_juridica']);
                unset($request['bairro_juridica']);
                unset($request['fone_fixo_juridica']);
                unset($request['cell_juridica']);
                unset($request['cep_juridica']);
            } else {
                // Organize os campos para pessoa física
                $request['email'] = $request['email_fisica'];
                $request['endereco'] = $request['endereco_fisica'];
                $request['numero'] = $request['numero_fisica'];
                $request['bairro'] = $request['bairro_fisica'];
                $request['cidade'] = $request['cidade_fisica'];
                $request['fone_fixo'] = $request['fone_fixo_fisica'];
                $request['cell'] = $request['cell_fisica'];
                $request['cep'] = $request['cep_fisica'];

                // Remova os campos originais da pessoa física
                unset($request['email_fisica']);
                unset($request['endereco_fisica']);
                unset($request['numero_fisica']);
                unset($request['bairro_fisica']);
                unset($request['fone_fixo_fisica']);
                unset($request['cell_fisica']);
                unset($request['cep_fisica']);
            }
            
            // Valide os dados do formulário com base nas regras definidas
            $request['id_cliente_pedido'] = $request->id_cliente_pedido;
            dd($request); 
            // Crie um novo registro de cadastro com os dados validados
            Cadastro::create($$request);

            $this->invalidateToken($request->token);

            return view('pages.cadastro.sucesso');

        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o Cadastro: ' . $e->getMessage()], 500);
        }
    }
    

    public function sucessocadastro()
    {
        return view('pages.cadastro.sucesso');
    }
    public function acessonegado()
    {
        return view('pages.cadastro.acessonegado');
    }
    public function invalidateToken($token)
    {
        // Remove o token do banco de dados
        DB::table('acesso_temporario')->where('token', $token)->delete();
    }

    // Exibir um registro específico
    public function show($pedidoId)
    {
        $cadastro = Cadastro::where('id_cliente_pedido', $pedidoId)->first();
        if ($cadastro) {
            return response()->json($cadastro);
        } else {
            return response()->json(['message' => 'Cadastro não encontrado'], 404);
        }
    }

    // Exibir o formulário de edição
    public function edit($id)
    {
        $registro = Cadastro::findOrFail($id);
        return view('pages.cadastro.edit', compact('registro'));
    }

    // Atualizar um registro específico
    public function update(Request $request, $id)
    {
        $registro = Cadastro::findOrFail($id);
        $dados = $request->all();

        // Verificar se o CNPJ ou RG já existe em outro cadastro
        $cnpjExistente = Cadastro::where('cnpj', $dados['cnpj_cpf'])->where('id', '!=', $id)->exists();
        $rgExistente = Cadastro::where('rg', $dados['ie_rg'])->where('id', '!=', $id)->exists();

        if ($cnpjExistente || $rgExistente) {
            // Cadastro já existe, mostrar uma pergunta para confirmar a atualização
            return redirect()->route('cadastro.consulta')->with('confirmacao', 'Cadastro já existe. Deseja realmente atualizar?');
        }

        // Atualizar o registro
        $registro->update($dados);

        return redirect()->route('cadastro.consulta')->with('success', 'Registro atualizado com sucesso!');
    }

    // Excluir um registro específico
    public function destroy($id)
    {
        $registro = Cadastro::findOrFail($id);
        $registro->delete();
        return redirect()->route('pages.cadastro.index')->with('success', 'Registro excluído com sucesso!');
    }
}

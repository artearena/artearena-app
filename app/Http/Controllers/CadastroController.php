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
        return view('pages.cadastro.index');
    }
    public function acessonegado()
    {
        return view('pages.cadastro.acessonegado');
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
            // Defina as regras de validação comuns para ambos os tipos de pessoa
            $commonRules = [
                'tipo_pessoa' => 'required|in:juridica,fisica',
                'cep' => 'required|string|regex:/^\d{5}-\d{3}$/',
                'endereco_cobranca' => 'nullable|string|max:255',
                'cep_cobranca' => 'nullable|string|regex:/^\d{5}-\d{3}$/',
                'endereco_entrega' => 'nullable|string|max:255',
                'cep_entrega' => 'nullable|string|regex:/^\d{5}-\d{3}$/',
                'numero' => 'nullable|string|max:255',
                'bairro' => 'nullable|string|max:255',
                'cidade' => 'nullable|string|max:255',
                'fone_fixo' => 'nullable|string|max:255',
                'cell' => 'nullable|string|max:255',
            ];

            // Validação para Pessoa Jurídica
            if ($request->tipo_pessoa === 'juridica') {
                $rules = [
                    'razao_social' => 'required|string|max:255',
                    'cnpj' => 'required|string|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/',
                    'ie' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                ];
            }
            // Validação para Pessoa Física
            else {
                $rules = [
                    'nome_completo' => 'required|string|max:255',
                    'rg' => 'required|string|max:255',
                    'cpf' => 'required|string|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                    'email' => 'required|email|max:255',
                ];
            }

            // Mescla as regras comuns com as regras específicas
            $rules = array_merge($commonRules, $rules);

            // Valide os dados do formulário com base nas regras definidas
            $validatedData = $request->validate($rules);

            // Adicione o id_cliente_pedido aos dados validados
            $validatedData['id_cliente_pedido'] = $request->id_cliente_pedido;

            // Crie um novo registro de cadastro com os dados validados
            Cadastro::create($validatedData);

            // Invalide o token
            $this->invalidateToken($request->token);

            // Redirecione para a rota de sucesso
            return redirect()->route('cadastro.sucesso');
        } catch (\Exception $e) {
            // Trate o erro de forma apropriada (exemplo: redirecionar com uma mensagem de erro)
            return redirect()->back()->with('error', 'Erro ao criar o Cadastro: ' . $e->getMessage());
        }
    }
    public function sucessocadastro()
    {
        return view('pages.cadastro.sucesso');
    }


    // Exibir um registro específico
    public function show($id)
    {
        $registro = Cadastro::findOrFail($id);
        return view('pages.cadastro.show', compact('registro'));
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
    public function invalidateToken($token)
    {
        // Remove o token do banco de dados
        DB::table('acesso_temporario')->where('token', $token)->delete();
    }
}

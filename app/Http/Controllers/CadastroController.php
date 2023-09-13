<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadastro;

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

            // Crie um novo registro de cadastro com os dados validados
            Cadastro::create($validatedData);

            return response()->json([
                'message' => 'Cadastro created successfully!',
                'cadastro' => $validatedData, // Retorna o objeto do pedido criado para atualização da tabela
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o Cadastro: ' . $e->getMessage()], 500);
        }
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
}

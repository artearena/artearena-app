<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orcamentos;
use App\Models\OrcamentoProdutos;
use App\Models\Produto;

class OrcamentosController extends Controller
{
    public function index(Request $request)
    {
        // Obtenha todos os orçamentos do banco de dados
        $orcamentos = Orcamentos::all();

        // Verifique se há uma consulta de pesquisa
        $search = $request->input('search');
        if ($search) {
            // Filtrar orçamentos com base na pesquisa
            $orcamentos = $orcamentos->filter(function ($orcamento) use ($search) {
                return stripos($orcamento->detalhes_orcamento, $search) !== false
                    || stripos($orcamento->nome_transportadora, $search) !== false
                    || stripos((string) $orcamento->valor_frete, $search) !== false;
            });
        }

        // Paginação com 10 resultados por página (você pode ajustar conforme necessário)
        $orcamentos = $orcamentos->paginate(10);

        return view('orcamentos.index', compact('orcamentos'));
    }

    public function orcamento(){
        $produtos = Produto::all();
        return view('pages.orcamento.gerarOrcamento', compact('produtos'));
    }

    public function salvarOrcamento(Request $request)
    {

        // Criação de um novo objeto de orçamento
        $orcamento = new Orcamentos();
        $orcamento->id_octa = $request->input('id_octa');
        $orcamento->detalhes_orcamento = $request->input('detalhes_orcamento');
        $orcamento->cep_frete = $request->input('cep_frete');
        $orcamento->endereco_frete = $request->input('endereco_frete');
        $orcamento->nome_transportadora = $request->input('nome_transportadora');
        $orcamento->valor_frete = $request->input('valor_frete');
        $orcamento->prazo_entrega = $request->input('prazo_entrega');
        $orcamento->data_prevista = $request->input('data_prevista');
        $orcamento->logo_frete = $request->input('logo_frete');

        // Salvar o orçamento no banco de dados
        $orcamento->save();


        // Salvar os produtos relacionados ao orçamento
        $produtos = $request->input('produtos');
        $produtosParaSalvar = [];
        foreach ($produtos as $produto) {
            $produtosParaSalvar[] = new OrcamentoProdutos([
                'nome_produto' => $produto['nome'],
                'valor_unitario' => $produto['valor'],
                'peso_unitario' => $produto['peso'],
                'quantidade' => $produto['quantidade'],
                'prazo_individual' => $produto['prazo_individual'],
            ]);
        }
        $orcamento->produtos()->saveMany($produtosParaSalvar);

        // Retornar uma resposta ou redirecionar para outra página
        return response()->json(['message' => 'Orçamento salvo com sucesso']);
    }
    public function consultarProdutos($orcamentoId)
    {
        $produtos = OrcamentoProdutos::where('id_orcamento', $orcamentoId)->get();

        return response()->json($produtos);
    }

    public function consultarOrcamentos($id)
    {
        // Consultar o orçamento pelo ID
        $orcamento = Orcamentos::where('id_octa', $id)->get();
        // Verificar se o orçamento foi encontrado
        if ($orcamento) {
            // Retornar o orçamento encontrado
            return response()->json($orcamento);
        } else {
            // Retornar uma resposta de erro caso o orçamento não seja encontrado
            return response()->json(['message' => 'Orçamento não encontrado'], 404);
        }
    }
    public function create()
    {
        // Retorna a view para criar um novo orçamento
        return view('pages.orcamento.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'id_octa' => 'required',
            'detalhes_orcamento' => 'required',
            // ... (Adicione as validações necessárias para os outros campos)
        ]);

        // Criação de um novo objeto de orçamento
        $orcamento = new Orcamentos($request->all());

        // Salvar o orçamento no banco de dados
        $orcamento->save();

        // Retornar uma resposta ou redirecionar para outra página
        return redirect()->route('orcamentos.index')->with('success', 'Orçamento criado com sucesso');
    }

    public function show($id)
    {
        // Consultar o orçamento pelo ID
        $orcamento = Orcamentos::findOrFail($id);

        // Retorna a view para exibir detalhes do orçamento
        return view('pages.orcamento.show', compact('orcamento'));
    }

    public function edit($id)
    {
        // Consultar o orçamento pelo ID
        $orcamento = Orcamentos::findOrFail($id);

        // Retorna a view para editar o orçamento
        return view('pages.orcamento.edit', compact('orcamento'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados do formulário
        $request->validate([
            'id_octa' => 'required',
            'detalhes_orcamento' => 'required',
            // ... (Adicione as validações necessárias para os outros campos)
        ]);

        // Consultar o orçamento pelo ID
        $orcamento = Orcamentos::findOrFail($id);

        // Atualizar os dados do orçamento
        $orcamento->update($request->all());

        // Retornar uma resposta ou redirecionar para outra página
        return redirect()->route('orcamentos.index')->with('success', 'Orçamento atualizado com sucesso');
    }

    public function destroy($id)
    {
        // Consultar o orçamento pelo ID e excluir
        Orcamentos::findOrFail($id)->delete();

        // Retornar uma resposta ou redirecionar para outra página
        return redirect()->route('orcamentos.index')->with('success', 'Orçamento excluído com sucesso');
    }
}
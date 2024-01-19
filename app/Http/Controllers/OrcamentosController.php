<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orcamentos;
use App\Models\OrcamentoProdutos;
use App\Models\Produto;

class OrcamentosController extends Controller
{
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
}
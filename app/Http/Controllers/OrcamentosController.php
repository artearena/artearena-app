<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orcamentos;
use App\Models\OrcamentoProdutos;

class OrcamentosController extends Controller
{
    public function salvarOrcamento(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'id' => 'required',
            'detalhes_orcamento' => 'required',
            // Outras validações para os campos necessários
        ]);

        // Criação de um novo objeto de orçamento
        $orcamento = new Orcamentos();
        $orcamento->id = $request->input('id');
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

    public function consultarOrcamento($id)
    {
        // Consultar o orçamento pelo ID
        $orcamento = Orcamentos::find($id);

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
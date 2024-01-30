<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PedidoListView;
use Illuminate\Http\Request;
use App\Models\PedidoInterno;
use App\Models\Usuario;
use App\Models\Orcamentos;
use App\Models\ListaUniforme;
use App\Models\ProdutoPedido;
use App\Models\Pedido;
use App\Models\AcessoTemporario;

class HomologarPedido extends Controller
{

    public function index()
    {
        $pedidos = PedidoInterno::all();

        // Verifica se cada pedido tem um link criado na tabela acesso_temporario
        $linkCriadoPorPedido = [];
        foreach ($pedidos as $pedido) {
            $linkCriadoPorPedido[$pedido->id] = AcessoTemporario::where('pedido_id', $pedido->id)->exists();
        }

        // Verifica se cada pedido tem uma lista uniforme criada
        $listaUniformePorPedido = [];
        foreach ($pedidos as $pedido) {
            $listaUniformePorPedido[$pedido->id] = ListaUniforme::where('id_pedido', $pedido->id)->exists();
        }

        return view('pages.pedidoInterno.index', compact('pedidos', 'linkCriadoPorPedido', 'listaUniformePorPedido'));
    }
    

    public function getProdutosDoPedido($pedidoId)
    {
        $produtos = ProdutoPedido::where('pedido_id', $pedidoId)->get();
    
        return response()->json($produtos);
    }

    public function update(Request $request, $pedidoId, $produtoId)
    {
        $produto = ProdutoPedido::where('pedido_id', $pedidoId)->findOrFail($produtoId);
        $campo = $request->campo;
        $produto->$campo = $request->valor;
        $produto->save();

        return response()->json(['mensagem' => 'Produto atualizado com sucesso!']);
    }

    public function criarPedidoOrcamento($id)
    {
        $vendedores = Usuario::whereIn('permissoes', [17, 18])->pluck('nome_usuario');
        $orcamento = Orcamentos::where('id', $id)->first();        
        return view('pages.pedidoInterno.criarPedidoOrcamento', compact('orcamento', 'id', 'vendedores'));
    }

    public function store(Request $request)
    {
        // Validação dos dados do pedido
        $request->validate([
            'cliente_id' => 'nullable',
            'vendedor' => 'nullable',
            'forma_pagamento' => 'nullable',
            'transportadora' => 'nullable',
            'valor_frete' => 'nullable',
            'observacao' => 'nullable',
            'marcador' => 'nullable',
            'data_venda' => 'nullable',
            'produtos' => 'nullable|array',
            'produtos.*.produto_nome' => 'nullable',
            'produtos.*.quantidade' => 'nullable',
            'produtos.*.preco_unitario' => 'nullable',
        ]);

        // Criação do pedido interno
        $pedidoInterno = PedidoInterno::create($request->all());

        // Adicionar os produtos ao pedido interno
        if ($request->has('produtos')) {
            foreach ($request->produtos as $produto) {
                $pedidoInterno->produtos()->create($produto);
            }
        }

        // Verificar os produtos
        if ($request->has('produtos')) {
            foreach ($request->produtos as $produto) {
/*                 $this->verificarProduto($produto['produto_nome'], $pedidoInterno->id);
 */            }
        }

        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Pedido interno criado com sucesso'], 201);
    }

    public function verificarProduto($produtoNome, $pedidoId)
    {
        $palavrasChave = [
            'uniforme',
            'balaclava',
            'calcao',
            'camisa',
            'camisao',
            'camiseta',
            'colete',
            'meiao',
            'samba',
            'abada',
            'roupao',
            'corte',
            'chinelo',
            'shorts'
        ];

        $produtoNome = mb_strtolower($produtoNome, 'UTF-8');

        foreach ($palavrasChave as $palavraChave) {
            $palavraChave = mb_strtolower($palavraChave, 'UTF-8');

            if (strpos($produtoNome, $palavraChave) !== false) {
                $dataCriacao = date('Y-m-d');
                ListaUniforme::create([
                    'id_pedido' => $pedidoId,
                    'data_criacao' => $dataCriacao
                ]);
                break;
            }
        }
    }
    public function atualizarCamisaProduto($pedidoId, $produtoId, Request $request)
    {
        $produto = ProdutoPedido::find($produtoId);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $produto->update(['camisa' => $request->input('camisa')]);

        return response()->json(['message' => 'Camisa do produto atualizada com sucesso']);
    }

    public function atualizarCalcaoProduto($pedidoId, $produtoId, Request $request)
    {
        $produto = ProdutoPedido::find($produtoId);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $produto->update(['calcao' => $request->input('calcao')]);

        return response()->json(['message' => 'Calção do produto atualizado com sucesso']);
    }

}
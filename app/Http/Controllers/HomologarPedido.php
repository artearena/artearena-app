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

class HomologarPedido extends Controller
{
    public function index()
    {
        $pedidos = PedidoInterno::all();
        $listaProdutos = PedidoListView::all();
        return view('pages.pedidoInterno.index', compact('pedidos', 'listaProdutos'));
    }

    public function getProdutosDoPedido($pedidoId)
    {
        $produtos = ProdutoPedido::where('pedido_id', $pedidoId)->get();
    
        return response()->json($produtos);
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
                $this->verificarProduto($produto['produto_nome'], $pedidoInterno->id);
            }
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
}
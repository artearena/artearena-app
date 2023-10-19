<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PedidoInterno;

class HomologarPedido extends Controller
{
    public function index()
    {
        $pedidos = PedidoInterno::all();

        return view('pages.pedidoInterno.index', compact('pedidos'));
    }
    
    public function store(Request $request)
    {
        // Validação dos dados do pedido
        $request->validate([
            'cliente_id' => 'nullable',
            'Vendedor' => 'nullable',
            'forma_pagamento' => 'nullable',
            'transportadora' => 'nullable',
            'valor_frete' => 'nullable',
            'observacao' => 'nullable',
            'marcador' => 'nullable',
            'data_venda' => 'nullable',
            'produtos' => 'nullable|array',
            'produtos.*.nome' => 'nullable',
            'produtos.*.quantidade' => 'nullable',
            'produtos.*.preco_unitario' => 'nullable',
        ]);

        // Criação do pedido interno
        $pedidoInterno = PedidoInterno::create($request->all());

        // Adicionar os produtos ao pedido interno
        if ($request->has('produtos')) {
            foreach ($request->produtos as $produto) {
                dd($produto);
                $pedidoInterno->produtos()->create($produto);
            }
        }
        dd($request->produtos);
        
        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Pedido interno criado com sucesso'], 201);
    }
}
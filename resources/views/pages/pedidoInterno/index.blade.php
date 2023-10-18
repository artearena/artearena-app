@extends('layout.main')
@section('title')
Tabela de Pedidos
@endsection
@section('style')
@endsection
@section('content')
<div class="container">
  <h1>Tabela de Pedidos</h1>
  <table class="table mt-4">
    <thead>
      <tr>
        <th>ID</th>
        <th>Cliente ID</th>
        <th>Vendedor</th>
        <th>Produtos</th>
        <th>Forma de Pagamento</th>
        <th>Transportadora</th>
        <th>Valor do Frete</th>
        <th>Observação</th>
        <th>Marcador</th>
        <th>Data da Venda</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pedidos as $pedido)
      <tr>
        <td>{{ $pedido->id }}</td>
        <td>{{ $pedido->cliente_id }}</td>
        <td>{{ $pedido->Vendedor }}</td>
        <td>
          <ul>
            @foreach($pedido->produtos as $produto)
            <li>{{ $produto->produto_nome }} (Quantidade: {{ $produto->quantidade }}, Preço Unitário: {{ $produto->preco_unitario }})</li>
            @endforeach
          </ul>
        </td>
        <td>{{ $pedido->forma_pagamento }}</td>
        <td>{{ $pedido->transportadora }}</td>
        <td>{{ $pedido->valor_frete }}</td>
        <td>{{ $pedido->observacao }}</td>
        <td>{{ $pedido->marcador }}</td>
        <td>{{ $pedido->data_venda }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
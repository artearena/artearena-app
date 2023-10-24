@extends('layout.main')
@section('title', 'Tabela de Pedidos')
@section('style')
<style>
  .table {
    text-align: center;
    border: 1px solid #ccc;
  }
  .table th,
  .table td {
    border: 1px solid #ccc;
  }
  .table th {
    text-align: center;
  }
</style>
@endsection
@section('content')
<div class="container">
  <h1>Tabela de Pedidos</h1>
  <div class="mb-3">
    <button class="btn btn-primary" id="btnConsultarListaUniforme">Consultar lista uniforme</button>
  </div>
  <table class="table mt-4 custom-table">
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
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      @isset($pedidos)
      @foreach($pedidos as $pedido)
      <tr class="pedido-row" data-pedido-id="{{ $pedido->id }}">
        <td>{{ $pedido->id }}</td>
        <td>{{ $pedido->cliente_id }}</td>
        <td>{{ $pedido->Vendedor }}</td>
        <td>
          <button class="btn btn-link btn-expand-produtos">Expandir</button>
        </td>
        <td>{{ $pedido->forma_pagamento }}</td>
        <td>{{ $pedido->transportadora }}</td>
        <td>{{ $pedido->valor_frete }}</td>
        <td>{{ $pedido->observacao }}</td>
        <td>{{ $pedido->marcador }}</td>
        <td>{{ $pedido->data_venda }}</td>
        <td>
          <button class="btn btn-success btn-confirmar-pedido">Confirmar</button>
          <!-- <button class="btn btn-danger btn-rejeitar-pedido">Rejeitar</button> -->
        </td>
      </tr>
      <tr class="produtos-row" style="display: none;">
        <td colspan="11">
          <ul>
            @foreach($pedido->produtos ?? [] as $produto)
                <li>{{ $produto->produto_nome }} (Quantidade: {{ $produto->quantidade }}, Preço Unitário: {{ $produto->preco_unitario }})</li>
            @endforeach
          </ul>
        </td>
      </tr>
      @endforeach
      @endisset
    </tbody>
  </table>
</div>
@endsection
@section('script')
<script>
  $(document).ready(function() {
    $(".btn-expand-produtos").click(function() {
      var row = $(this).closest(".pedido-row");
      var produtosRow = row.next(".produtos-row");
      produtosRow.toggle();
    });
    $(".btn-confirmar-pedido").click(function() {
      // Obter o ID do pedido
      var pedidoId = $(this).closest(".pedido-row").data("pedido-id");
      // Fazer algo com o ID do pedido, como enviar para o servidor
      console.log("Confirmar pedido ID:", pedidoId);
    });
    $(".btn-rejeitar-pedido").click(function() {
      // Obter o ID do pedido
      var pedidoId = $(this).closest(".pedido-row").data("pedido-id");
      // Fazer algo com o ID do pedido, como enviar para o servidor
      console.log("Rejeitar pedido ID:", pedidoId);
    });
    $("#btnConsultarListaUniforme").click(function() {
      // Fazer algo quando o botão "Consultar lista uniforme" for clicado
      console.log("Consultar lista uniforme");
    });
  });
</script>
@endsection
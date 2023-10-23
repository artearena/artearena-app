@extends('layout.main')
@section('title')
Tabela de Pedidos
@endsection
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
    function salvarPedido() {
  // Obter os valores do formulário
  var clienteId = $("#cliente_id").val();
  var vendedor = $("#vendedor").val();
  var formaPagamento = $("#forma_pagamento").val();
  var transportadora = $("#transportadora").val();
  var valorFrete = $("#valor_frete").val();
  var observacao = $("#observacao").val();
  var marcador = $("#marcador").val();
  var dataVenda = $("#data_venda").val();
  // Obter os produtos da tabela
  var produtos = [];
  $("#produtosTableBody tr").each(function() {
    var nomeProduto = $(this).find("td:nth-child(1)").text();
    var quantidade = $(this).find("td:nth-child(2)").text();
    var precoUnitario = $(this).find("td:nth-child(3)").text();
    produtos.push({
      produto_nome: nomeProduto,
      quantidade: quantidade,
      preco_unitario: precoUnitario
    });
  });
  // Criar um objeto com os dados do pedido e produtos
  var pedido = {
    cliente_id: clienteId,
    vendedor: vendedor,
    forma_pagamento: formaPagamento,
    transportadora: transportadora,
    valor_frete: valorFrete,
    observacao: observacao,
    marcador: marcador,
    data_venda: dataVenda,
    produtos: produtos,
    _token: "{{ csrf_token() }}"
  };
  // Fazer a requisição ao servidor
  $.ajax({
    url: '/pedidoInterno/criar', // Rota para a função de salvar no servidor
    type: 'POST',
    data: pedido,
    success: function(response) {
      console.log(response); // Exibir a resposta do servidor no console
      // Realizar outras ações após o sucesso da requisição
    },
    error: function(error) {
      console.log(error); // Exibir o erro no console, se houver
      // Realizar ações de tratamento de erro, se necessário
    }
  });
}
  });
</script>
@endsection
@extends('layout.main')
@section('title', 'Tabela de Pedidos')
@section('style')
<style>
  .table {
    border: 1px solid #ccc;
  }
  .table th,
  .table td {
    border: 1px solid #ccc;
  }
  .table th {
    text-align: center;
  }
  #observacao {
    overflow: hidden; /* Oculta o overflow */
    overflow-y: auto; /* Adiciona barra de rolagem vertical apenas quando necessário */
    white-space: pre-wrap; /* Permite quebras de linha */
    max-height: 100px; /* Altura máxima do campo */
  }
  .container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
  }
</style>
@endsection
@section('content')
<div class="container">
  <h1>Tabela de Pedidos</h1>
  <table id="pedidosTable" class="table mt-4 custom-table">
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
        <td id="observacao">{{ $pedido->observacao }}</td>
        <td>{{ $pedido->marcador }}</td>
        <td>{{ $pedido->data_venda }}</td>
        <td>
          <button class="btn btn-success btn-confirmar-pedido">
            <i class="fas fa-check"></i>
          </button>        
          <button class="btn btn-primary btn-consultar-lista-uniforme" data-toggle="modal" data-target="#modalListaUniforme" data-pedido-id="{{ $pedido->id }}">
            <i class="fas fa-tshirt"></i>
          </button>
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
<!-- Modal Lista Uniforme -->
<div class="modal fade" id="modalListaUniforme" tabindex="-1" role="dialog" aria-labelledby="modalListaUniformeLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalListaUniformeLabel">Lista Uniforme</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formListaUniforme">
          <!-- Campos para editar a lista de uniformes -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSalvarListaUniforme">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
document.addEventListener("DOMContentLoaded", function() {
    $("#pedidosTable").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
      }
    });

    $(".btn-expand-produtos").click(function() {
      var row = $(this).closest(".pedido-row");
      var produtosRow = row.next(".produtos-row");
      produtosRow.toggle();
    });

    $(".btn-confirmar-pedido").click(function() {
      var pedidoId = $(this).closest(".pedido-row").data("pedido-id");
      console.log("Confirmar pedido ID:", pedidoId);
    });

    $(".btn-consultar-lista-uniforme").click(function() {
      var pedidoId = $(this).data("pedido-id");
      console.log("Consultar lista uniforme para o pedido ID:", pedidoId);
      var form = $("#formListaUniforme");
      form.empty();
      form.append('<div class="form-group"><label for="uniforme1">Uniforme 1:</label><input type="text" class="form-control" id="uniforme1" name="uniforme1"></div>');
      form.append('<div class="form-group"><label for="uniforme2">Uniforme 2:</label><input type="text" class="form-control" id="uniforme2" name="uniforme2"></div>');
    });

    $("#btnSalvarListaUniforme").click(function() {
      var uniforme1 = $("#uniforme1").val();
      var uniforme2 = $("#uniforme2").val();
      console.log("Salvar lista uniforme:", uniforme1, uniforme2);
    });
  });
</script>
@endsection
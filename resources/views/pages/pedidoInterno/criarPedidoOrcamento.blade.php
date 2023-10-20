@extends('layout.main')
@section('title')
  Criar pedido interno
@endsection
@section('style')
@endsection
@section('content')
  <div class="container">
    <!-- Conteúdo da tela de criação de pedido interno -->
    <h1>Criar pedido interno</h1>
    <form id="pedidoForm">
      <div class="form-group">
        <label for="cliente_id">ID do Cliente:</label>
        <input type="text" class="form-control" id="cliente_id" name="cliente_id" value="14099">
      </div>
      <div class="form-group">
        <label for="vendedor">Vendedor:</label>
        <input type="text" class="form-control" id="vendedor" name="vendedor" value="">
      </div>
      <div class="form-group">
        <label for="forma_pagamento">Forma de Pagamento:</label>
        <input type="text" class="form-control" id="forma_pagamento" name="forma_pagamento" value="">
      </div>
      <div class="form-group">
        <label for="transportadora">Transportadora:</label>
        <input type="text" class="form-control" id="transportadora" name="transportadora" value="Uello">
      </div>
      <div class="form-group">
        <label for="valor_frete">Valor do Frete:</label>
        <input type="text" class="form-control" id="valor_frete" name="valor_frete" value="22">
      </div>
      <div class="form-group">
        <label for="observacao">Observação:</label>
        <input type="text" class="form-control" id="observacao" name="observacao" value="">
      </div>
      <div class="form-group">
        <label for="marcador">Marcador:</label>
        <input type="text" class="form-control" id="marcador" name="marcador" value="">
      </div>
      <div class="form-group">
        <label for="data_venda">Data da Venda:</label>
        <input type="text" class="form-control" id="data_venda" name="data_venda" placeholder="mm/dd/yyyy --:-- --">
      </div>
      <!-- Tabela para exibir os produtos adicionados -->
      <table class="table mt-4">
        <thead>
          <tr>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody id="produtosTableBody">

        </tbody>
      </table>
    </form>
  </div>
@endsection
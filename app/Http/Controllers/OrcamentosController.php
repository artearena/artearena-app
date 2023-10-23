@extends('layout.main')
@section('title')
  Criar pedido interno
@endsection
@section('style')
<style>
  .btn-criar-pedido {
    float: right;
    background-color: green;
    color: white;
  }
</style>
@endsection
@section('content')
  <div class="container">
    <!-- Conteúdo da tela de criação de pedido interno -->
    <h1>Criar pedido interno</h1>
    <form id="pedidoForm">
      <!-- Restante dos campos do formulário -->

      <!-- Tabela para exibir os produtos adicionados -->
      <table class="table mt-4">
        <!-- Cabeçalho da tabela -->
        <thead>
          <tr>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
          </tr>
        </thead>
        <tbody id="produtosTableBody">
          <!-- Linhas da tabela com os produtos -->
          @foreach ($orcamento->produtos as $produto)
            <tr>
              <td>{{ $produto->nome_produto }}</td>
              <td>{{ $produto->quantidade }}</td>
              <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Botão de criar pedido -->
      <button type="submit" class="btn btn-primary btn-criar-pedido">Criar Pedido</button>
    </form>
  </div>
@endsection
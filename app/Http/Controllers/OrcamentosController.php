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

  <script>
    // Evento de envio do formulário
    document.getElementById('pedidoForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Impede o envio do formulário padrão

      // Realiza a requisição AJAX para salvar o pedido
      fetch(this.action, {
        method: this.method,
        body: new FormData(this)
      })
      .then(response => response.json())
      .then(data => {
        // Lógica para lidar com a resposta da requisição
        console.log(data);
      })
      .catch(error => {
        console.error(error);
      });
    });
  </script>
@endsection
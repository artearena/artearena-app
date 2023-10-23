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
        <input type="text" class="form-control" id="cliente_id" name="cliente_id" value="{{ $orcamento->id_octa }}">
      </div>
      <div class="form-group">
        <label for="vendedor">Vendedor:</label>
        <select class="form-control" id="vendedor" name="vendedor">
          @foreach ($vendedores as $vendedor)
            <option value="{{ $vendedor }}">{{ $vendedor }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="forma_pagamento">Forma de Pagamento:</label>
        <select class="form-control" id="forma_pagamento" name="forma_pagamento">
          <option value="pix">Pix</option>
          <option value="boleto">Boleto</option>
          <option value="cartao_credito">Cartão de Crédito</option>
          <option value="cartao_debito">Cartão de Débito</option>
          <option value="transferencia">Transferência</option>
          <option value="deposito">Depósito</option>
          <option value="duplicata_faturado">Duplicata Faturado</option>
          <option value="multiplas">Múltiplas</option>
        </select>
      </div>
      <div class="form-group">
        <label for="transportadora">Transportadora:</label>
        <input type="text" class="form-control" id="transportadora" name="transportadora" value="{{ $orcamento->nome_transportadora }}">
      </div>
      <div class="form-group">
        <label for="valor_frete">Valor do Frete:</label>
        <input type="text" class="form-control" id="valor_frete" name="valor_frete" value="{{ $orcamento->valor_frete }}">
      </div>
      <div class="form-group">
        <label for="observacao">Observação:</label>
        <textarea class="form-control" id="observacao" name="observacao">{{ $orcamento->detalhes_orcamento }}</textarea>
      </div>
      <div class="form-group">
        <label for="marcador">Marcador:</label>
        <input type="text" class="form-control" id="marcador" name="marcador" value="">
      </div>
      <div class="form-group">
        <label for="data_venda">Data da Venda:</label>
        <input type="datetime-local" class="form-control" id="data_venda" name="data_venda">
      </div>
      <!-- Tabela para exibir os produtos adicionados -->
      <table class="table mt-4">
        <thead>
          <tr>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
          </tr>
        </thead>
        <tbody id="produtosTableBody">
          @foreach ($orcamento->produtos as $produto)
            <tr>
              <td>{{ $produto->nome_produto }}</td>
              <td>{{ $produto->quantidade }}</td>
              <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <button type="submit" class="btn btn-primary">Criar Pedido</button>
    </form>
  </div>
@endsection

@section('script')
<script>
  $(document).ready(function() {
    $("#pedidoForm").submit(function(event) {
      event.preventDefault(); // Impede o envio padrão do formulário

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

      // Fazer a requisição AJAX para salvar o pedido
      $.ajax({
        url: "{{ route('pedidoInterno.salvar') }}",
        type: "POST",
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
    });
  });
</script>
@endsection
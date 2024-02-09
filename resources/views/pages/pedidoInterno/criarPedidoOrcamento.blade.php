@extends('layout.main')
@section('title')
  Criar pedido interno
@endsection
@section('style')
<style> 
    #observacao{
      min-height: 200px;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/4.0.2/jquery.maskMoney.min.js"></script> <!-- Inclua o arquivo do jQuery MaskMoney -->

<script>

document.addEventListener("DOMContentLoaded", function() {

    $('.select2').select2();

  document.getElementById('btnCriarPedido').addEventListener('click', function(event) {
    event.preventDefault(); // Impede o comportamento padrão do botão
    var produtos = [];
    var rows = document.querySelectorAll("#produtosTableBody tr");
    rows.forEach(function(row) {
      var nomeProduto = row.querySelector('td:nth-child(1)').innerText;
      var quantidade = row.querySelector('td:nth-child(2)').innerText;
      var precoUnitario = row.querySelector('td:nth-child(3)').innerText;
      // Tratar o campo "precoUnitario" para remover o símbolo de moeda e a formatação
      precoUnitario = precoUnitario.replace("R$ ", "").replace(".", "").replace(",", ".");
      produtos.push({
        produto_nome: nomeProduto,
        quantidade: quantidade,
        preco_unitario: precoUnitario
      });
    });
    var clienteId = document.getElementById("cliente_id").value;
    var vendedor = document.getElementById("vendedor").value;
    var formaPagamento = document.getElementById("forma_pagamento").value;
    var transportadora = document.getElementById("transportadora").value;
    var valorFrete = $('#valor_frete').maskMoney('unmasked')[0]; // Valor do frete sem a máscara
    var valorDesconto = $('#valor_desconto').maskMoney('unmasked')[0]; // Valor do desconto sem a máscara
    var valorAntecipacao = $('#valor_antecipacao').maskMoney('unmasked')[0]; // Valor da antecipação sem a máscara
    var observacao = document.getElementById("observacao").value;
    var marcador = Array.from(document.getElementById("marcador").selectedOptions).map(option => option.value);
    var dataVenda = document.getElementById("data_venda").value;
    var pedido = {
      cliente_id: clienteId,
      Vendedor: vendedor,
      forma_pagamento: formaPagamento,
      transportadora: transportadora,
      valor_frete: valorFrete,
      valor_desconto: valorDesconto,
      valor_antecipacao: valorAntecipacao,
      observacao: observacao,
      marcador: marcador,
      data_venda: dataVenda,
      produtos: produtos,
      id_orcamento: "{{ $orcamento->id_octa }}",
      _token: "{{ csrf_token() }}"
    };
    $.ajax({
      url: "/pedidoInterno/criar",
      type: "POST",
      data: JSON.stringify(pedido),
      contentType: "application/json",
      success: function(data) {
          Swal.fire({
              title: "Sucesso!",
              text: "Pedido salvo com sucesso.",
              icon: "success",
              confirmButtonText: "OK"
          }).then((result) => {
              // Redirecionar para a rota 'pedidoInterno'
              window.location.href = "{{ route('pedidoInterno') }}";
          });
          console.log(data);
          // Realizar outras ações após o sucesso da requisição
      },
      error: function(error) {
        Swal.fire({
          title: "Erro!",
          text: "Ocorreu um erro ao salvar o pedido.",
          icon: "error",
          confirmButtonText: "OK"
        });
        console.log(error);
        // Realizar ações de tratamento de erro, se necessário
      }
    });
  });

  // Aplicar a máscara monetária aos campos de frete, antecipação e desconto
  $('#valor_frete, #valor_desconto, #valor_antecipacao').maskMoney({
    prefix: 'R$ ', // Adiciona o símbolo de moeda
    thousands: '.', // Usa ponto para milhares
    decimal: ',' // Usa vírgula para decimais
  });
});
</script>
@endsection

@section('content')
  <div class="container">
    <!-- Conteúdo da tela de criação de pedido interno -->
    <h1>Criar pedido interno</h1>
    <form id="pedidoForm">
      @csrf
      <div class="form-group">
        <label for="cliente_id">ID do Cliente:</label>
        <input type="text" class="form-control" id="cliente_id" name="cliente_id" value="{{ $orcamento->id_octa }}">
      </div>
      <div class="form-group">
        <label for="transportadora">Transportadora:</label>
        <input type="text" class="form-control" id="transportadora" name="transportadora" value="{{ $orcamento->nome_transportadora }}">
      </div>
      <div class="form-group">
        <label for="valor_frete">Valor do Frete:</label>
        <input type="text" class="form-control" id="valor_frete" name="valor_frete">
      </div>
      
      <div class="form-group">
        <label for="observacao">Observação:</label>
        <textarea class="form-control" id="observacao" name="observacao">{{ $orcamento->detalhes_orcamento }}</textarea>
      </div>
      <div class="form-group">
        <label for="marcador">Marcador:</label>
        <select class="form-control select2" id="marcador" name="marcador[]" multiple>
          <option value="">Selecione um marcador</option>
          <!-- Opções do marcador -->
        </select>
      </div>
      <div class="form-group">
        <label for="data_venda">Data da Venda:</label>
        <input type="datetime-local" class="form-control" id="data_venda" name="data_venda" value="{{ date('Y-m-d\TH:i') }}">
      </div>
      <div class="form-group">
        <label for="vendedor">Vendedor:</label>
        <select class="form-control" id="vendedor" name="vendedor">
          <option value="">Selecione um vendedor</option>
          <!-- Opções do vendedor -->
        </select>
      </div>
      <div class="form-group">
        <label for="forma_pagamento">Forma de Pagamento:</label>
        <select class="form-control" id="forma_pagamento" name="forma_pagamento">
          <option value="">Selecione uma forma de pagamento</option>
          <!-- Opções de forma de pagamento -->
        </select>
      </div>
      <div class="form-group">
        <label for="valor_desconto">Valor do desconto:</label>
        <input type="text" class="form-control" id="valor_desconto" name="valor_desconto">
      </div>
      <div class="form-group">
        <label for="valor_antecipacao">Taxa de antecipação:</label>
        <input type="text" class="form-control" id="valor_antecipacao" name="valor_antecipacao">
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
      <button id="btnCriarPedido" type="button" class="btn btn-primary">Salvar Pedido</button>
    </form>
  </div>
@endsection

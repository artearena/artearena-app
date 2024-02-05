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
<script src="../../js/pedidoInterno.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function() {,

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
    var valorFrete = document.getElementById("valor_frete").value;
    var observacao = document.getElementById("observacao").value;
    var marcador = document.getElementById("marcador").value;
    var dataVenda = document.getElementById("data_venda").value;
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
        <label for="vendedor">Vendedor:</label>
        <select class="form-control" id="vendedor" name="vendedor">
          <option value="">Selecione um vendedor</option>
          @foreach ($vendedores as $vendedor)
            <option value="{{ $vendedor }}">{{ $vendedor }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="forma_pagamento">Forma de Pagamento:</label>
        <select class="form-control" id="forma_pagamento" name="forma_pagamento" multiple>
          <option value="Pix">Pix</option>
          <option value="Dinheiro">Dinherio</option>
          <option value="Boleto">Boleto</option>
          <option value="Cartão de Crédito">Cartão de Crédito</option>
          <option value="Cartão de Débito">Cartão de Débito</option>
          <option value="Transferência">Transferência</option>
          <option value="Depósito">Depósito</option>
          <option value="Duplicata Faturado">Duplicata Faturado</option>
          <option value="Múltiplas">Múltiplas</option>
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
        <select class="form-control select2" id="marcador" name="marcador[]" multiple>
          <option value="">Selecione um marcador</option>
          <option value="ADM - TERCEIRIZADO EM IMPRESSÃO">ADM - TERCEIRIZADO EM IMPRESSÃO</option>
          <option value="ADM - TERCEIRIZADO EM PRODUÇÃO">ADM - TERCEIRIZADO EM PRODUÇÃO</option>
          <option value="ADM - TERCEIRZADO">ADM - TERCEIRZADO</option>
          <option value="BACKOFFICE">BACKOFFICE</option>
          <option value="BACKOFFICE - AGUARDANDO APROVAÇÃO DE ESBOÇO">BACKOFFICE - AGUARDANDO APROVAÇÃO DE ESBOÇO</option>
          <option value="BACKOFFICE - AGUARDANDO ENVIO DE ARTE">BACKOFFICE - AGUARDANDO ENVIO DE ARTE</option>
          <option value="BACKOFFICE - AGUARDANDO RESTANTE DO PAGAMENTO">BACKOFFICE - AGUARDANDO RESTANTE DO PAGAMENTO</option>
          <option value="BACKOFFICE - ANTECIPAÇÃO">BACKOFFICE - ANTECIPAÇÃO</option>
          <option value="BACKOFFICE - CONFIRMAÇÃO DE PAGAMENTO">BACKOFFICE - CONFIRMAÇÃO DE PAGAMENTO</option>
          <option value="BACKOFFICE - CONTRATAR FRETE">BACKOFFICE - CONTRATAR FRETE</option>
          <option value="BACKOFFICE - FATURADO">BACKOFFICE - FATURADO</option>
          <option value="BACKOFFICE - PENDENTE ARTE FINAL">BACKOFFICE - PENDENTE ARTE FINAL</option>
          <option value="BACKOFFICE - PROBLEMA NO PAGAMENTO">BACKOFFICE - PROBLEMA NO PAGAMENTO</option>
          <option value="Conflito de endereço">Conflito de endereço</option>
          <option value="DESIGN - ARTE FINAL OK">DESIGN - ARTE FINAL OK</option>
          <option value="Devolvido">Devolvido</option>
          <option value="EXPEDIÇÃO - AGUARDANDO FINANCEIRO">EXPEDIÇÃO - AGUARDANDO FINANCEIRO</option>
          <option value="EXPEDIÇÃO - RETIRADA DISPONÍVEL">EXPEDIÇÃO - RETIRADA DISPONÍVEL</option>
          <option value="IMPRESSÃO - AGUARDANDO IMPRESSÃO">IMPRESSÃO - AGUARDANDO IMPRESSÃO</option>
          <option value="IMPRESSÃO - EM IMPRESSÃO">IMPRESSÃO - EM IMPRESSÃO</option>
          <option value="IMPRESSÃO - FICHA IMPRESSA">IMPRESSÃO - FICHA IMPRESSA</option>
          <option value="IMPRESSÃO - OK">IMPRESSÃO - OK</option>
          <option value="PRODUÇÃO - CALANDRA">PRODUÇÃO - CALANDRA</option>
          <option value="PRODUÇÃO - CONFERENCIA OK">PRODUÇÃO - CONFERENCIA OK</option>
          <option value="PRODUÇÃO - COSTURA">PRODUÇÃO - COSTURA</option>
          <option value="PRODUÇÃO - PRENS">PRODUÇÃO - PRENS</option>
        </select>
      </div>
      <div class="form-group">
        <label for="data_venda">Data da Venda:</label>
        <input type="datetime-local" class="form-control" id="data_venda" name="data_venda" value="{{ date('Y-m-d\TH:i') }}">
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

@extends('layout.main')
@section('title')
  Gerar Orçamento
@endsection
@section('style')
<style>
    .form-group {
        margin-bottom: 10px;
    }
    #cep-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    }
    #transp-title {
        display: flex;
        justify-content: center;
      }
    .form-group{
        width: 100%;
        height: auto;
    }
    #calcularFrete {
    width: 30%;
    height: auto;
    margin-top: 10px;
    }
    .cards-container {
        display: flex;
        flex-wrap: wrap;
    }

    .card {
        width: calc(25% - 20px);
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .card.selected {
        border-color: blue;
    }

    .card img {
        max-width: 20%;
        height: auto;
        margin-bottom: 1em;
    }
    .container {
           max-width: 100%;
    }

    .details-container h4 {
        margin-bottom: 10px;
    }

    #botaoCopiar {
        float: right;
        margin-top: 5px;
    }

    #avisoCopiado {
        float: right;
        margin-top: 10px;
    }

    .col-md-6 {
        display: flex;
        flex-direction: column;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
    }
    td {
        font-size: .9em;
    }
    tfoot td {
        font-weight: bold;
    }
    tbody tr:nth-child(even) {
        background-color: #f5f5f5;
    }
    tbody tr:hover {
        background-color: #ebebeb;
    }
    #campoTexto{
        min-height: 300px;
    }
    .radio-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .radio-container label {
        margin-bottom: 0;
    }
    P {
      margin-bottom: 0;
    }
    .blue-text {
      color: #4169e1;
    }
    .center-icon {
      display: block;
      margin: 0 auto;
      min-width: none;
      min-height:
    }
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 1005; /* Defina o tamanho desejado para a div */
      height: 1005; /* Defina o tamanho desejado para a div */
      margin: 0 auto; /* Centraliza a div horizontalmente */
    }
    #descricaoCardTrello{
      min-height: 350px;
    }
    .table-responsive::-webkit-scrollbar {
      width: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
      background-color: #f1f1f1;
    }

    .table-responsive::-webkit-scrollbar-thumb {
      background-color: #888;
      border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
      background-color: #555;
    }
    .descricao-orcamento {
      min-width: 400px;
    }
    .modal-dialog {
      margin: 5% auto;
      max-width: 800px;
    }

    .modal-content {
      width: 100%;
      height: 100%;
      padding: 20px;
    }

    .modal-body {
      height: 400px;
      overflow-y: auto;
    }

    .modal-title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
    }

    textarea {
      height: 150px;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
    }

    .close {
      font-size: 28px;
      font-weight: bold;
      color: #000;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="container mt-4">
        <h1>Gerar Orçamentos</h1>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <form id="opt-octa-form" method="POST" action="">
                    <div class="form-group">
                      <div class="radio-container">
                          <div class="custom-control custom-radio">
                              <input type="radio" id="gerarRascunho" name="tipoDocumento" class="custom-control-input" onclick="desmarcarOrcamento()">
                              <label class="custom-control-label" for="gerarRascunho">Gerar Rascunho</label>
                          </div>
                          <div class="custom-control custom-radio">
                              <input type="radio" id="gerarOrcamento" name="tipoDocumento" class="custom-control-input" onclick="desmarcarRascunho()" checked>
                              <label class="custom-control-label" for="gerarOrcamento">Gerar Orçamento</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="container">
                            <div class="form-group">
                                <label for="id">ID Cliente:</label>
                                <div class="input-group">
                                    <input type="text" id="id" class="form-control"></input>
                                    <div class="input-group-append">
                                        <button id="buscar_orcamento" class="btn btn-primary" type="button">Buscar Orçamentos</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="produto-form" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <div class="container">
                            <div class="form-group">
                                <label for="produto">Produto:</label>
                                <select class="form-control select2" id="produto" name="produto">
                                    <option value="">Selecione um produto</option>
                                    <option value="personalizado">Produto Personalizado</option>
                                    @foreach ($produtos->sortBy('NOME')->sortBy(function($produto) {
                                    return strpos($produto->NOME, 'Bandeira Personalizada') !== false ? 0 : 1;
                                    }) as $produto)
                                    @if ($produto->NOME !== 'Bandeira Personalizada')
                                    <option value="{{ $produto->id }}">{{ $produto->NOME }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table mt-4">
                        <thead>
                          <tr>
                            <th hidden>ID</th>
                            <th>Produto</th>
                            <th>R$</th>
                            <th>Kg</th>
                            <th>Qtd</th>
                            <th>Confecção</th>
                            <th>Ilhose</th>
                            <th>Mastro</th>
                            <th>Alt.</th>
                            <th>Comp.</th>
                            <th>Larg.</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="produtoTableBody"></tbody>
                      </table>
                    </div>
                </form>
                <form id="cep-form" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="cep">CEP:</label>
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP">
                    </div>
                    <div class="form-group">
                        <label for="endereco">Endereço:</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" readonly="" style="background-color: #f2f2f2;">
                    </div>
                </form>
                <div class="col-md-12">
                    <div id="transp-title">
                        <h3>Transportadoras:</h3>
                    </div>
                    <div class="cards-container" id="cardsContainer"></div>
                </div>
                <button type="button" class="btn btn-primary" id="calcularFrete">Calcular</button>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Detalhes do orçamento:</h4>
                        <div class="details-container">
                            <textarea class="form-control" id="campoTexto" rows="5"></textarea>
                            <button type="button" class="btn btn-primary mt-2" id="botaoOrcamento">Salvar/Enviar Orçamento</button>
                            <button type="button" class="btn btn-primary mt-2" id="botaoPedidoTiny">Criar Pedido</button>
                            <button type="button" class="btn btn-secondary mt-2" id="botaoLimparCampos">Novo Orçamento</button>
                            <button type="button" class="btn btn-primary mt-2" id="botaoCopiar">Copiar</button>
                            <p class="text-success mt-2" id="avisoCopiado" style="display: none;">Copiado com sucesso!</p>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-4">
                        <h4>Detalhes do card</h4>
                        <div class="details-container">
                            <div class="form-group">
                                <label for="tituloCardTrello">Título:</label>
                                <input type="text" class="form-control" id="tituloCardTrello">
                            </div>
                            <div class="form-group">
                                <label for="descricaoCardTrello">Descrição:</label>
                                <textarea class="form-control" id="descricaoCardTrello" rows="5"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary mt-2" id="botaoCardTrello">Gerar Card</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPedidos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <!-- Cabeçalho do modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Criar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Corpo do modal -->
      <div class="modal-body">
        <div class="form-group">
          <label for="idPedido">ID:</label>
          <input type="text" class="form-control" id="idPedido">
        </div>
        <div class="form-group">
          <label for="clientePedido">Cliente:</label>
          <input type="text" class="form-control" id="clientePedido">
        </div>
        <div class="form-group">
          <label for="produtosPedido">Produtos:</label>
          <textarea class="form-control" id="produtosPedido"></textarea>
        </div>
      </div>
      
      <!-- Rodapé do modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
      
    </div>
  </div>
</div>
@endsection
@section('extraScript')
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    $(function() {
      const botaoCardTrello = document.getElementById('botaoCardTrello');
      botaoCardTrello.addEventListener('click', gerarCard);

      // Inicializar o select2 para o campo de produto
      $('#produto').select2();

      function consultarProduto() {
        var produto = $('#produto').val();
        // Realizar requisição AJAX para obter dados do produto do Tiny API
        $.get('https://artearena.kinghost.net/consultar-tiny', {
          token: 'bc3cdea243d8687963fa642580057531456d34fa',
          id: produto,
          formato: 'json'
        }, function(response) {
          var produtoData = response;
          console.log(response);
          // Verificar se o produto possui prazo de confecção
          var prazoConfeccao = produtoData.retorno.produto && produtoData.retorno.produto.dias_preparacao ? produtoData.retorno.produto.dias_preparacao : 0;
          // Verificar se é um produto personalizado
          var nomeProduto = produtoData.retorno.produto && produtoData.retorno.produto.nome ? produtoData.retorno.produto.nome : '';
          // Verificar se é um produto personalizado
          if (nomeProduto.toLowerCase().includes("personalizado")) {
            // Definir valores padrão para produto personalizado
            produtoData.retorno.produto.preco = 0;
            produtoData.retorno.produto.peso_bruto = 0;
            prazoConfeccao = 0;
          }
          // Adicionar registro à tabela de produtos selecionados
          const tableBody = document.getElementById("produtoTableBody");
          const newRow = tableBody.insertRow();
          newRow.innerHTML = `
            <td hidden>${produto}</td>
            <td>
              <input type="text" class="form-control" value="${nomeProduto}" style="width: 200px;">
            </td>
            <td>
              <input type="text" class="form-control" value="${produtoData.retorno.produto && produtoData.retorno.produto.preco ? produtoData.retorno.produto.preco : 0}" onchange='
                var valor = this.value;
                this.value = valor;
                console.log("alterado");
              ' style="width: 70px;">
            </td>
            <td>
              <input type="number" class="form-control" value="${produtoData.retorno.produto && produtoData.retorno.produto.peso_bruto ? produtoData.retorno.produto.peso_bruto : 0}" onchange='
                var peso = this.value;
                this.value = peso;
                this.removeAttribute("readonly");
              ' style="width: 60px;">
            </td>
            <td>
              <input type="number" class="form-control" value="1" onchange='
                var quantidade = this.value;
                if (quantidade <= 0) {
                  this.value = 1; <!-- Defina um valor padrão, caso o usuário insira um valor negativo ou zero -->
                }
                this.removeAttribute("readonly");
              ' style="width: 60px;">
            </td>
            <td>
              <input type="number" class="form-control prazo-confeccao" value="${prazoConfeccao}" onchange='
                var prazoConfecao = this.value;
                this.value = prazoConfecao;
                this.removeAttribute("readonly");
              ' style="width: 60px;">
            </td>
            <td>
              <input type="checkbox" class="form-check-input" id="ilhosesCheckbox">
            </td>
            <td>
              <input type="checkbox" class="form-check-input" id="mastroCheckbox">
            </td>
            <td>
              <input type="number" class="form-control" value="" onchange='
                var altura = this.value;
                this.value = altura;
                this.removeAttribute("readonly");
              ' style="width: 60px;">
            </td>
            <td>
              <input type="number" class="form-control" value="" onchange='
                var comprimento = this.value;
                this.value = comprimento;
                this.removeAttribute("readonly");
              ' style="width: 60px;">
            </td>
            <td>
              <input type="number" class="form-control" value="" onchange='
                var largura = this.value;
                this.value = largura;
                this.removeAttribute("readonly");
              ' style="width: 60px;">
            </td>
            <td onclick="var tableRow = this.closest('tr'); tableRow.remove();">
              <button class="btn btn-danger">Remover</button>
            </td>
          `;
          newRow.querySelector("td input").dataset.id = produto;
          }).fail(function() {
            console.log("Erro ao consultar o produto. Verifique se o ID do produto é válido.");
          });
      }


      $('#produto').change(function() {
          consultarProduto();
      });

      function removerProduto(button) {
          var tableRow = button.closest("tr");
          tableRow.remove();
      }
      function formatarData(dataStr) {
          const data = new Date(dataStr);
          const dia = data.getDate().toString().padStart(2, '0');
          const mes = (data.getMonth() + 1).toString().padStart(2, '0');
          const ano = data.getFullYear();
          return `${dia}/${mes}/${ano}`;
      }
      function consultarCep() {
          var cep = $('#cep').val();

          $.get('https://viacep.com.br/ws/' + cep + '/json/', function(response) {
              $('#endereco').val('');

              if (!response.erro) {
                  var endereco = response.logradouro + ', ' + response.bairro + ', ' + response.localidade + ' - ' + response.uf;
                  $('#endereco').val(endereco);
              }
          });
      }

      $('#cep').on('input', function() {
          $(this).val($(this).val().replace(/\D/g, ''));
      });

      $('#cep').on('keydown', function(event) {
          if (event.keyCode === 13 || event.keyCode === 9) {
              event.preventDefault();
              consultarCep();
          }
      });

      $('#cep').on('blur', function() {
          consultarCep();
      });

      $(function() {
      // Evento de clique no botão "Calcular frete"
      $('#calcularFrete').click(function() {
        const url = "https://artearena.kinghost.net/consultar-kangu";

        const cepDestino = $('#cep').val();
        var peso_total = 0;
        var valor_total = 0;
        var produtos = [];
        var prazoConfecaoMaisAlto = 0;

        // Obter os dados dos produtos selecionados na tabela
        var tableRows = $("#produtoTableBody tr");
        console.log(tableRows);
        tableRows.each(function() {
          var id = $(this).find("td:first-child").text();
          var valor = parseFloat($(this).find("td:nth-child(3) input").val());
          var peso = parseFloat($(this).find("td:nth-child(4) input").val());
          var quantidade = parseInt($(this).find("td:nth-child(5) input").val());
          var prazoConfecao = parseInt($(this).find("td:nth-child(6) input").val());

          var produto = {
            id: id,
            valor: valor,
            peso: peso,
            quantidade: quantidade,
            prazoConfecao: prazoConfecao
          };
          console.log(produto);
          produtos.push(produto);

          peso_total += peso * quantidade;
          valor_total += valor * quantidade;

          if (prazoConfecao > prazoConfecaoMaisAlto) {
            prazoConfecaoMaisAlto = prazoConfecao;
          }
        });

        if (prazoConfecaoMaisAlto === 0) {
          prazoConfecaoMaisAlto = 15; // Prazo de confecção fixo em 15 dias úteis
        }

        const bodyData = {
          cepDestino: cepDestino,
          vlrMerc: valor_total,
          pesoMerc: peso_total,
          produtos: produtos,
          prazoConfecao: prazoConfecaoMaisAlto
        };

        console.log(bodyData);

        fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(bodyData)
        })
        .then(response => response.json())
        .then(data => {
          const cardsContainer = document.getElementById("cardsContainer");

          while (cardsContainer.firstChild) {
            cardsContainer.removeChild(cardsContainer.firstChild);
          }

          if (data.alertas && data.alertas.length > 0) {
            data.alertas.forEach(alerta => {
              const alertElement = document.createElement("p");
              alertElement.textContent = alerta;
              cardsContainer.appendChild(alertElement);
            });
          }
          cardRetirada(prazoConfecaoMaisAlto);
          data.sort(function(a, b) {
            return a.vlrFrete - b.vlrFrete;
          });

          // Encontrar a transportadora com o frete mais barato
          let freteMaisBarato = null;
          data.forEach(transportadora => {
            if (transportadora.transp_nome !== "Retira") {
              if (!freteMaisBarato || transportadora.vlrFrete < freteMaisBarato.vlrFrete) {
                freteMaisBarato = transportadora;
              }
            }
          });

          // Encontrar a transportadora com o menor prazo de entrega
          let prazoMenor = null;
          data.forEach(transportadora => {
            if (transportadora.transp_nome !== "Retira") {
              if (!prazoMenor || transportadora.prazoEnt < prazoMenor.prazoEnt) {
                prazoMenor = transportadora;
              }
            }
          });

          data.forEach(transportadora => {
            if (transportadora.transp_nome !== "Retira") {
              const cardElement = document.createElement("div");
              cardElement.classList.add("card");

              const logoContainer = document.createElement("div");
              logoContainer.classList.add("logo-container");

              const logoElement = document.createElement("img");
              logoElement.src = transportadora.url_logo;

              const titulo = document.createElement("h4");
              titulo.textContent = transportadora.transp_nome;
              titulo.classList.add("center-icon");

              const prazoEntregaElement = document.createElement("p");
              prazoEntregaElement.textContent = `Prazo de Entrega: ${transportadora.prazoEnt}`;

              const valorFreteElement = document.createElement("p");
              valorFreteElement.textContent = `Valor do Frete: R$${transportadora.vlrFrete}`;

              const dataPrevEntregaElement = document.createElement("p");
              dataPrevEntregaElement.textContent = `Previsão: ${formatarData(transportadora.dtPrevEnt)}`;

              cardElement.appendChild(logoContainer);
              logoContainer.appendChild(logoElement);
              cardElement.appendChild(titulo);
              cardElement.appendChild(prazoEntregaElement);
              cardElement.appendChild(valorFreteElement);
              cardElement.appendChild(dataPrevEntregaElement);
              cardsContainer.appendChild(cardElement);

              // Adicionar informações de frete mais barato
              if (transportadora === freteMaisBarato) {
                const freteMaisBaratoIcon = document.createElement("i");
                freteMaisBaratoIcon.classList.add("fas", "fa-money-bill", "blue-text"); // Adicionar classe para estilização
                const freteMaisBaratoInfo = document.createElement("span");
                freteMaisBaratoInfo.textContent = " Frete mais barato!";
                freteMaisBaratoInfo.classList.add("blue-text"); // Adicionar classe para estilização
                dataPrevEntregaElement.appendChild(document.createElement("br"));
                dataPrevEntregaElement.appendChild(document.createElement("br"));
                dataPrevEntregaElement.appendChild(freteMaisBaratoIcon);
                dataPrevEntregaElement.appendChild(freteMaisBaratoInfo);
              }

              // Adicionar informações do menor prazo de entrega
              if (transportadora === prazoMenor) {
                const freteMaisRapidoIcon = document.createElement("i");
                freteMaisRapidoIcon.classList.add("fas", "fa-truck", "blue-text"); // Adicionar classe para estilização
                const freteMaisRapidoInfo = document.createElement("span");
                freteMaisRapidoInfo.textContent = " Frete mais rápido!";
                freteMaisRapidoInfo.classList.add("blue-text"); // Adicionar classe para estilização
                dataPrevEntregaElement.appendChild(document.createElement("br"));
                dataPrevEntregaElement.appendChild(document.createElement("br"));
                dataPrevEntregaElement.appendChild(freteMaisRapidoIcon);
                dataPrevEntregaElement.appendChild(freteMaisRapidoInfo);
              }
              document.getElementById("botaoLimparCampos").addEventListener("click", function() {
                  document.getElementById("id").value = "";
                  document.getElementById("cep").value = "";
                  document.getElementById("endereco").value = "";
                  document.getElementById("campoTexto").value = "";
                  document.getElementById("tituloCardTrello").value = "";
                  document.getElementById("descricaoCardTrello").value = "";
                  
                  // Limpar registros da tabela
                  const tableBody = document.getElementById("produtoTableBody");
                  tableBody.innerHTML = "";

                  const cardsContainer = document.getElementById("cardsContainer");
                  while (cardsContainer.firstChild) {
                    cardsContainer.removeChild(cardsContainer.firstChild);
                  }
              });

              // Adicionar evento de seleção ao card
              cardElement.addEventListener("click", function () {
                const selectedCard = document.querySelector(".card.selected");
                if (selectedCard) {
                  selectedCard.classList.remove("selected");
                }
                // Adicionar classe "selected" ao card selecionado
                this.classList.add("selected");
                // Exibir detalhes do frete no campo de texto
                const campoTexto = document.getElementById("campoTexto");
                campoTexto.value = "";
                let produtosSelecionados = {};
                const tableRows = $("#produtoTableBody tr");
                tableRows.each(function () {
                  const id = $(this).find("td:first-child").text();
                  const nomeProduto = $(this).find("td:nth-child(2) input").val();
                  const valorProduto = parseFloat($(this).find("td:nth-child(3) input").val());
                  const quantidade = parseInt($(this).find("td:nth-child(5) input").val());
                  if (!produtosSelecionados.hasOwnProperty(id)) {
                    produtosSelecionados[id] = {
                      nome: nomeProduto,
                      valor: valorProduto,
                      quantidade: quantidade
                    };
                  } else {
                    produtosSelecionados[id].quantidade += quantidade;
                  }
                });
                var produtosDescricao = "";
                for (const id in produtosSelecionados) {
                  if (produtosSelecionados.hasOwnProperty(id)) {
                    const nomeProduto = produtosSelecionados[id].nome;
                    const quantidade = produtosSelecionados[id].quantidade;
                    const valor = produtosSelecionados[id].valor;
                    const produtoDescricao = `${quantidade} un - ${nomeProduto} - R$${valor}\n`;
                    produtosDescricao += produtoDescricao;
                  }
                }
                const titulo = transportadora.transp_nome;
                const frete = transportadora.vlrFrete;
                const prazoEntrega = transportadora.prazoEnt;
                let valorTotal = 0;
                for (const id in produtosSelecionados) {
                  if (produtosSelecionados.hasOwnProperty(id)) {
                    const valorProduto = produtosSelecionados[id].valor;
                    const quantidade = produtosSelecionados[id].quantidade;
                    valorTotal += valorProduto * quantidade;
                  }
                }
                valorTotal += parseFloat(frete);
                const valorTotalFormatado = valorTotal.toFixed(2);
                const prazoConfeccao = prazoConfecaoMaisAlto;
                var detalhesFrete = `Frete: ${cepDestino} - R$${frete} - (Dia da postagem + ${prazoEntrega} dias úteis via ${titulo})\n\n`;
                var total = `Total: R$${valorTotalFormatado}\n`;

                total = total.replace(/\./g, ",");
                detalhesFrete = detalhesFrete.replace(/\./g, ",");
                produtosDescricao = produtosDescricao.replace(/\./g, ",");

                const prazo = `Prazo para confecção é de ${prazoConfeccao} dias úteis + prazo de envio.\nPrazo inicia-se após aprovação da arte e pagamento confirmado`;
                campoTexto.value = `${produtosDescricao}${detalhesFrete}${total}\n${prazo}`;
                carregarInfoCard();
              
              });
            }
          });
          
        });
      });

          // Evento de clique no botão "Copiar"
          $('#botaoCopiar').click(function() {
              const campoTexto = document.getElementById("campoTexto");
              campoTexto.select();
              campoTexto.setSelectionRange(0, 99999);
              document.execCommand("copy");

              const avisoCopiado = document.getElementById("avisoCopiado");
              avisoCopiado.style.display = "block";
              setTimeout(function() {
                  avisoCopiado.style.display = "none";
              }, 2000);
          });
        });
      });
      function carregarInfoCard() {
  const produtosSelecionados = obterListaProdutos();
  let descricao = "#Produtos  ";
  const rows = document.querySelectorAll("#produtoTableBody tr");
  rows.forEach(row => {
    const ilhoseCheckbox = row.querySelector("#ilhosesCheckbox");
    const mastroCheckbox = row.querySelector("#mastroCheckbox");
    const ilhoseChecked = ilhoseCheckbox.checked;
    const mastroChecked = mastroCheckbox.checked;
    const produto = row.querySelector("td:nth-child(2) input").value;
    const tamanho = produto.split(" - ")[1];
    const faces = produto.split(" - ")[2];
    descricao += `
**Tipo:** ${produto.split(" - ")[0]}  
**Tamanho:** ${tamanho}  
**Faces:** ${faces}`;
    if (ilhoseChecked) {
      descricao += `
**Ilhoses:** Sim`;
    }
    if (mastroChecked) {
      descricao += `
**Mastro:** Sim`;
    }
    const descricaoProduto = row.querySelector("td:nth-child(7) input").value;
    descricao += `
**Descrição:** ?
---
`;
  });
  document.getElementById('tituloCardTrello').value = '';
  document.getElementById('descricaoCardTrello').value = descricao;
}
const id_cliente = document.getElementById('id').value;
      function consultarOrcamentos() {
        const id_cliente = document.getElementById('id').value;
        console.log(id_cliente);
        fetch(`/frete/consultarorcamentos/${id_cliente}`)
          .then(response => response.json())
          .then(data => {
            // Criar o conteúdo da tabela
            let tabelaHtml = `
              <table class="table-responsive">
                <thead>
                  <tr>
                    <th style="display: none;">ID</th>
                    <th>Detalhes</th>
                    <th>CEP Frete</th>
                    <th>Endereço Frete</th>
                    <th>Nome Transportadora</th>
                    <th>Valor Frete</th>
                    <th>Prazo Entrega</th>
                    <th>Data Prevista</th>
                    <th>Logo Frete</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody>
            `;
            console.log(data);
            // Preencher a tabela com os dados dos orçamentos
            data.forEach((orcamento) => {
              tabelaHtml += `
                <tr>
                  <td style="display: none;">${orcamento.id}</td>
                  <td class="descricao-orcamento">${orcamento.detalhes_orcamento}</td>
                  <td>${orcamento.cep_frete}</td>
                  <td>${orcamento.endereco_frete}</td>
                  <td>${orcamento.nome_transportadora}</td>
                  <td>${orcamento.valor_frete}</td>
                  <td>${orcamento.prazo_entrega}</td>
                  <td>${orcamento.data_prevista}</td>
                  <td>${orcamento.logo_frete}</td>
                  <td><button class="btn btn-primary btn-carregar" onclick="carregarDados(this)">Carregar</button></td>
                </tr>
              `;
            });
            tabelaHtml += `
                </tbody>
              </table>
            `;
            // Criar o modal
            const modal = document.createElement('div');
            modal.classList.add('modal');
            modal.innerHTML = `
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Orçamentos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    ${tabelaHtml}
                  </div>
                </div>
              </div>
            `;
            // Remover modais anteriores (se existirem)
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
              modal.remove();
            });
            // Adicionar o modal ao body
            document.body.appendChild(modal);
            // Abrir o modal
            $('.modal').modal('show');
          })
          .catch(error => {
            console.error('Erro ao consultar os orçamentos:', error);
          });
      }


      // Adicionar o evento de clique ao botão "Buscar Orçamentos"
      document.getElementById('buscar_orcamento').addEventListener('click', consultarOrcamentos);

      function carregarDados(button) {
        const row = button.closest("tr");
        const descricaoOrcamento = row.querySelector(".descricao-orcamento").textContent;
        const cepFrete = row.cells[2].textContent;
        const enderecoFrete = row.cells[3].textContent;

        // Obter os produtos relacionados ao orçamento
        const orcamentoId = row.querySelector("td:first-child").textContent;
        fetch(`/frete/orcamentoProdutos/${orcamentoId}`)
          .then(response => response.json())
          .then(data => {
            // Preencher a tabela com os dados dos produtos
            const tabelaBody = document.getElementById("produtoTableBody");
            tabelaBody.innerHTML = ""; // Limpar o conteúdo existente da tabela

            data.forEach(produto => {
              const newRow = document.createElement("tr");
              console.log(produto);
              console.log(produto.id);
              console.log(produto.nome_produto);
              console.log(produto.valor_unitario);
              newRow.innerHTML = `
                <td hidden>${produto.id}</td>
                <td>${produto.nome_produto}</td>
                <td>${produto.valor_unitario}</td>
                <td>${produto.peso_unitario}</td>
                <td>${produto.quantidade}</td>
                <td>${produto.prazo_individual}</td>
                <td></td>
                <td></td>
                <td</td>
                <td></td>
                <td></td>
                <td>
                  <button class="btn btn-primary btn-carregar" onclick="carregarDados(this)">Carregar</button>
                </td>
              `;

              tabelaBody.appendChild(newRow);
            });

            // Preencher os campos da tela com os dados do orçamento
            document.getElementById("campoTexto").value = descricaoOrcamento;
            document.getElementById("cep").value = cepFrete;
            document.getElementById("endereco").value = enderecoFrete;
            
          })
          .catch(error => {
            console.error('Erro ao obter os produtos do orçamento:', error);
          });

        // Feche o modal com o ID específico
        $('#orcamentosModal').modal('hide');
      }
      function gerarCard() {
        const nomeCartao = document.getElementById('tituloCardTrello').value;
        const descCartao = document.getElementById('descricaoCardTrello').value;

        fetch('https://artearena.kinghost.net/criar-card-trello', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              nome: nomeCartao,
              desc: descCartao
            })
          })
          .then(response => response.json())
          .then(data => {
            Swal.fire({
              title: 'Sucesso',
              text: data.message,
              icon: 'success',
              confirmButtonText: 'OK'
            });
          })
          .catch(error => {
            console.error('Erro:', error);
            Swal.fire({
              title: 'Erro ao criar o cartão no Trello',
              text: 'Ocorreu um erro ao tentar criar o cartão no Trello. Por favor, verifique suas informações e tente novamente.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          });
      }
      
      function cardRetirada(prazoConfecao){
        // Adicionar a transportadora "Retirada"
          const retiradaCardElement = document.createElement("div");
          retiradaCardElement.classList.add("card");
          const tituloRetirada = document.createElement("p");
          const nomeRetiradaElement = document.createElement("h4");
          nomeRetiradaElement.textContent = "Retirada";
          tituloRetirada.appendChild(nomeRetiradaElement);
          tituloRetirada.classList.add("center-icon");

          const logoRetiradaElement = document.createElement("img");
          logoRetiradaElement.src = "./images/logopreto.png"; // Ajuste o caminho para o logo da "Retirada"

          const valorFreteRetiradaElement = document.createElement("p");
          valorFreteRetiradaElement.textContent = "Valor do Frete: R$0.00"; // Ajuste o valor do frete para a "Retirada"
          const prazoEntregaRetiradaElement = document.createElement("p");
          prazoEntregaRetiradaElement.textContent = "Prazo de Entrega: A combinar"; // Ajuste o prazo de entrega para a "Retirada"
          const dataPrevEntregaRetiradaElement = document.createElement("p");
          dataPrevEntregaRetiradaElement.textContent = "Previsão: A combinar"; // Ajuste a previsão para a "Retirada"

          retiradaCardElement.appendChild(logoRetiradaElement);
          retiradaCardElement.appendChild(tituloRetirada);
          retiradaCardElement.appendChild(valorFreteRetiradaElement);
          retiradaCardElement.appendChild(prazoEntregaRetiradaElement);
          retiradaCardElement.appendChild(dataPrevEntregaRetiradaElement);
          cardsContainer.appendChild(retiradaCardElement);
          // Adicionar evento de seleção ao card de "Retirada"
          retiradaCardElement.addEventListener("click", function () {
            const selectedCard = document.querySelector(".card.selected");
            if (selectedCard) {
              selectedCard.classList.remove("selected");
            }
            // Adicionar classe "selected" ao card selecionado
            this.classList.add("selected");
            // Exibir detalhes do frete no campo de texto
            const campoTexto = document.getElementById("campoTexto");
            campoTexto.value = "";
            var produtosSelecionados = {};
            const tableRows = $("#produtoTableBody tr");
            tableRows.each(function () {
              const id = $(this).find("td:first-child").text();
              const nomeProduto = $(this).find("td:nth-child(2) input").val();
              const valorProduto = parseFloat($(this).find("td:nth-child(3) input").val());
              const quantidade = parseInt($(this).find("td:nth-child(5) input").val());
              if (!produtosSelecionados.hasOwnProperty(id)) {
                produtosSelecionados[id] = {
                  nome: nomeProduto,
                  valor: valorProduto,
                  quantidade: quantidade
                };
              } else {
                produtosSelecionados[id].quantidade += quantidade;
              }
              
            });
            var produtosDescricao = "";
            for (const id in produtosSelecionados) {
              if (produtosSelecionados.hasOwnProperty(id)) {
                const nomeProduto = produtosSelecionados[id].nome;
                const quantidade = produtosSelecionados[id].quantidade;
                const valor = produtosSelecionados[id].valor;
                const produtoDescricao = `${quantidade} un - ${nomeProduto} - R$${valor}\n`;
                produtosDescricao += produtoDescricao;
              }
            }
            const titulo = "Retirada";
            const frete = "Retirada"; // Substituir pelo texto desejado para "Retirada"
            const prazoEntrega = "Retirada"; // Substituir pelo texto desejado para "Retirada"
            let valorTotal = 0;
            for (const id in produtosSelecionados) {
              if (produtosSelecionados.hasOwnProperty(id)) {
                const valorProduto = produtosSelecionados[id].valor;
                const quantidade = produtosSelecionados[id].quantidade;
                valorTotal += valorProduto * quantidade;
              }
            }
            const valorTotalFormatado = valorTotal.toFixed(2);
            const detalhesFrete = `Frete: ${frete} \n\n`; // Ajustar o texto para "Retirada"
            var total = `Total: R$${valorTotalFormatado}\n`;
          
            total = total.replace(/\./g, ",");
            produtosDescricao = produtosDescricao.replace(/\./g, ",");

            const prazo = `Prazo para confecção é de ${prazoConfecao} dias úteis.\nPrazo inicia-se após aprovação da arte e pagamento confirmado`;
            campoTexto.value = `${produtosDescricao}${total}\n${prazo}`;
          });
      }
      </script>
      <script>
          const botaoOrcamento = document.getElementById('botaoOrcamento');

          // Adiciona um evento de clique ao botão
          botaoOrcamento.addEventListener('click', function() {
              // Chama a função salvarOrcamento()
              salvarOrcamento();
          });

          function salvarOrcamento() {
            var tipoDocumento = document.querySelector('input[name="tipoDocumentoRascunho"]:checked');

            if (tipoDocumento && tipoDocumento.checked) {
              Swal.fire({
                title: 'Modo atual: rascunho',
                text: 'Para gerar orçamento, troque a opção',
                icon: 'warning',
                timer: 3000,
                showConfirmButton: true
              });
              return;
            }  


            const detalhesTransportadora = obterDetalhesTransportadora();
            const detalhesFrete = obterDetalhesFrete(); 
            const produtosSelecionados = obterListaProdutos();

            if (!detalhesFrete.id) {
                alert("ID do octa faltando");
                return;
            }
            if (!detalhesFrete.detalhes_orcamento) {
                alert("Detalhes do orcamento faltando ");
                return;
            } 
            // Montar array de produtos
            const produtos = Object.values(produtosSelecionados).map(produto => {
              return {
                nome: produto.nome,
                valor: produto.valor,
                peso: produto.peso,
                quantidade: produto.quantidade,
                prazo_individual: produto.prazo_individual
              };
            });
            if (detalhesTransportadora.dataPrevista === null) {
              data_prevista = null;
            } else {
              data_prevista = detalhesTransportadora.dataPrevista.replace(" Frete mais rápido!", "").replace(" Frete mais barato!", "").trim();
            }
            // Enviar a requisição AJAX para salvar o pedido
            $.ajax({
              url: '/frete/orcamentos-salvar',
              method: 'POST',
              data: {
                id_octa: detalhesFrete.id,
                detalhes_orcamento: detalhesFrete.detalhes_orcamento,
                cep_frete: detalhesFrete.cep_frete,
                endereco_frete: detalhesFrete.endereco_frete,
                nome_transportadora: detalhesTransportadora.nomeTransportadora,
                valor_frete: detalhesTransportadora.valorFrete,
                prazo_entrega: detalhesTransportadora.prazoEntrega,
                data_prevista: data_prevista,
                logo_frete: detalhesTransportadora.logoTransportadora,
                produtos: produtos,
                _token: "{{ csrf_token() }}"
              },
              success: function(response) {
                // Exibir mensagem de sucesso usando o Swal
                Swal.fire({
                  title: 'Sucesso',
                  text: 'Orçamento salvo com sucesso',
                  icon: 'success',
                  confirmButtonText: 'OK'
                }); 
              },
              error: function(xhr, status, error) {
                // Tratamento de erro
                var errorMessage = "Erro ao salvar orçamento: ";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                  errorMessage += xhr.responseJSON.message;
                } else {
                  errorMessage += "Ocorreu um erro inesperado.";
                }
                alert(errorMessage);
              }
            });
          }
          function obterListaProdutos() {
            const produtosSelecionados = {};

            const tableRows = $("#produtoTableBody tr");
            tableRows.each(function () {
              const id = $(this).find("td:first-child").text();
              const nomeProduto = $(this).find("td:nth-child(2) input").val();
              const valorProduto = parseFloat($(this).find("td:nth-child(3) input").val());
              const peso = parseFloat($(this).find("td:nth-child(4) input").val());
              const quantidade = parseInt($(this).find("td:nth-child(5) input").val());
              const prazo_individual = parseInt($(this).find("td:nth-child(6) input").val());

              if (!produtosSelecionados.hasOwnProperty(id)) {
                produtosSelecionados[id] = {
                  nome: nomeProduto,
                  valor: valorProduto,
                  quantidade: quantidade,
                  peso: peso,
                  prazo_individual: prazo_individual
                };
              } else {
                produtosSelecionados[id].quantidade += quantidade;
              }
            });

            return produtosSelecionados;
          }

          function obterDetalhesTransportadora() {
            const cardElement = document.querySelector(".card.selected");
            const nomeTransportadora = cardElement.querySelector("h4").textContent;
            const valorFreteElement = cardElement.querySelector("p:nth-of-type(2)");
            const prazoEntregaElement = cardElement.querySelector("p:nth-of-type(1)");
            const dataPrevistaElement = cardElement.querySelector("p:nth-of-type(3)");
            const logoTransportadora = cardElement.querySelector("img").src;
            const valorFrete = extrairValor(valorFreteElement.textContent);
            var prazoEntrega = extrairNumero(prazoEntregaElement.textContent);
            const dataPrevista = extrairData(dataPrevistaElement.textContent);
            var dataPrevistaFormatada = converterData(dataPrevista);

            if (nomeTransportadora === "Retirada") {
              dataPrevistaFormatada = null;
              prazoEntrega = null;
            }

          return {
            nomeTransportadora,
            valorFrete,
            prazoEntrega,
            dataPrevista: dataPrevistaFormatada,
            logoTransportadora
          };
        }

        function extrairValor(texto) {
          const valor = texto.replace("Valor do Frete: R$", "").trim();
          return valor;
        }

        function extrairNumero(texto) {
          const numero = parseInt(texto.replace("Prazo de Entrega: ", "").trim());
          return numero;
        }

        function extrairData(texto) {
          const data = texto.replace("Previsão: ", "").trim();
          return data;
        }
        function converterData(data) {
          const partesData = data.split("/");
          const dataFormatada = `${partesData[2]}-${partesData[1]}-${partesData[0]}`;
          return dataFormatada;
        }
        function desmarcarOrcamento() {
            document.getElementById("gerarOrcamento").checked = false;
        }

        function desmarcarRascunho() {
            document.getElementById("gerarRascunho").checked = false;
        }
        function obterDetalhesFrete() {
          const id = document.getElementById('id').value;
          const detalhes_orcamento = document.getElementById('campoTexto').value;
          const cep_frete = document.getElementById('cep').value;
          const endereco_frete = document.getElementById('endereco').value;

          const detalhes = {
            id,
            detalhes_orcamento,
            cep_frete,
            endereco_frete
          };

          return detalhes;
        }
</script>
<script>
  document.getElementById("botaoPedidoTiny").addEventListener("click", abrirModal);

  function abrirModal() {
    document.getElementById("modalPedidos").style.display = "block";
  }
</script>
@endsection

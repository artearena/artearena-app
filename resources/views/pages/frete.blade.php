@extends('layout.main')
@section('title')
Simulação de Frete
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
</style>
@endsection

@section('content')
<div class="container">
    <div class="container mt-4">
        <h1>Calcular Frete</h1>
        <div class="row">
            <div class="col-md-6">
                <form id="produto-form" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <div class="container">
                            <div class="form-group">
                                <label for="produto">Produto:</label>
                                <select class="form-control select2" id="produto" name="produto">
                                    <option value="">Selecione um produto</option>
                                    @foreach ($produtos as $produto)
                                    <option value="{{ $produto->id }}">{{ $produto->NOME }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Tabela de produtos selecionados -->
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Peso</th>
                                <th>Quantidade</th>
                                <th>Prazo de Confecção</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody id="produtoTableBody"></tbody>
                    </table>
                </form>

                <form id="cep-form" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="cep">CEP:</label>
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP">
                    </div>
                    <div class="form-group">
                        <label for="endereco">Endereço:</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" readonly="" style="
                        background-color: #f2f2f2;
                    ">                    </div>
            </div>
          <div class="col-sm-6">

              <div class="row">
                        <div class="col-md-12">
                            <div id="transp-title">
                                <h3>Transportadoras:</h3>
                            </div>
                            <div class="cards-container" id="cardsContainer"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="calcularFrete">Calcular frete</button>
                </form>
                <h4>Detalhes do Frete:</h4>
               
            </div>
        </div>
        <div class="details-container">
            <textarea class="form-control" id="campoTexto" rows="5"></textarea>
            <button type="button" class="btn btn-primary mt-2" id="botaoCopiar">Copiar</button>
            <p class="text-success mt-2" id="avisoCopiado" style="display: none;">Copiado com sucesso!</p>
        </div>
    </div>
</div>
@endsection


@section('extraScript')
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
      <script>

        $(function() {
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
        var prazoConfecao = produtoData.retorno.produto.dias_preparacao || 0;

        // Adicionar registro à tabela de produtos selecionados
        const tableBody = document.getElementById("produtoTableBody");
        const newRow = tableBody.insertRow();
        newRow.innerHTML = `
          <td hidden>${produto}</td>
          <td>${produtoData.retorno.produto.nome}</td>
          <td>
            <input type="text" class="form-control" value="${produtoData.retorno.produto.preco}" onchange='
              var valor = this.value;
              this.value = valor;
              console.log("alterado");
            '>
          </td>
          <td>
              <input type="number" class="form-control" value="${produtoData.retorno.produto.peso_bruto}" onchange='
                var peso = this.value;
                this.value = peso;
                this.removeAttribute("readonly");
              '>
          </td>
          <td>
            <input type="number" class="form-control" value="1" onchange='
              var quantidade = this.value;
              if (quantidade <= 0) {
                this.value = 1; <!-- Defina um valor padrão, caso o usuário insira um valor negativo ou zero -->
              }
              this.removeAttribute("readonly");
            '>
        </td>

          <td>
            <input type="number" class="form-control prazo-confeccao" value="${prazoConfecao}" onchange='
              var prazoConfecao = this.value;
              this.value = prazoConfecao;
              this.removeAttribute("readonly");
            '>
          </td>
          <td onclick="var tableRow = this.closest('tr'); tableRow.remove();">
            <button class="btn btn-danger">Remover</button>
          </td>
        `;
        newRow.querySelector("td input").dataset.id = produto;
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
        console.log(data);
        data.forEach(transportadora => {
          const cardElement = document.createElement("div");
          cardElement.classList.add("card");

          const titulo = document.createElement("p");
          const nomeElement = document.createElement("h4");
          nomeElement.textContent = transportadora.transp_nome;
          titulo.appendChild(nomeElement);

          const logoElement = document.createElement("img");
          logoElement.src = transportadora.url_logo;

          const valorFreteElement = document.createElement("p");
          valorFreteElement.textContent = `Valor do Frete: ${transportadora.vlrFrete}`;

          const prazoEntregaElement = document.createElement("p");
          prazoEntregaElement.textContent = `Prazo de Entrega: ${transportadora.prazoEnt}`;

          const dataPrevEntregaElement = document.createElement("p");
          dataPrevEntregaElement.textContent = `Previsão: ${formatarData(transportadora.dtPrevEnt)}`;

          cardElement.appendChild(titulo); 
          cardElement.appendChild(logoElement);
          cardElement.appendChild(valorFreteElement);
          cardElement.appendChild(prazoEntregaElement);
          cardElement.appendChild(dataPrevEntregaElement);

          cardsContainer.appendChild(cardElement);

          // Adicionar evento de seleção ao card
          cardElement.addEventListener("click", function() {
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
            tableRows.each(function() {
              const id = $(this).find("td:first-child").text();
              const nomeProduto = $(this).find("td:nth-child(2)").text();
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

            let produtosDescricao = "";

            for (const id in produtosSelecionados) {
              if (produtosSelecionados.hasOwnProperty(id)) {
                const nomeProduto = produtosSelecionados[id].nome;
                const quantidade = produtosSelecionados[id].quantidade;
                const valor = produtosSelecionados[id].valor;
                const produtoDescricao = `${quantidade} un- ${nomeProduto} - R$ ${valor.toFixed(2)}\n`;
                produtosDescricao += produtoDescricao;
              }
            }
            const titulo =  transportadora.titulo;
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
            const frete = frete.replace('.', ',');

            const valorTotalFormatado = valorTotal.toFixed(2).replace('.', ',');
            const prazoConfeccao = prazoConfecaoMaisAlto;

            const detalhesFrete = `Frete(${titulo}): ${cepDestino} - R$ ${frete} - (Dia da postagem + ${prazoEntrega} úteis)\n`;
            const total = `Total: R$ ${valorTotalFormatado}`;
            const prazo = `Prazo para confecção é de ${prazoConfeccao} dias úteis + prazo de envio.\nPrazo inicia-se após aprovação da arte e pagamento confirmado`;

            campoTexto.value = `${produtosDescricao}\n${detalhesFrete}${total}\n${prazo}`;
          });
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
      </script>
@endsection

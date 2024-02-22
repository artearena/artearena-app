src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
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
    
        // Consultar primeiro na API local
        $.get('https://artearena.kinghost.net/consultarCepArteArena', { cep: cep })
        .done(function(response) {
            $('#endereco').val('');
    
            if (response.erro) {
                // Se o CEP não for encontrado localmente, tentar consultar via ViaCEP
                consultarViaCep(cep);
            } else {
                var endereco = response.street + ', ' + response.district + ', ' + response.city + ' - ' + response.stateShortname;
                $('#endereco').val(endereco);
            }
        })
        .fail(function() {
            // Se ocorrer algum erro na consulta local, tentar consultar via ViaCEP
            consultarViaCep(cep);
        });
    }
    
    // Função para consultar via ViaCEP
    function consultarViaCep(cep) {
        $.get('https://viacep.com.br/ws/' + cep + '/json/', function(response) {
            $('#endereco').val('');
    
            if (!response.erro) {
                var endereco = response.logradouro + ', ' + response.bairro + ', ' + response.localidade + ' - ' + response.uf;
                $('#endereco').val(endereco);
            } else {
                // Se o CEP não for encontrado em nenhuma fonte, exibir mensagem de erro
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'CEP inexistente.'
                });
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

              const prazo = `Prazo para confecção é de ${prazoConfeccao} dias úteis + prazo de envio.\nPrazo inicia-se após aprovação da arte e pagamento confirmado\n\nOrçamento válido por 30 dias.`;
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
  descricao += `**Descrição:**
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
      fetch(`/orcamento/consultarorcamentos/${id_cliente}`)
        .then(response => response.json())
        .then(data => {
          // Criar o conteúdo da tabela
          let tabelaHtml = `
            <table class="table-responsive">
              <thead>
                <tr>
                  <th style="display: none;">ID</th>
                  <th>Detalhes</th>
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
                <td class="descricao-orcamento">${orcamento.detalhes_orcamento.substring(0, 100)}...</td>
                <td>${orcamento.endereco_frete}</td>
                <td>${orcamento.nome_transportadora}</td>
                <td>${orcamento.valor_frete}</td>
                <td>${orcamento.prazo_entrega}</td>
                <td>${orcamento.data_prevista}</td>
                <td>
                  <img src="${orcamento.logo_frete}" alt="${orcamento.nome_transportadora}" width="100px" height="100px" />
                </td>                  
                <td>
                  <button class="btn btn-primary btn-carregar" onclick="carregarDados(this)">Carregar</button>
                  <button class="btn btn-success btn-criar-pedido" onclick="criarPedido(${orcamento.id})">Cria Pedido</button>
                </td>
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
      fetch(`/orcamento/orcamentoProdutos/${orcamentoId}`)
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
      $('#calcularFrete').click();
      $('#orcamentosModal').modal('hide');
    }
    function criarPedido(idOrcamento) {
// Redirecionar p<ara a URL com o ID do orçamento
      window.location.href = `/pedidoInterno/criar-pedido/${idOrcamento}`;
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

        const botaoOrcamento = document.getElementById('botaoOrcamento');

        // Adiciona um evento de clique ao botão
        botaoOrcamento.addEventListener('click', function() {
            // Chama a função salvarOrcamento()
            $('#botaoCopiar').trigger('click');

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
            url: '/orcamento/orcamentos-salvar',
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

          document.getElementById("id").value = "";
          document.getElementById("id").readOnly = true;
          document.getElementById("botaoOrcamento").style.display = "none";
          document.querySelector('.details-container2').style.display = 'none';

      }

      function desmarcarRascunho() {
          document.getElementById("gerarRascunho").checked = false;

          document.getElementById("id").readOnly = false;
          document.getElementById("botaoOrcamento").style.display = "block";
          document.querySelector('.details-container2').style.display = 'block';

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

/*   document.getElementById("botaoPedidoTiny").addEventListener("click", abrirModal);

function abrirModal() {
  document.getElementById("modalPedidos").style.display = "block";
} */

 // Array para armazenar os produtos adicionados
  var produtos = [];

  // Função para adicionar um produto à tabela
  function adicionarProduto() {
    console.log("estou aqui!");
    // Chamar a função para obter a lista de produtos selecionados
    const produtosSelecionados = obterListaProdutos();

    // Selecionar o corpo da tabela no modal
    const tabelaProdutos = document.getElementById("produtosTableBody");

    // Limpar o conteúdo atual da tabela
    tabelaProdutos.innerHTML = "";

    // Percorrer o objeto de produtos selecionados
    for (const id in produtosSelecionados) {
      if (produtosSelecionados.hasOwnProperty(id)) {
        const produto = produtosSelecionados[id];

        // Criar uma nova linha na tabela
        const novaLinha = document.createElement("tr");

        // Preencher as células da linha com as informações do produto
        novaLinha.innerHTML = `
          <td>${produto.nome}</td>
          <td>${produto.quantidade}</td>
          <td>${produto.valor}</td>
          <td><button type="button" class="btn btn-danger btn-remover">Remover</button></td>
        `;

        // Adicionar a nova linha à tabela
        tabelaProdutos.appendChild(novaLinha);
      }
    }
  }
$("#salvarPedido").click(function() {
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
    Vendedor: vendedor,
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

});

$(document).ready(function() {
 

  // Evento de clique do botão "Adicionar Produto"

  $(document).on("click", ".btn-remover", function() {
    var linha = $(this).closest("tr");
    var index = linha.index();
    linha.remove();
    produtos.splice(index, 1);
  });
  // Evento de clique do botão "Salvar Pedido"
  
    // Cliente ID
    $("#cliente_id").mask("9999999999");

    // Vendedor
    $("#vendedor").mask("SSSSSSSSSSSSSSSSSS");

    // Valor do frete
    $("#valor_frete").mask("999999,99");

});

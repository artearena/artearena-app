// Selecione o botão "Expandir"
var botoesExpandir = document.querySelectorAll('.btn-expand-produtos');
// Adicione o evento de clique a todos os botões
botoesExpandir.forEach(function(botaoExpandir) {
  botaoExpandir.addEventListener('click', function() {
    // Obtenha a linha do pedido
    var pedidoRow = this.closest('.pedido-row');
    // Obtenha o ID do pedido
    var pedidoId = pedidoRow.getAttribute('data-pedido-id');
    // Verifique se a linha de produtos já está visível
    var produtosRow = document.querySelector('.produto-pedido-' + pedidoId);

    if (produtosRow != null) {
      console.log(produtosRow.style.display);
      if (produtosRow.style.display === 'none') {
        produtosRow.style.display = '';
      } else {
        produtosRow.style.display = 'none';
      }
    } else {

      // Caso contrário, faça a requisição AJAX para obter a lista de produtos
      fetch('/pedidoInterno/get-produtos-pedido/' + pedidoId)
        .then(function(response) {
          return response.json();
        })
        .then(function(produtos) {
          // Crie uma nova linha para os produtos
          var novaLinha = document.createElement('tr');
          novaLinha.classList.add('produto-pedido-' + pedidoId);
          // Crie uma nova célula para os produtos
          var novaCelula = document.createElement('td');
          novaCelula.setAttribute('colspan', '11');
          // Adicione os dados dos produtos na célula
          produtos.forEach(function(produto) {
            var linhaProduto = document.createElement('div');
            linhaProduto.classList.add('produto-dados');
            linhaProduto.innerHTML = '<strong>Produto:</strong> ' + (produto.produto_nome !== undefined ? produto.produto_nome : '') + '<br>' +
                                    '<strong>Quantidade:</strong> ' + (produto.quantidade !== undefined ? produto.quantidade : '') + '<br>' +
                                    '<strong>Sexo:</strong> <select class="form-control input-sexo">' +
                                        '<option value="M" ' + (produto.sexo === 'M' ? 'selected' : '') + '>M</option>' +
                                        '<option value="F" ' + (produto.sexo === 'F' ? 'selected' : '') + '>F</option>' +
                                    '</select><br>' +
                                    '<strong>Arte Aprovada:</strong> ' + (produto.arte_aprovada !== undefined ? produto.arte_aprovada : '') + '<br>' +
                                    '<strong>Lista Aprovada:</strong> <select class="form-control input-lista-aprovada">' +
                                        '<option value="sim" ' + (produto.lista_aprovada === 'sim' ? 'selected' : '') + '>Sim</option>' +
                                        '<option value="não" ' + (produto.lista_aprovada === 'não' ? 'selected' : '') + '>Não</option>' +
                                    '</select><br>' +
                                    '<strong>Pacote:</strong> <select class="form-control input-pacote">' +
                                        '<option value="start" ' + (produto.pacote === 'start' ? 'selected' : '') + '>Start</option>' +
                                        '<option value="prata" ' + (produto.pacote === 'prata' ? 'selected' : '') + '>Prata</option>' +
                                        '<option value="ouro" ' + (produto.pacote === 'ouro' ? 'selected' : '') + '>Ouro</option>' +
                                        '<option value="diamante" ' + (produto.pacote === 'diamante' ? 'selected' : '') + '>Diamante</option>' +
                                        '<option value="premium" ' + (produto.pacote === 'premium' ? 'selected' : '') + '>Premium</option>' +
                                        '<option value="profissional" ' + (produto.pacote === 'profissional' ? 'selected' : '') + '>Profissional</option>' +
                                    '</select><br>' +
                                    '<strong>Camisa:</strong> <input type="checkbox" ' + (produto.camisa !== undefined ? 'checked' : '') + ' class="input-camisa">' + '<br>' +
                                    '<strong>Calção:</strong> <input type="checkbox" ' + (produto.calcao !== undefined ? 'checked' : '') + ' class="input-calcao">' + '<br>' +
                                    '<strong>Meião:</strong> <input type="checkbox" ' + (produto.meiao !== undefined ? 'checked' : '') + ' class="input-meiao">' + '<br>' +
                                    '<strong>Nome:</strong> ' + (produto.nome !== undefined ? produto.nome : '') + '<br>' +
                                    '<strong>Número:</strong> ' + (produto.numero !== undefined ? produto.numero : '') + '<br>' +
                                    '<strong>Tamanho:</strong> <select class="form-control input-tamanho">' +
                                        '<option value="P" ' + (produto.tamanho === 'P' ? 'selected' : '') + '>P</option>' +
                                        '<option value="M" ' + (produto.tamanho === 'M' ? 'selected' : '') + '>M</option>' +
                                        '<option value="G" ' + (produto.tamanho === 'G' ? 'selected' : '') + '>G</option>' +
                                        '<option value="GG" ' + (produto.tamanho === 'GG' ? 'selected' : '') + '>GG</option>' +
                                        '<option value="XG" ' + (produto.tamanho === 'XG' ? 'selected' : '') + '>XG</option>' +
                                        '<option value="XGG" ' + (produto.tamanho === 'XGG' ? 'selected' : '') + '>XGG</option>' +
                                        '<option value="XGGG" ' + (produto.tamanho === 'XGGG' ? 'selected' : '') + '>XGGG</option>' +
                                    '</select><br>' +
                                    '<strong>ID Lista:</strong> ' + (produto.id_lista !== undefined ? produto.id_lista : '') + '<hr>';
            novaCelula.appendChild(linhaProduto);
          });
          // Adicione a célula na nova linha
          novaLinha.appendChild(novaCelula);
          // Insira a nova linha após a linha do pedido
          pedidoRow.insertAdjacentElement('afterend', novaLinha);
          }) 
        .catch(function(error) {
          console.log('Ocorreu um erro:', error);
        });
    }
  });
});

function salvarPedido(pedidoId, dataVenda) {
  // Faça a solicitação para obter os produtos do pedido usando a URL mencionada
  fetch('/pedidoInterno/get-produtos-pedido/' + pedidoId)
    .then(response => response.json())
    .then(data => {
      const itensAjustados = data.map(item => ({
        cfop: '5101',
        codigo: item.id,
        unidade: 'UN',
        descricao: item.produto_nome,
        quantidade: item.quantidade,
        valor_unitario: item.preco_unitario,
      }));

      // Faça a solicitação para obter os dados do cliente usando a rota show
      fetch('/cadastro/show/' + pedidoId)
        .then(response => response.json())
        .then(clienteData => {
          // Crie o objeto pedido e preencha com os dados do cliente e itens ajustados
          const pedido = {
            pedido: {
              data_pedido: dataVenda,
              cliente: {
                ie: '',
                uf: 'SP',
                cep: '05814-550',
                fone: '(11)97708-2713',
                nome: 'Leoncio da Silva',
                email: 'leoncionho@gmail.com',
                bairro: 'São Bento',
                cidade: 'Rio de Janeiro',
                numero: '484',
                cpf_cnpj: '372.016.016-50',
                endereco: 'Rua Leoncio Osório',
                complemento: '',
                tipo_pessoa: 'F',
                atualizar_cliente: 'N',
              },
              itens: itensAjustados,
              parcelas: [
                {
                  obs: 'Paid via Mercado Pago',
                  data: '23/05/2022',
                  dias: '0',
                  valor: '198.00',
                  meio_pagamento: 'Mercado Pago',
                  forma_pagamento: 'Mercado Pago',
                },
              ],
              situacao: 'Aberto',
              marcadores: [
                {
                  descricao: 'carolgrizostomo',
                },
              ],
              data_pedido: '23/05/2022',
              forma_envio: 'N',
              id_vendedor: '733117945',
              valor_frete: '0.00',
              obs_internas: 'Vendedora: Carol Grizostomo',
              data_prevista: '23/05/2022',
              nome_vendedor: 'Carol Grizostomo',
              valor_desconto: '0',
              forma_pagamento: 'Mercado Pago',
              frete_por_conta: 'E',
              endereco_entrega: {
                ie: '',
                uf: 'SP',
                cep: '05814-110',
                fone: '(11)97708-2713',
                nome: 'Gabriel Camilo',
                email: 'contatolotassp@gmail.com',
                bairro: 'Jardim Ibirapuera',
                cidade: 'São Paulo',
                numero: '371',
                cpf_cnpj: '372.098.458-36',
                endereco: 'Rua Aldeia de Joanes',
                complemento: '',
                tipo_pessoa: 'F',
              },
              nome_transportador: '',
              numero_ordem_compra: '431953',
              numero_pedido_ecommerce: '4288879263840',
            },
          };

          // Converte o objeto para o formato x-www-form-urlencoded
          const formData = new URLSearchParams();
          formData.append('token', 'bc3cdea243d8687963fa642580057531456d34fa');
          formData.append('formato', 'json');
          formData.append('pedido', JSON.stringify(pedido.pedido));

          // Faça a requisição POST para salvar o pedido com os produtos e dados do cliente
          fetch('/criar-pedido-tiny', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString(),
          })
            .then(response => response.json())
            .then(data => {
              // Lide com a resposta da API aqui
              console.log('Resposta da API:', data);
              // Exemplo de exibição de mensagem de sucesso
              alert('Pedido salvo com sucesso!');
            })
            .catch(error => {
              // Lide com erros de requisição aqui
              console.error('Erro na requisição POST:', error);
              // Exemplo de exibição de mensagem de erro
              alert('Erro ao salvar o pedido. Por favor, tente novamente.');
            });
        })
        .catch(error => {
          // Lide com erros de requisição aqui
          console.error('Erro ao obter dados do cliente:', error);
          // Exemplo de exibição de mensagem de erro
          alert('Erro ao obter os dados do cliente. Por favor, tente novamente.');
        });
    })
    .catch(error => {
      // Lide com erros de requisição aqui
      console.error('Erro ao obter produtos do pedido:', error);
      // Exemplo de exibição de mensagem de erro
      alert('Erro ao obter os produtos do pedido. Por favor, tente novamente.');
    });
}





// Evento de clique no botão "Confirmar Pedido"
document.addEventListener('click', function(event) {
  if (event.target.classList.contains('btn-confirmar-pedido')) {
    // Obtenha o ID do pedido a partir do atributo data-pedido-id
    
  }
});

document.addEventListener("DOMContentLoaded", function() {
  $(".btn-confirmar-pedido").click(function() {
    const pedidoId = $(this).closest(".pedido-row").data("pedido-id");
    const dataVenda = $(this).closest(".pedido-row").find("td:nth-child(10)").text();

    // Chame a função para salvar o pedido
    salvarPedido(pedidoId,dataVenda);
  });

  const btnConsultarListaUniforme = document.getElementsByClassName('btn-consultar-lista-uniforme');
  for (let i = 0; i < btnConsultarListaUniforme.length; i++) {
    btnConsultarListaUniforme[i].addEventListener('click', function() {
      const pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
      fetch('/gerarLinkListaProduto/' + pedidoId)
        .then(response => response.json())
        .then(data => {
          alert('link temporario: ' + data.link);
        });
    });
  }

  const btnSalvarConsultarCliente = document.getElementsByClassName('btn-salvar-consultar-cliente');
  for (let i = 0; i < btnSalvarConsultarCliente.length; i++) {
    btnSalvarConsultarCliente[i].addEventListener('click', function() {
      const pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
      fetch('/gerarLinkCadastroCliente?pedidoId=' + pedidoId)
        .then(response => response.json())
        .then(data => {
          alert('link temporario: ' + data.link);
        });
    });
  }

  // Adicione o evento de alteração para os campos de entrada de sexo, pacote, camisa, calção, etc.
  var inputSexo   = document.querySelectorAll('.input-sexo');
  var inputPacote = document.querySelectorAll('.input-pacote');
  var inputCamisa = document.querySelectorAll('.input-camisa');
  var inputCalcao = document.querySelectorAll('.input-calcao');

  inputSexo.forEach(function(input) {
    input.addEventListener('change', function() {
      var pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
      var produtoId = this.closest('.produto-dados').getAttribute('data-produto-id');
      var novoSexo = this.value;
      // Faça a requisição AJAX para atualizar o sexo do produto
      fetch('/pedidoInterno/atualizar-sexo-produto/' + pedidoId + '/' + produtoId, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ sexo: novoSexo }),
      })
      .then(function(response) {
        console.log('Sexo atualizado com sucesso!');
      })
      .catch(function(error) {
        console.log('Ocorreu um erro:', error);
      });
    });
  });

  inputPacote.forEach(function(input) {
    input.addEventListener('change', function() {
      var pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
      var produtoId = this.closest('.produto-dados').getAttribute('data-produto-id');
      var novoPacote = this.value;
      // Faça a requisição AJAX para atualizar o pacote do produto
      fetch('/pedidoInterno/atualizar-pacote-produto/' + pedidoId + '/' + produtoId, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ pacote: novoPacote }),
      })
      .then(function(response) {
        console.log('Pacote atualizado com sucesso!');
      })
      .catch(function(error) {
        console.log('Ocorreu um erro:', error);
      });
    });
  });

  inputCamisa.forEach(function(input) {
    input.addEventListener('change', function() {
      var pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
      var produtoId = this.closest('.produto-dados').getAttribute('data-produto-id');
      var novaCamisa = this.value;
      // Faça a requisição AJAX para atualizar a camisa do produto
      fetch('/pedidoInterno/atualizar-camisa-produto/' + pedidoId + '/' + produtoId, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ camisa: novaCamisa }),
      })
      .then(function(response) {
        console.log('Camisa atualizada com sucesso!');
      })
      .catch(function(error) {
        console.log('Ocorreu um erro:', error);
      });
    });
  });

  inputCalcao.forEach(function(input) {
    input.addEventListener('change', function() {
      var pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
      var produtoId = this.closest('.produto-dados').getAttribute('data-produto-id');
      var novoCalcao = this.value;
      // Faça a requisição AJAX para atualizar o calção do produto
      fetch('/pedidoInterno/atualizar-calcao-produto/' + pedidoId + '/' + produtoId, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ calcao: novoCalcao }),
      })
      .then(function(response) {
        console.log('Calção atualizado com sucesso!');
      })
      .catch(function(error) {
        console.log('Ocorreu um erro:', error);
      });
    });
  });
});
// Estilização da tabela, não mexer
const smallBreak = 800;
$(document).ready(shapeTable);
$(window).resize(shapeTable);
function shapeTable() {
  if ($(window).width() < smallBreak) {
    const rows = $('.dataTable tr').length;
    const columns = $('.dataTable th').length;
    for (let i = 0; i < columns; i++) {
      let maxHeight = $('.dataTable th:nth-child(' + (i + 1) + ')').outerHeight();
      for (let j = 0; j < rows; j++) {
        const td = $('.dataTable tr:nth-child(' + (j + 1) + ') td:nth-child(' + (i + 1) + ')');
        const tdHeight = td.outerHeight();
        const tdScrollHeight = td.prop('scrollHeight');
        if (tdHeight > maxHeight) {
          maxHeight = tdHeight;
        }
        if (tdScrollHeight > tdHeight) {
          maxHeight = tdScrollHeight;
        }
      }
      $('.dataTable th:nth-child(' + (i + 1) + ')').css('height', maxHeight);
      $('.dataTable td:nth-child(' + (i + 1) + ')').css('height', maxHeight);
    }
  } else {
    $('.dataTable td, .dataTable th').removeAttr('style');
  }
}
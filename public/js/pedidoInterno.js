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
function confirmarLink(link) {
  var confirmacao = confirm("Deseja ir para o link: " + link.href + "?");
  if (confirmacao) {
      return true; // Continua para o link
  } else {
      return false; // Cancela o evento de clique
  }
}
function salvarPedido(pedidoId, dataVenda) {
  // Primeira requisição para obter produtos do pedido
  fetch('/pedidoInterno/get-produtos-pedido/' + pedidoId)
      .then(response => response.json())
      .then(data => {
          // Obtenha o nome do primeiro produto da lista
          const nomeDoProduto = data.length > 0 ? data[0].produto_nome : '';

          // Segunda requisição para obter dados do cliente
          fetch('/cadastro/show/' + pedidoId)
              .then(response => response.json())
              .then(clienteData => {
                  // Terceira requisição para buscar produto pelo nome
                  fetch(`/produto/buscar-por-nome/${nomeDoProduto}`)
                      .then(response => response.json())
                      .then(produtoEncontrado => {
                          if (produtoEncontrado) {
                              // Agora você tem o código do produto
                              const codigoDoProduto = produtoEncontrado.codigo;

                              // Construa a URL para a quarta requisição incluindo os parâmetros
                              const url = `https://artearena.kinghost.net/criar-pedido-tiny?codigoDoProduto=${codigoDoProduto}&descricao=Descrição do produto&valor_unitario=10.99&unidade=UN&quantidade=1&data_pedido=${dataVenda}`;

                              // Quarta requisição para salvar o pedido
                              fetch(url, {
                                  method: 'POST',
                                  headers: {
                                      'Content-Type': 'application/json',
                                  },
                              })
                                  .then(response => response.json())
                                  .then(data => {
                                      console.log('Resposta da API:', data);
                                      alert('Pedido salvo com sucesso!');
                                  })
                                  .catch(error => {
                                      console.error('Erro na requisição POST:', error);
                                      alert('Erro ao salvar o pedido. Por favor, tente novamente.');
                                  });
                          } else {
                              console.error('Produto não encontrado.');
                              alert('Produto não encontrado. Por favor, verifique o nome do produto.');
                          }
                      })
                      .catch(error => {
                          console.error('Erro ao buscar produto por nome:', error);
                          alert('Erro ao buscar produto por nome. Por favor, tente novamente.');
                      });
              })
              .catch(error => {
                  console.error('Erro ao obter dados do cliente:', error);
                  alert('Erro ao obter os dados do cliente. Por favor, tente novamente.');
              });
      })
      .catch(error => {
          console.error('Erro ao obter produtos do pedido:', error);
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


$(document).ready(function() {
  $('.btn-voltar-arte-final').click(function() {
    var pedidoId = $(this).closest('tr').data('id');
    Swal.fire({
        title: "Confirmar data?",
        showCancelButton: true,
        confirmButtonText: "Alterar",
        cancelButtonText: "Manter",
        html: '<input type="date" id="swal-date-picker" class="swal2-input">',
        preConfirm: function() {
            return document.getElementById('swal-date-picker').value;
        }
    }).then(function(result) {
        if (result.isConfirmed) {
            var data = result.value;
            // Aqui você pode fazer a requisição AJAX para atualizar os dados no servidor
            $.ajax({
                url: '/pedido/' + pedidoId,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    data: data,
                    status: 'Pendente'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Os dados foram atualizados.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Remove a linha da tabela
                    $(this).closest('tr').remove();
                },
                error: function(xhr, status, error) {
                    // Aqui você pode tratar o erro, se necessário
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Aqui você pode lidar com o cancelamento, se necessário
            // Fazer a requisição AJAX para manter o status atual
            $.ajax({
                url: '/pedido/' + pedidoId,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    status: 'Pendente'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Os dados foram atualizados.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Remove a linha da tabela
                    $(this).closest('tr').remove();
                },
                error: function(xhr, status, error) {
                    // Aqui você pode tratar o erro, se necessário
                }
            });
        }
    });
});

 
});
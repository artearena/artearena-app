// Selecione o botão "Expandir"
var botoesExpandir = document.querySelectorAll('.btn-expand-produtos');

// Adicione o evento de clique a todos os botões
botoesExpandir.forEach(function(botaoExpandir) {
  botaoExpandir.addEventListener('click', function() {
    // Obtenha o ID do pedido
    var pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');

    // Caso contrário, faça a requisição AJAX para obter a lista de produtos
    fetch('/pedidoInterno/get-produtos-pedido/' + pedidoId)
      .then(function(response) {
        return response.json();
      })
      .then(function(produtos) {
        // Construa o conteúdo da tabela e do modal
        var modalContent = '<div class="modal fade" id="produtoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        modalContent += '<div class="modal-dialog" role="document">';
        modalContent += '<div class="modal-content">';
        modalContent += '<div class="modal-header">';
        modalContent += '<h5 class="modal-title" id="exampleModalLabel">Detalhes do Produto</h5>';
        modalContent += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        modalContent += '<span aria-hidden="true">&times;</span>';
        modalContent += '</button>';
        modalContent += '</div>';
        modalContent += '<div class="modal-body">';
        modalContent += '<div class="table-responsive">';
        modalContent += '<table class="table">';
        modalContent += '<thead><tr><th>Produto</th><th>Quantidade</th><th>Sexo</th><th>Arte Aprovada</th><th>Lista Aprovada</th><th>Pacote</th><th>Camisa</th><th>Calção</th><th>Meião</th><th>Nome</th><th>Número</th><th>Tamanho</th><th>ID Lista</th></tr></thead>';
        modalContent += '<tbody>';

        // Adicione os detalhes dos produtos à tabela e ao modal
        produtos.forEach(function(produto) {
          modalContent += '<tr>' +
            '<td contenteditable="true">' + (produto.produto_nome !== undefined ? produto.produto_nome : '') + '</td>' +
            '<td contenteditable="true">' + (produto.quantidade !== undefined ? produto.quantidade : '') + '</td>' +
            '<td contenteditable="true"><select class="form-control input-sexo">' +
            '<option value="M" ' + (produto.sexo === 'M' ? 'selected' : '') + '>M</option>' +
            '<option value="F" ' + (produto.sexo === 'F' ? 'selected' : '') + '>F</option>' +
            '</select></td>' +
            '<td contenteditable="true">' + (produto.arte_aprovada !== undefined ? produto.arte_aprovada : '') + '</td>' +
            '<td contenteditable="true"><select class="form-control input-lista-aprovada">' +
            '<option value="sim" ' + (produto.lista_aprovada === 'sim' ? 'selected' : '') + '>Sim</option>' +
            '<option value="não" ' + (produto.lista_aprovada === 'não' ? 'selected' : '') + '>Não</option>' +
            '</select></td>' +
            '<td contenteditable="true"><select class="form-control input-pacote">' +
            '<option value="start" ' + (produto.pacote === 'start' ? 'selected' : '') + '>Start</option>' +
            '<option value="prata" ' + (produto.pacote === 'prata' ? 'selected' : '') + '>Prata</option>' +
            '<option value="ouro" ' + (produto.pacote === 'ouro' ? 'selected' : '') + '>Ouro</option>' +
            '<option value="diamante" ' + (produto.pacote === 'diamante' ? 'selected' : '') + '>Diamante</option>' +
            '<option value="premium" ' + (produto.pacote === 'premium' ? 'selected' : '') + '>Premium</option>' +
            '<option value="profissional" ' + (produto.pacote === 'profissional' ? 'selected' : '') + '>Profissional</option>' +
            '</select></td>' +
            '<td contenteditable="true"><input type="checkbox" ' + (produto.camisa !== undefined ? 'checked' : '') + ' class="input-camisa"></td>' +
            '<td contenteditable="true"><input type="checkbox" ' + (produto.calcao !== undefined ? 'checked' : '') + ' class="input-calcao"></td>' +
            '<td contenteditable="true"><input type="checkbox" ' + (produto.meiao !== undefined ? 'checked' : '') + ' class="input-meiao"></td>' +
            '<td contenteditable="true">' + (produto.nome !== undefined ? produto.nome : '') + '</td>' +
            '<td contenteditable="true">' + (produto.numero !== undefined ? produto.numero : '') + '</td>' +
            '<td contenteditable="true"><select class="form-control input-tamanho">' +
            '<option value="P" ' + (produto.tamanho === 'P' ? 'selected' : '') + '>P</option>' +
            '<option value="M" ' + (produto.tamanho === 'M' ? 'selected' : '') + '>M</option>' +
            '<option value="G" ' + (produto.tamanho === 'G' ? 'selected' : '') + '>G</option>' +
            '<option value="GG" ' + (produto.tamanho === 'GG' ? 'selected' : '') + '>GG</option>' +
            '<option value="XG" ' + (produto.tamanho === 'XG' ? 'selected' : '') + '>XG</option>' +
            '<option value="XGG" ' + (produto.tamanho === 'XGG' ? 'selected' : '') + '>XGG</option>' +
            '<option value="XGGG" ' + (produto.tamanho === 'XGGG' ? 'selected' : '') + '>XGGG</option>' +
            '</select></td>' +
            '<td contenteditable="true">' + (produto.id_lista !== undefined ? produto.id_lista : '') + '</td>' +
            '</tr>';
        });

        modalContent += '</tbody></table>';
        modalContent += '</div>';
        modalContent += '</div>';
        modalContent += '<div class="modal-footer">';
        modalContent += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
        modalContent += '</div>';
        modalContent += '</div>';
        modalContent += '</div>';
        modalContent += '</div>';

        // Inclua o modal no corpo do documento
        document.body.insertAdjacentHTML('beforeend', modalContent);

        // Ative o modal
        $('#produtoModal').modal('show');
      })
      .catch(function(error) {
        console.log('Ocorreu um erro:', error);
      });
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
function formatarData(data) {
  var dataObjeto = new Date(data);
  var dia = dataObjeto.getDate();
  var mes = dataObjeto.getMonth() + 1; // Lembrando que os meses em JavaScript são indexados a partir de 0
  var ano = dataObjeto.getFullYear();

  // Adiciona zeros à esquerda se necessário
  if (dia < 10) {
    dia = '0' + dia;
  }
  if (mes < 10) {
    mes = '0' + mes;
  }

  return dia + '/' + mes + '/' + ano;
}
function salvarPedido(pedidoId, dataVenda, marcadorValue, dataEnvio) {
  // Primeira requisição para obter produtos do pedido
  var dataVenda = formatarData(dataVenda);
  var dataEnvio = formatarData(dataEnvio);
  fetch('/pedidoInterno/get-produtos-pedido/' + pedidoId)
    .then(response => response.json())
    .then(data => {
      if (data.length === 0) {
        console.error('Nenhum produto encontrado no pedido.');
        Swal.fire('Erro', 'Nenhum produto encontrado no pedido. Por favor, adicione produtos ao pedido.', 'error');
        return;
      }
      // Mapeia a lista de produtos do pedido para obter códigos de todos os produtos
      const promessasProdutos = data.map(produtoPedido => {
        // Segunda requisição para buscar produto pelo nome
        return fetch('/produto/buscar-por-nome/' + produtoPedido.produto_nome)
          .then(response => response.json())
          .then(produtoEncontrado => {
            if (produtoEncontrado) {
              // Retorna um objeto com as informações necessárias do produto
              return {
                codigo: produtoEncontrado.CODIGO, // Ajuste para usar o código do produto
                descricao: produtoEncontrado.NOME, // Adicione outros campos do produto conforme necessário
                valor_unitario: parseFloat(produtoEncontrado.PRECO), // Converta para número, se necessário
                quantidade: produtoPedido.quantidade,
              };
            } else {
              console.error(`Produto não encontrado: ${produtoPedido.produto_nome}`);
              Swal.fire('Erro', `Produto não encontrado: ${produtoPedido.produto_nome}. Por favor, verifique o nome do produto.`, 'error');
              return null;
            }
          })
          .catch(error => {
            console.error('Erro ao buscar produto por nome:', error);
            Swal.fire('Erro', 'Erro ao buscar produto por nome. Por favor, tente novamente.', 'error');
            return null;
          });
      });
      // Aguarda todas as promessas serem resolvidas
      Promise.all(promessasProdutos)
        .then(produtosValidos => {
          // Filtra os produtos encontrados, removendo os nulos
          const produtosFiltrados = produtosValidos.filter(produto => produto !== null);
          // Terceira requisição para obter dados do cliente
          fetch('/cadastro/show/' + pedidoId)
            .then(response => response.json())
            .then(clienteData => {
              const pedidoData = {
                pedido: {
                  cliente: {
                    nome: clienteData.nome_completo || clienteData.razao_social || '',
                    tipo_pessoa: clienteData.tipo_pessoa,
                    cpf_cnpj: clienteData.cpf || clienteData.cnpj || '',
                    rg: clienteData.rg,
                    email: clienteData.email,
                    endereco: clienteData.endereco,
                    cep: clienteData.cep,
                    numero: clienteData.numero,
                    bairro: clienteData.bairro,
                    cidade: clienteData.cidade,
                    fone: clienteData.fone_fixo,
                  },
                  itens: produtosFiltrados.map(produto => {
                    return {
                      item: {
                        codigo: produto.codigo,
                        descricao: produto.descricao,
                        valor_unitario: produto.valor_unitario,
                        unidade: 'UN',
                        quantidade: produto.quantidade,
                      },
                    };
                  }),
                  marcadores: [
                    {
                      marcador: {
                        id: 1, // ID do marcador
                        descricao: marcadorValue, // Valor do marcador selecionado
                      },
                    },
                  ],
                  data_pedido: dataVenda,
                  data_prevista: dataEnvio,
                },
              };
              console.log(pedidoData);
              
              fetch('https://artearena.kinghost.net/criar-pedido-tiny', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify(pedidoData),
              })
                .then(response => response.json())
                .then(data => {
                  console.log('Resposta da API:', data);
                  if (data.status === "OK" && data.registros.registro.status === "OK") {
                    Swal.fire('Sucesso', 'Pedido salvo com sucesso!', 'success');
                  } else {
                    throw new Error('Erro ao salvar o pedido. Por favor, tente novamente.');
                  }
                })
                .catch(error => {
                  console.error('Erro na requisição POST:', error);
                  Swal.fire('Erro', error.message, 'error');
                });
            })
            .catch(error => {
              console.error('Erro ao obter dados do cliente:', error);
              Swal.fire('Erro', 'Erro ao obter os dados do cliente. Por favor, tente novamente.', 'error');
            });
        })
        .catch(error => {
          console.error('Erro ao buscar códigos dos produtos:', error);
          Swal.fire('Erro', 'Erro ao buscar códigos dos produtos. Por favor, tente novamente.', 'error');
        });
    })
    .catch(error => {
      console.error('Erro ao obter produtos do pedido:', error);
      Swal.fire('Erro', 'Erro ao obter os produtos do pedido. Por favor, tente novamente.', 'error');
    });
}

    document.addEventListener("DOMContentLoaded", function() {
      $(".btn-confirmar-pedido").click(function() {
        const pedidoId = $(this).closest(".pedido-row").data("pedido-id");
        const marcadorValue = $(this).closest(".pedido-row").find("td:nth-child(9)").text();
        const dataVenda = $(this).closest(".pedido-row").find("td:nth-child(10)").text();
        Swal.fire({
          title: 'Confirmar Pedido',
          html: '<label for="data-envio">Data prevista</label><input type="date" id="data-envio" class="swal2-input">',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Confirmar',
          cancelButtonText: 'Cancelar',
          preConfirm: () => {
            const dataEnvio = document.getElementById('data-envio').value;
            if (!dataEnvio) {
              Swal.showValidationMessage('Por favor, selecione a data de envio');
            }
            return dataEnvio;
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const dataEnvio = result.value;
            salvarPedido(pedidoId, dataVenda, marcadorValue, dataEnvio);
          }
        });
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
          Swal.fire({
            title: 'Link temporário',
            text: data.link,
            showCancelButton: true,
            confirmButtonText: 'Copiar link',
            cancelButtonText: 'Fechar',
          }).then((result) => {
            if (result.isConfirmed) {
              // Copiar o link para a área de transferência
              const el = document.createElement('textarea');
              el.value = data.link;
              document.body.appendChild(el);
              el.select();
              document.execCommand('copy');
              document.body.removeChild(el);
              Swal.fire('Link copiado!', '', 'success');
            }
          });
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
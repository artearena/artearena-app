document.addEventListener('DOMContentLoaded', function() {
    var botoesExpandir = document.querySelectorAll('.btn-expand-produtos');
    botoesExpandir.forEach(function(botaoExpandir) {
        botaoExpandir.addEventListener('click', function() {
            var pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
            fetch('/pedidoInterno/get-produtos-pedido/' + pedidoId)
                .then(function(response) {
                    return response.json();
                })
                .then(function(produtos) {
                    var modalContent = document.createElement('div');
                    modalContent.className = 'modal fade';
                    modalContent.id = 'produtoModal';
                    modalContent.tabIndex = -1;
                    modalContent.setAttribute('role', 'dialog');
                    modalContent.setAttribute('aria-labelledby', 'exampleModalLabel');
                    modalContent.setAttribute('aria-hidden', 'true');
                    var modalDialog = document.createElement('div');
                    modalDialog.className = 'modal-dialog modal-xl';
                    modalDialog.setAttribute('role', 'document');
                    var modalContentDiv = document.createElement('div');
                    modalContentDiv.className = 'modal-content';
                    var modalHeader = document.createElement('div');
                    modalHeader.className = 'modal-header';
                    var modalTitle = document.createElement('h5');
                    modalTitle.className = 'modal-title';
                    modalTitle.id = 'exampleModalLabel';
                    modalTitle.innerText = 'Detalhes do Produto';
                    var closeButton = document.createElement('button');
                    closeButton.type = 'button';
                    closeButton.className = 'close';
                    closeButton.setAttribute('data-dismiss', 'modal');
                    closeButton.setAttribute('aria-label', 'Close');
                    var closeSpan = document.createElement('span');
                    closeSpan.setAttribute('aria-hidden', 'true');
                    closeSpan.innerHTML = '×';
                    closeButton.appendChild(closeSpan);
                    modalHeader.appendChild(modalTitle);
                    modalHeader.appendChild(closeButton);
                    var modalBody = document.createElement('div');
                    modalBody.className = 'modal-body';
                    var tableResponsive = document.createElement('div');
                    tableResponsive.className = 'table-responsive';
                    var table = document.createElement('table');
                    table.className = 'table';
                    var thead = document.createElement('thead');
                    var tr = document.createElement('tr');
                    var thNomeProduto = document.createElement('th');
                    thNomeProduto.innerText = 'Nome do Produto';
                    tr.appendChild(thNomeProduto);
                    var thQuantidade = document.createElement('th');
                    thQuantidade.innerText = 'Quantidade';
                    tr.appendChild(thQuantidade);
                    var thCategoria = document.createElement('th');
                    thCategoria.innerText = 'Categoria';
                    tr.appendChild(thCategoria);
                    var thArteAprovada = document.createElement('th');
                    thArteAprovada.innerText = 'Arte Aprovada';
                    tr.appendChild(thArteAprovada);
                    var thListaAprovada = document.createElement('th');
                    thListaAprovada.innerText = 'Lista Aprovada';
                    tr.appendChild(thListaAprovada);
                    var thPacote = document.createElement('th');
                    thPacote.innerText = 'Pacote';
                    tr.appendChild(thPacote);
                    var thCamisa = document.createElement('th');
                    thCamisa.innerText = 'Camisa';
                    tr.appendChild(thCamisa);
                    var thCalcao = document.createElement('th');
                    thCalcao.innerText = 'Calção';
                    tr.appendChild(thCalcao);
                    var thMeiao = document.createElement('th');
                    thMeiao.innerText = 'Meião';
                    tr.appendChild(thMeiao);
                   /*  var thNomeJogador = document.createElement('th');
                    thNomeJogador.innerText = 'Nome do Jogador';
                    tr.appendChild(thNomeJogador); */
/*                     var thNumero = document.createElement('th');
                    thNumero.innerText = 'Número';
                    tr.appendChild(thNumero);
                    var thTamanho = document.createElement('th');
                    thTamanho.innerText = 'Tamanho';
                    tr.appendChild(thTamanho); */
                    thead.appendChild(tr);
                    table.appendChild(thead);
                    var tbody = document.createElement('tbody');
                    produtos.forEach(function(produto) {
                        var tr = document.createElement('tr');
                        var tdNome = criarCelulaEditavel(produto, 'produto_nome', pedidoId);
                        tr.appendChild(tdNome);
                        var tdQuantidade = criarCelulaEditavel(produto, 'quantidade', pedidoId);
                        tr.appendChild(tdQuantidade);
                        if (ehVestuario(produto.produto_nome)) {
                            var tdCategoria = criarCelulaSelecionavel(produto, 'categoria', ['Masculino', 'Feminino', 'Infantil'], pedidoId);
                            tr.appendChild(tdCategoria);
                            var tdArteAprovada = criarCelulaEditavel(produto, 'arte_aprovada', pedidoId);
                            tr.appendChild(tdArteAprovada);
                            var tdListaAprovada = criarCelulaSelecionavel(produto, 'lista_aprovada', ['sim', 'não'], pedidoId);
                            tr.appendChild(tdListaAprovada);
                            tr.appendChild(criarCelulaSelecionavel(produto, 'pacote', ['Start', 'Prata', 'Ouro', 'Diamante', 'Premium', 'Profissional'], pedidoId));
                            var tdCamisa = criarCelulaCheckbox(produto, 'camisa', pedidoId);
                            tr.appendChild(tdCamisa);
                            var tdCalcao = criarCelulaCheckbox(produto, 'calcao', pedidoId);
                            tr.appendChild(tdCalcao);
                            var tdMeiao = criarCelulaCheckbox(produto, 'meiao', pedidoId);
                            tr.appendChild(tdMeiao);
/*                             var tdNomeJogador = criarCelulaEditavel(produto, 'nome_jogador', pedidoId);
                            tr.appendChild(tdNomeJogador); */
/*                             var tdNumero = criarCelulaEditavel(produto, 'numero', pedidoId);
                            tr.appendChild(tdNumero);
                            var tdTamanho = criarCelulaSelecionavel(produto, 'tamanho', ['P', 'M', 'G', 'GG', 'XG', 'XGG', 'XGGG'], pedidoId);
                            tr.appendChild(tdTamanho); */
                        }
                        tbody.appendChild(tr);
                    });
                    table.appendChild(tbody);
                    tableResponsive.appendChild(table);
                    modalBody.appendChild(tableResponsive);
                    modalContentDiv.appendChild(modalHeader);
                    modalContentDiv.appendChild(modalBody);
                    var modalFooter = document.createElement('div');
                    modalFooter.className = 'modal-footer';
                    var closeButtonFooter = document.createElement('button');
                    closeButtonFooter.type = 'button';
                    closeButtonFooter.className = 'btn btn-secondary';
                    closeButtonFooter.setAttribute('data-dismiss', 'modal');
                    closeButtonFooter.innerText = 'Fechar';
                    modalFooter.appendChild(closeButtonFooter);
                    modalContentDiv.appendChild(modalFooter);
                    modalDialog.appendChild(modalContentDiv);
                    modalContent.appendChild(modalDialog);
                    document.body.insertAdjacentElement('beforeend', modalContent);
                    $('#produtoModal').modal('show');
                })
                .catch(function(error) {
                    console.log('Ocorreu um erro:', error);
                });
        });
    });
});

function criarCelulaEditavel(produto, campo, pedidoId) {
  var td = document.createElement('td');
  td.contentEditable = 'true';
  td.innerText = produto[campo] || '';
  td.addEventListener('input', function() {
    atualizarCampoProduto(pedidoId, produto.id, campo, this.innerText);
  });
  return td;
}

function criarCelulaSelecionavel(produto, campo, opcoes, pedidoId) {
  var td = document.createElement('td');
  var select = document.createElement('select');
  select.className = 'form-control';
  opcoes.forEach(function(opcao) {
    var option = document.createElement('option');
    option.value = opcao;
    option.innerText = opcao;
    option.selected = produto[campo] === opcao;
    select.appendChild(option);
  });
  select.addEventListener('change', function() {
    atualizarCampoProduto(pedidoId, produto.id, campo, this.value);
  });
  td.appendChild(select);
  return td;
}

function criarCelulaCheckbox(produto, campo, pedidoId) {
  var td = document.createElement('td');
  var input = document.createElement('input');
  input.type = 'checkbox';
  input.checked = produto[campo];
  input.addEventListener('change', function() {
    atualizarCampoProduto(pedidoId, produto.id, campo, this.checked);
  });
  td.appendChild(input);
  return td;
}

function atualizarCampoProduto(pedidoId, produtoId, campo, novoValor) {
  fetch('/pedidoInterno/atualizar-produto/' + pedidoId + '/' + produtoId, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    body: JSON.stringify({ campo: campo, valor: novoValor })
  })
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Erro ao atualizar produto:', error));
}

function normalize(text) {
  text = text.toLowerCase();
  text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
  return text;
}

function ehVestuario($nomeProduto) {
  $vestuario = [
    "Camisa Personalizada", "Boné Premium Personalizado", "Chinelo Slide Personalizado",
    "Chinelo Adulto Personalizado", "Abadá Personalizado", "Camiseta Personalizada",
    "Toalha Personalizada", "Colete Personalizado", "Sacochila Personalizada",
    "Braçadeira Personalizada", "Máscara Personalizada", "Máscara Caveira",
    "Máscara Pikachu", "Máscara o Máskara", "Máscara La Casa de Papel",
    "Máscara Homem Aranha", "Máscara Arlequina Coringa", "Máscara Et Alien",
    "Máscara Girl Power", "Máscara Girl Power - Rosa", "Máscara Girl Power - Branco",
    "Máscara Girl Power - Preto", "Máscara Good Vibes", "Máscara LGBT",
    "Máscara Oncinha", "Máscara Resiliência", "Máscara Resiliência - Rosa",
    "Máscara Resiliência - Preto", "Máscara Coringa", "Máscara Brasil",
    "Samba Canção Personalizado", "Roupão Personalizado", "Doleira",
    "Shorts Doll Personalizado", "Balaclava Personalizada"
  ];

  var $nomeProdutoNormalizado = normalize($nomeProduto);

  for (var i = 0; i < $vestuario.length; i++) {
    var $item = normalize($vestuario[i]);

    if ($nomeProdutoNormalizado.includes($item)) {
      return true;
    }
  }

  return false;
}

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
          Swal.fire({
            title: 'Link temporário',
            text: data.link,
            icon: 'info',
            showCancelButton: false,
            showConfirmButton: false,
            html: `
              <div>
                <p>${data.link}</p>
                <button id="copiar-link-btn" class="btn btn-primary">Copiar Link</button>
              </div>
            `,
            customClass: {
              content: 'text-center', // Alinha o conteúdo ao centro
            },
          });

          // Adicionar evento de clique ao botão "Copiar Link"
          const copiarLinkBtn = document.getElementById('copiar-link-btn');
          copiarLinkBtn.addEventListener('click', function() {
            const el = document.createElement('textarea');
            el.value = data.link;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            Swal.fire('Link copiado!', '', 'success');
          });
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
            icon: 'info', // Adicione o ícone aqui (por exemplo, 'info', 'warning', 'error', 'success', etc.)
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
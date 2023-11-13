console.log('teste-debug');
// Selecione o botão "Expandir"
var botoesExpandir = document.querySelectorAll('.btn-expand-produtos');
// Adicione o evento de clique a todos os botões
botoesExpandir.forEach(function(botaoExpandir) {
  botaoExpandir.addEventListener('click', function() {
    console.log('testado');
    // Obtenha a linha do pedido
    var pedidoRow = this.closest('.pedido-row');
    // Obtenha o ID do pedido
    var pedidoId = pedidoRow.getAttribute('data-pedido-id');
    // Verifique se a linha de produtos já está visível
    var produtosRow = document.querySelector('.produto-pedido-' + pedidoId);
    if (produtosRow) {
      // Se já estiver visível, oculte a linha de produtos
      produtosRow.style.display = 'none';
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
            var linhaProduto = document.createElement('p');
            linhaProduto.innerHTML = '<strong>Produto:</strong> ' + produto.produto_nome + '<br>' +
                                     '<strong>Quantidade:</strong> ' + produto.quantidade + '<br>' +
                                     '<strong>Sexo:</strong> ' + produto.sexo + '<br>' +
                                     '<strong>Arte Aprovada:</strong> ' + produto.arte_aprovada + '<br>' +
                                     '<strong>Lista Aprovada:</strong> ' + produto.lista_aprovada + '<br>' +
                                     '<strong>Pacote:</strong> ' + produto.pacote + '<br>' +
                                     '<strong>Camisa:</strong> ' + produto.camisa + '<br>' +
                                     '<strong>Calção:</strong> ' + produto.calcao + '<br>' +
                                     '<strong>Meião:</strong> ' + produto.meiao + '<br>' +
                                     '<strong>Nome:</strong> ' + produto.nome + '<br>' +
                                     '<strong>Número:</strong> ' + produto.numero + '<br>' +
                                     '<strong>Tamanho:</strong> ' + produto.tamanho + '<br>' +
                                     '<strong>ID Lista:</strong> ' + produto.id_lista;
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

document.addEventListener("DOMContentLoaded", function() {
  $(".btn-confirmar-pedido").click(function() {
    const pedidoId = $(this).closest(".pedido-row").data("pedido-id");
    console.log("Confirmar pedido ID:", pedidoId);
  });

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
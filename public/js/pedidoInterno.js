console.log('teste-debug');
// Selecione o botão "Expandir"
var botoesExpandir = document.querySelectorAll('.btn-expand-produtos');
// Adicione o evento de clique a todos os botões
botoesExpandir.forEach(function(botaoExpandir) {
  botaoExpandir.addEventListener('click', function() {
    // Obtenha o ID do pedido
    var pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
    // Faça a requisição AJAX para obter a lista de produtos
    fetch('/crm/get-produtos-pedido/' + pedidoId)
      .then(function(response) {
        return response.json();
      })
      .then(function(produtos) {
        // Selecione a tabela onde você deseja adicionar as linhas dos produtos
        var tabelaProdutos = document.getElementById('tabela-produtos');
        // Limpe a tabela de produtos antes de adicionar novas linhas
        tabelaProdutos.innerHTML = '';
        // Verifique se é um único produto ou uma lista de produtos
        if (Array.isArray(produtos)) {
          // Caso seja uma lista de produtos
          produtos.forEach(function(produto) {
            var novaLinha = tabelaProdutos.insertRow();
            var novaCelula = novaLinha.insertCell();
            novaCelula.textContent = produto.produto_nome;
          });
        } else {
          // Caso seja um único produto
          var novaLinha = tabelaProdutos.insertRow();
          var novaCelula = novaLinha.insertCell();
          novaCelula.textContent = produtos.produto_nome;
        }
      })
      .catch(function(error) {
        console.log('Ocorreu um erro:', error);
      });
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
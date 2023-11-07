console.log('teste-debug');
document.addEventListener("DOMContentLoaded", function() {
    console.log('doc_ready');
    // Obtém uma referência a todos os botões "Expandir"
    const btnExpandirProdutos = document.querySelectorAll('.btn-expand-produtos');

    // Adiciona um ouvinte de evento para o clique de cada botão
    btnExpandirProdutos.forEach(function(btn) {
      btn.addEventListener('click', function() {
        // Obtém o ID do pedido correspondente a esta linha
        const pedidoId = this.dataset.pedidoId;

        // Obtém uma referência à célula da tabela que contém os produtos
        const produtosCell = document.querySelector(`#produtos-cell-${pedidoId}`);

        // Obtém uma referência ao elemento "tr" pai da célula dos produtos
        const pedidoRow = this.closest('.pedido-row');

        // Obtém uma referência à próxima linha "tr" que contém os produtos
        const produtosRow = pedidoRow.nextElementSibling;

        // Verifica se a linha de produtos já está visível
        const isExpanded = produtosRow.style.display === 'table-row';

        // Exibe ou oculta a linha de produtos com base no estado atual
        produtosRow.style.display = isExpanded ? 'none' : 'table-row';

        // Se a linha de produtos não estiver visível, exibe os produtos na célula da tabela
        if (!isExpanded) {
          // Aqui você pode escrever o código para exibir os produtos correspondentes ao pedido
          // Por exemplo, você pode criar uma lista de produtos e adicioná-la à célula da tabela

          // Exemplo de código para criar uma lista de produtos
          const produtos = ['produto1', 'produto2', 'produto3']; // Substitua isso pelos seus produtos reais
          const produtosList = document.createElement('ul');
          produtos.forEach(function(produto) {
            const produtoItem = document.createElement('li');
            produtoItem.textContent = produto;
            produtosList.appendChild(produtoItem);
          });

          // Limpa a célula da tabela antes de adicionar a lista de produtos
          produtosCell.innerHTML = '';
          produtosCell.appendChild(produtosList);
        }
      });
    });
    
    $(".btn-expand-produtos").click(function() {
      console.log('teste');
      var row = $(this).closest(".pedido-row");
      var produtosRow = row.next(".produtos-row");
      produtosRow.toggle();
    });
    $(".btn-confirmar-pedido").click(function() {
      console.log('teste');
      // Obter o ID do pedido
      var pedidoId = $(this).closest(".pedido-row").data("pedido-id");
      // Fazer algo com o ID do pedido, como enviar para o servidor
      console.log("Confirmar pedido ID:", pedidoId);
    });
    $(".btn-rejeitar-pedido").click(function() {
      // Obter o ID do pedido
      var pedidoId = $(this).closest(".pedido-row").data("pedido-id");
      // Fazer algo com o ID do pedido, como enviar para o servidor
      console.log("Rejeitar pedido ID:", pedidoId);
    });
    $(".btn-consultar-lista-uniforme").click(function() {
      var pedidoId = $(this).data("pedido-id");
      console.log("Consultar lista uniforme para o pedido ID:", pedidoId);
      // Aqui você pode fazer uma requisição AJAX para obter as informações da lista de uniformes para o pedido com o ID correspondente.
      // Em seguida, preencha o formulário no modal com as informações obtidas.
      // Exemplo de como preencher o formulário com informações fictícias:
      var form = $("#formListaUniforme");
      form.empty(); // Limpa o conteúdo anterior do formulário
      // Adicione campos ao formulário com as informações da lista de uniformes
      form.append('<div class="form-group"><label for="uniforme1">Uniforme 1:</label><input type="text" class="form-control" id="uniforme1" name="uniforme1"></div>');
      form.append('<div class="form-group"><label for="uniforme2">Uniforme 2:</label><input type="text" class="form-control" id="uniforme2" name="uniforme2"></div>');
      // ...
    });
    $("#btnSalvarListaUniforme").click(function() {
      // Aqui você pode obter os valores do formulário no modal e fazer uma requisição AJAX para salvar as informações da lista de uniformes no servidor.
      // Em seguida, atualize a tabela de pedidos ou faça outras ações necessárias.
      // Exemplo de como obter os valores do formulário:
      var uniforme1 = $("#uniforme1").val();
      var uniforme2 = $("#uniforme2").val();
      // ...
      console.log("Salvar lista uniforme:", uniforme1, uniforme2);
    });
    $(".btn-teste").click(function() {
      console.log("Botão Teste clicado");
      alert("Teste");
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    var btnSalvarConsultarCliente = document.getElementsByClassName('btn-salvar-consultar-cliente');
    for (var i = 0; i < btnSalvarConsultarCliente.length; i++) {
        btnSalvarConsultarCliente[i].addEventListener('click', function() {
            var pedidoId = this.closest('.pedido-row').getAttribute('data-pedido-id');
            fetch('/gerarLinkCadastroCliente?pedidoId=' + pedidoId)
                .then(response => response.json())
                .then(data => {
                    alert('link temporario: ' + data.link);
                });
        });
    }
});

console.log('teste');
var smallBreak = 800; // Your small screen breakpoint in pixels
var columns = $('.dataTable tr').length;
var rows = $('.dataTable th').length;

$(document).ready(shapeTable());
$(window).resize(function() {
    shapeTable();
});

function shapeTable() {
    if ($(window).width() < smallBreak) {
        for (i=0;i < rows; i++) {
            var maxHeight = $('.dataTable th:nth-child(' + i + ')').outerHeight();
            for (j=0; j < columns; j++) {
                if ($('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').outerHeight() > maxHeight) {
                    maxHeight = $('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').outerHeight();
                }
                if ($('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').prop('scrollHeight') > $('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').outerHeight()) {
                    maxHeight = $('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').prop('scrollHeight');
                }
            }
            for (j=0; j < columns; j++) {
                $('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').css('height',maxHeight);
                $('.dataTable th:nth-child(' + i + ')').css('height',maxHeight);
            }
        }
    } else {
        $('.dataTable td, .dataTable th').removeAttr('style');
    }
}

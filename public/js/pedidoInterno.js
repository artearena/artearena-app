console.log('teste-debug');

document.addEventListener("DOMContentLoaded", function() {
  console.log('doc_ready');

  // Função para exibir ou ocultar a linha de produtos
  function toggleProdutosRow(btn, pedidoId) {
    const produtosRow = document.querySelector(`.produtos-row[data-pedido-id="${pedidoId}"]`);
    if (produtosRow) {
      produtosRow.style.display = produtosRow.style.display === 'table-row' ? 'none' : 'table-row';
    }
  }

  // Função para exibir os produtos na célula da tabela
  function exibirProdutos(produtos, produtosCell) {
    const produtosList = document.createElement('ul');
    produtos.forEach(function(produto) {
      const produtoItem = document.createElement('li');
      produtoItem.textContent = produto.produto_nome;
      produtosList.appendChild(produtoItem);
    });

    produtosCell.appendChild(produtosList);
  }

  // Função para exibir ou ocultar o botão com o logotipo de camiseta
  function exibirBotaoCamiseta(btn, produto) {
    const palavrasChave = ["uniforme", "camiseta", "camisa", "short"];
    const temPalavraChave = palavrasChave.some(palavra => produto.toLowerCase().includes(palavra));

    if (temPalavraChave) {
      btn.style.display = "inline-block";
    } else {
      btn.style.display = "none";
    }
  }

  // Obtém uma referência a todos os botões "Expandir"
  const btnExpandirProdutos = document.querySelectorAll('.btn-expand-produtos');

  // Adiciona um ouvinte de evento para o clique de cada botão
  btnExpandirProdutos.forEach(function(btn) {
    btn.addEventListener('click', function() {
      const pedidoId = this.dataset.pedidoId;
      const produtosCell = document.querySelector(`#produtos-cell-${pedidoId}`);
      const pedidoRow = this.closest('.pedido-row');
      const produtosRow = pedidoRow.nextElementSibling;

      toggleProdutosRow(this, pedidoId);

      if (produtosRow.style.display !== 'table-row') {
        const produtos = JSON.parse(this.dataset.produtos);
        exibirProdutos(produtos, produtosCell);

        exibirBotaoCamiseta(this, produtos[0].produto_nome);
      }
    });
  });

  $(".btn-confirmar-pedido").click(function() {
    const pedidoId = $(this).closest(".pedido-row").data("pedido-id");
    console.log("Confirmar pedido ID:", pedidoId);
  });

  $(".btn-rejeitar-pedido").click(function() {
    const pedidoId = $(this).closest(".pedido-row").data("pedido-id");
    console.log("Rejeitar pedido ID:", pedidoId);
  });

  $(".btn-consultar-lista-uniforme").click(function() {
    const pedidoId = $(this).data("pedido-id");
    console.log("Consultar lista uniforme para o pedido ID:", pedidoId);

    // Aqui você pode fazer uma requisição AJAX para obter as informações da lista de uniformes para o pedido com o ID correspondente.
    // Em seguida, preencha o formulário no modal com as informações obtidas.
    // Exemplo de como preencher o formulário com informações fictícias:
    const form = $("#formListaUniforme");
    form.empty(); // Limpa o conteúdo anterior do formulário
    form.append('<div class="form-group"><label for="uniforme1">Uniforme 1:</label><input type="text" class="form-control" id="uniforme1" name="uniforme1"></div>');
    form.append('<div class="form-group"><label for="uniforme2">Uniforme 2:</label><input type="text" class="form-control" id="uniforme2" name="uniforme2"></div>');
    // ...
  });

  $("#btnSalvarListaUniforme").click(function() {
    // Aqui você pode obter os valores do formulário no modal e fazer uma requisição AJAX para salvar as informações da lista de uniformes no servidor.
    // Em seguida, atualize a tabela de pedidos ou faça outras ações necessárias.
    // Exemplo de como obter os valores do formulário:
    const uniforme1 = $("#uniforme1").val();
    const uniforme2 = $("#uniforme2").val();
    // ...
    console.log("Salvar lista uniforme:", uniforme1, uniforme2);
  });

  $(".btn-teste").click(function() {
    console.log("Botão Teste clicado");
    alert("Teste");
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

console.log('teste');

const smallBreak = 800; // Seu ponto de interrupção para telas pequenas em pixels

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
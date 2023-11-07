console.log('teste-debug');

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

console.log('teste');
// Estilização da tabela, não mexer
const smallBreak = 1200; 

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
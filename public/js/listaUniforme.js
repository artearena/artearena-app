document.addEventListener("DOMContentLoaded", function() {

    $(".btn-expand-produtos").click(function() {
      var row = $(this).closest(".pedido-row");
      var produtosRow = row.next(".produtos-row");
      produtosRow.toggle();
    });

    $(".btn-confirmar-pedido").click(function() {
      var pedidoId = $(this).closest(".pedido-row").data("pedido-id");
      console.log("Confirmar pedido ID:", pedidoId);
    });

    $(".btn-consultar-lista-uniforme").click(function() {
      var pedidoId = $(this).data("pedido-id");
      console.log("Consultar lista uniforme para o pedido ID:", pedidoId);
      var form = $("#formListaUniforme");
      form.empty();
      form.append('<div class="form-group"><label for="uniforme1">Uniforme 1:</label><input type="text" class="form-control" id="uniforme1" name="uniforme1"></div>');
      form.append('<div class="form-group"><label for="uniforme2">Uniforme 2:</label><input type="text" class="form-control" id="uniforme2" name="uniforme2"></div>');
    });

    $("#btnSalvarListaUniforme").click(function() {
      var uniforme1 = $("#uniforme1").val();
      var uniforme2 = $("#uniforme2").val();
      console.log("Salvar lista uniforme:", uniforme1, uniforme2);
    });
  });

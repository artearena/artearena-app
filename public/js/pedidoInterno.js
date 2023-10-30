console.log('teste-debug');
document.addEventListener("DOMContentLoaded", function() {
    console.log('doc_ready');
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
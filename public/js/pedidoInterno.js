console.log('to aqui');
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('btnCriarPedido').addEventListener('click', function(event) {
        event.preventDefault(); // Impede o comportamento padrão do botão
        console.log("ativei");
        var produtos = [];
        var rows = document.querySelectorAll("#produtosTableBody tr");
        rows.forEach(function(row) {
            var nomeProduto = row.querySelector('td:nth-child(1)').innerText;
            var quantidade = row.querySelector('td:nth-child(2)').innerText;
            var precoUnitario = row.querySelector('td:nth-child(3)').innerText;
            produtos.push({
                produto_nome: nomeProduto,
                quantidade: quantidade,
                preco_unitario: precoUnitario
            });
        });
        // Obter os valores dos outros campos do formulário
        var clienteId = document.getElementById("cliente_id").value;
        var vendedor = document.getElementById("vendedor").value;
        var formaPagamento = document.getElementById("forma_pagamento").value;
        var transportadora = document.getElementById("transportadora").value;
        var valorFrete = document.getElementById("valor_frete").value;
        var observacao = document.getElementById("observacao").value;
        var marcador = document.getElementById("marcador").value;
        var dataVenda = document.getElementById("data_venda").value;
        // Criar um objeto com os dados do pedido e produtos
        var pedido = {
            cliente_id: clienteId,
            vendedor: vendedor,
            forma_pagamento: formaPagamento,
            transportadora: transportadora,
            valor_frete: valorFrete,
            observacao: observacao,
            marcador: marcador,
            data_venda: dataVenda,
            produtos: produtos,
            id_orcamento: "{{ $orcamento->id_octa }}",
        };
        // Fazer a requisição AJAX para salvar o pedido
        $.ajax({
            url: "/pedidoInterno/criar",
            type: "POST",
            data: JSON.stringify(pedido),
            contentType: "application/json",
            success: function(data) {
                Swal.fire({
                    title: "Sucesso!",
                    text: "Pedido salvo com sucesso.",
                    icon: "success",
                    confirmButtonText: "OK"
                });
                console.log(data); // Exibir a resposta do servidor no console
                // Realizar outras ações após o sucesso da requisição
            },
            error: function(error) {
                Swal.fire({
                    title: "Erro!",
                    text: "Ocorreu um erro ao salvar o pedido.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                console.log(error); // Exibir o erro no console, se houver
                // Realizar ações de tratamento de erro, se necessário
            }
        });
    });
});
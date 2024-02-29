@extends('layout.main')

@section('title')
    Etapa do pedido
@endsection

@section('style')
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        /* Estilos CSS aqui */

        .resultado {
            display: none; /* Oculta a parte de resultado inicialmente */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: pop;
            src: url(https://fonts.gstatic.com/s/poppins/v15/pxiByp8kv8JHgFVrLDz8Z1xlFd2JQEk.woff2);
        }

        .main {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: pop;
            flex-direction: column;
        }

        /* Outros estilos aqui */
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="container mt-4">
            <h1>Consulta de Pedidos</h1>
            <div class="form-group">
                <label for="cpf_cnpj">CPF/CNPJ:</label>
                <input type="text" class="form-control" id="cpf_cnpj" placeholder="Digite o CPF/CNPJ">
            </div>
            <button id="consultarPedidosBtn" class="btn btn-primary">Consultar Pedidos</button>
        </div>

        <!-- Modal para exibir a lista de pedidos -->
        <div class="modal fade" id="listaPedidosModal" tabindex="-1" aria-labelledby="listaPedidosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="listaPedidosModalLabel">Lista de Pedidos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Data do Pedido</th>
                                    <th>Valor</th>
                                    <th>Situação</th>
                                    <th>Código de Rastreio</th>
                                    <th>Link do Rastreio</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="listaPedidosTableBody"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraScript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('consultarPedidosBtn').addEventListener('click', function() {
                const cpf_cnpj = document.getElementById('cpf_cnpj').value; // Obtém o valor do CPF/CNPJ digitado pelo usuário

                // Faça a requisição usando fetch para a rota do backend
                fetch('https://artearena.kinghost.net/consultar_pedido_cpf_cnpj', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ cpf_cnpj: cpf_cnpj })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao consultar pedidos');
                    }
                    return response.json();
                })
                .then(data => {
                    // Limpe a tabela de pedidos antes de exibir os resultados
                    const tableBody = document.getElementById('listaPedidosTableBody');
                    tableBody.innerHTML = '';

                    // Adicione um identificador único para cada linha da tabela
                    let rows = data.retorno.pedidos.map((pedido, index) => {
                        return { ...pedido, index };
                    });

                    // Classifique as linhas com base na data do pedido (da mais recente para a mais antiga)
                    rows.sort((a, b) => new Date(b.pedido.data_pedido) - new Date(a.pedido.data_pedido));

                    // Itere sobre os pedidos classificados e adicione-os à tabela
                    rows.forEach(row => {
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td>${row.pedido.id}</td>
                            <td>${row.pedido.data_pedido}</td>
                            <td>${row.pedido.valor}</td>
                            <td>${row.pedido.situacao}</td>
                            <td>${row.pedido.codigo_rastreamento}</td>
                            <td><a href="${row.pedido.url_rastreamento}" target="_blank">Link do Rastreio</a></td>
                            <td><button class="selecionarPedidoBtn btn btn-primary" data-id="${row.pedido.id}">Selecionar</button></td>
                        `;
                        tableBody.appendChild(newRow);
                    });

                    // Exiba o modal com a tabela de pedidos
                    $('#listaPedidosModal').modal('show');
                })
                .catch(error => {
                    // Manipule erros, se houver
                    console.error('Erro ao consultar pedidos:', error);
                });
            });

            // Manipula o evento de clique no botão "Selecionar"
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('selecionarPedidoBtn')) {
                    const idPedido = event.target.getAttribute('data-id');
                    // Faça alguma ação com o ID do pedido selecionado, como redirecionar para outra página
                    console.log('Pedido selecionado:', idPedido);
                }
            });
        });

    </script>
@endsection

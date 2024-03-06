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

        .status-exemplo {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
            /* Adicione mais estilos conforme necessário */
        }

        #exemplosStatusContainer {
            display: none; /* Oculta inicialmente, mostrado via JavaScript */
            flex-wrap: wrap; /* Permite que os itens se ajustem em várias linhas conforme necessário */
            gap: 10px; /* Espaço entre os itens */
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="container mt-4" id="consultarPedidoContainer">
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

        <div class="container mt-4" id="detalhesPedidoContainer" style="display: none;">
            <!-- Barra de status aqui -->
            <div id="statusBar" class="status-bar d-flex justify-content-around mb-3">
                <!-- Exemplos de status serão inseridos aqui via JavaScript -->
            </div>
            <button id="voltarBtn" class="btn btn-secondary mb-3">Voltar</button>
            <h2>Detalhes do Pedido</h2>
            <table class="table">
                <tbody id="detalhesPedidoTableBody"></tbody>
            </table>
        </div>
    </div>
    <!-- Modal Nota Fiscal -->
    <div id="modalNF" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Nota Fiscal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p id="idNotaFiscal">ID Nota Fiscal: </p>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal Detalhes do Pedido -->
    <div id="modalDetalhesPedido" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detalhes do Pedido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="corpoDetalhesPedido">
            <!-- Os detalhes do pedido serão adicionados aqui dinamicamente -->
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

                    // Itere sobre os pedidos retornados e adicione-os à tabela
                    data.retorno.pedidos.forEach(pedido => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${pedido.pedido.id}</td>
                            <td>${pedido.pedido.data_pedido}</td>
                            <td>R$ ${pedido.pedido.valor}</td>
                            <td>${pedido.pedido.situacao}</td>
                            <td>${pedido.pedido.codigo_rastreamento}</td>
                            <td><a href="${pedido.pedido.url_rastreamento}" target="_blank">Rastrear</a></td>
                            <td><button class="selecionarPedidoBtn btn btn-primary" data-id="${pedido.pedido.id}">Mais detalhes</button></td>
                        `;
                        tableBody.appendChild(row);
                    });

                    // Exiba o modal com a lista de pedidos
                    $('#listaPedidosModal').modal('show');
                })
                .catch(error => {
                    // Manipule erros, se houver
                    console.error('Erro ao consultar pedidos:', error);
                });
            });

            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('selecionarPedidoBtn')) {
                    const idPedido = event.target.getAttribute('data-id');

                    // Faz a requisição para obter os detalhes do pedido pelo ID
                    fetch(`https://artearena.kinghost.net/consultar-pedido-by-id?numeroPedido=${idPedido}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erro ao consultar detalhes do pedido');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Esconder o modal de lista de pedidos e preparar a exibição dos detalhes
                            $('#listaPedidosModal').modal('hide');
                            const detalhesContainer = document.getElementById('detalhesPedidoContainer');
                            detalhesContainer.style.display = 'block';
                            const consultarContainer = document.getElementById('consultarPedidoContainer');
                            consultarContainer.style.display = 'none';

                            // Limpar a tabela de detalhes do pedido
                            const detalhesTableBody = document.getElementById('detalhesPedidoTableBody');
                            detalhesTableBody.innerHTML = '';

                            // Quadro de Status da Nota Fiscal
                            const statusNotaFiscal = document.createElement('span');
                            statusNotaFiscal.classList.add('badge');
                            if (data.retorno.pedido.id_nota_fiscal !== "0") {
                                statusNotaFiscal.classList.add('badge-success');
                                statusNotaFiscal.innerText = 'Nota Fiscal Emitida';
                            } else {
                                statusNotaFiscal.classList.add('badge-danger');
                                statusNotaFiscal.innerText = 'Nota Fiscal Não Emitida';
                            }
                            statusNotaFiscal.style.marginRight = '10px'; // Adiciona um espaço à direita

                            // Botão Consultar NF
                            const btnConsultarNF = document.createElement('button');
                            btnConsultarNF.innerText = 'Consultar NF';
                            btnConsultarNF.classList.add('btn', 'btn-info', 'float-right', 'ml-2');
                            btnConsultarNF.setAttribute('data-toggle', 'modal');
                            btnConsultarNF.setAttribute('data-target', '#modalNF');
                            btnConsultarNF.addEventListener('click', () => {
                                // Evento acionado quando o modal é totalmente exibido
                                $('#modalNF').on('shown.bs.modal', function () {
                                    // Exibir os dados da nota fiscal no modal
                                    document.getElementById('idNotaFiscal').innerText = `ID Nota Fiscal: ${data.retorno.pedido.id_nota_fiscal}`;
                                    // Realizar a requisição para obter os detalhes da nota fiscal e exibir no modal
                                    fetch(`https://artearena.kinghost.net/obter-nota-fiscal/${data.retorno.pedido.id_nota_fiscal}`)
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Erro ao consultar nota fiscal');
                                            }
                                            return response.json();
                                        })
                                        .then(notaFiscalData => {
                                            // Adicionar os detalhes da nota fiscal ao modal
                                            console.log(notaFiscalData.retorno);
                                            // document.getElementById('numeroNotaFiscal').innerText = `Número da Nota Fiscal: ${notaFiscalData.retorno.nota_fiscal.numero}`;
                                            // document.getElementById('valorNotaFiscal').innerText = `Valor da Nota Fiscal: ${notaFiscalData.retorno.nota_fiscal.valor}`;
                                            // Adicione outros detalhes conforme necessário
                                        })
                                        .catch(error => {
                                            console.error('Erro ao consultar nota fiscal:', error);
                                        });
                                });
                            });

                            // Botão Detalhes do Pedido
                            const btnDetalhesPedido = document.createElement('button');
                            btnDetalhesPedido.innerText = 'Detalhes do Pedido';
                            btnDetalhesPedido.classList.add('btn', 'btn-secondary', 'float-right');
                            btnDetalhesPedido.setAttribute('data-toggle', 'modal');
                            btnDetalhesPedido.setAttribute('data-target', '#modalDetalhesPedido');
                            btnDetalhesPedido.addEventListener('click', () => {
                                const corpoDetalhesPedido = document.getElementById('corpoDetalhesPedido');
                                corpoDetalhesPedido.innerHTML = '';
                                
                                // Adicionar detalhes do pedido ao modal
                                for (const key in data.retorno.pedido) {
                                    if (data.retorno.pedido.hasOwnProperty(key)) {
                                        const p = document.createElement('p');
                                        p.textContent = `${key}: ${data.retorno.pedido[key]}`;
                                        corpoDetalhesPedido.appendChild(p);
                                    }
                                }
                            });

                            // Criar uma linha e célula na tabela para os botões e o quadro de status
                            const row = document.createElement('tr');
                            const cell = document.createElement('td');
                            cell.colSpan = 2; // Ajuste conforme o número de colunas da sua tabela
                            cell.appendChild(statusNotaFiscal); // Adiciona o quadro de status antes dos botões
                            cell.appendChild(btnConsultarNF);
                            cell.appendChild(btnDetalhesPedido);
                            row.appendChild(cell);
                            detalhesTableBody.appendChild(row);
                        })
                        .catch(error => {
                            console.error('Erro ao consultar detalhes do pedido:', error);
                        });
                }
            });


            function createStatusBar(statusList) {
                const statusBar = document.getElementById('statusBar');
                statusBar.innerHTML = ''; // Limpa a barra de status antes de adicionar novos status

                // Exemplo: Adicionando status de forma dinâmica
                statusList.forEach(s => {
                    const statusElement = document.createElement('div');
                    statusElement.classList.add('status-exemplo'); // Adiciona a classe CSS para os exemplos de status
                    statusElement.textContent = s;
                    statusBar.appendChild(statusElement);
                });
            }


            // Manipula o evento de clique no botão "Voltar"
            document.getElementById('voltarBtn').addEventListener('click', function() {
                // Esconder a tabela de detalhes do pedido
                const detalhesContainer = document.getElementById('detalhesPedidoContainer');
                detalhesContainer.style.display = 'none';
                // Exibir a tabela de detalhes do pedido
                const consultarContainer = document.getElementById('consultarPedidoContainer');
                consultarContainer.style.display = 'block';

                // Exibir novamente o modal de lista de pedidos
                $('#listaPedidosModal').modal('show');
            });
        });
    </script>
@endsection

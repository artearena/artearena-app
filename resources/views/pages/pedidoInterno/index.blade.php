@extends('layout.main')
@section('title', 'Tabela de Pedidos')
@section('style')
<style>
    /* =============================================================================
    Responsive Table CSS
    ========================================================================== */
    
    .dataTable {
        display: block;
        width: 100%;
        margin: 1em 0;
    }
    .dataTable thead, .dataTable tbody, .dataTable thead tr, .dataTable th {
        display: block;
    }
    .dataTable thead {
        float: left;
    }
    .dataTable tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .dataTable td, .dataTable th {
        padding: .625em;
        line-height: 1.5em;
        border-bottom: 1px dashed #ccc;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .dataTable th {
        text-align: center;
        background: #212529;
        color: white;
        border-bottom: 1px dashed #aaa;
    }
    .dataTable tbody tr {
        display: table-cell;
    }
    .dataTable tbody td {
        display: block;
    }
    .dataTable tr:nth-child(odd) {
        background: rgba(0, 0, 0, 0.07);
    }
    .dataTable .select-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dataTable .select-container select {
        margin: 0;
    }
    @media screen and (min-width: 50em) {
        .dataTable {
            display: table;
        }
        .dataTable thead {
            display: table-header-group;
            float: none;
        }
        .dataTable tbody {
            display: table-row-group;
        }
        .dataTable thead tr, .dataTable tbody tr {
            display: table-row;
        }
        .dataTable th, .dataTable tbody td {
            display: table-cell;
        }
        .dataTable td, .dataTable th {
            width: auto;
        }
        .dataTable .select-container {
            display: table-cell;
        }
        .dataTable .select-container select {
            margin: auto;
        }
        .red-text {
            color: red;
        }
    }
    .expandir-observacoes {
        max-width: 200px; /* Defina a largura máxima que deseja */
        white-space: nowrap; /* Evita que o texto quebre em várias linhas */
        overflow: auto; /* Adiciona uma barra de rolagem horizontal quando necessário */
        text-overflow: ellipsis; /* Adiciona reticências (...) quando o texto estiver além da largura máxima */
    }
</style>
<script>
    function observacoesChanged(event) {
        var pedidoId = $(event.target).closest('tr').data('id');

        var observacoes = $(event.target).val();
        console.log(pedidoId + ' ' + observacoes);
        $.ajax({
            url: '/pedido/' + pedidoId,
            method: 'PUT',
            data: {
                observacoes: observacoes,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    title: "Observação atualizada!",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                console.log('Observações atualizadas');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    $(document).ready(function() {
        $(document).on('change', '.observacoes-input', observacoesChanged);
    });
</script>
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="app">

    @if(isset($pedidosArte) && count($pedidosArte) > 0)
    <div class="alert-table">
        <h2 class="red-text text-center">Alertas</h2>
        <table id="alertasTable" class="dataTable">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Mensagem</th>
                    <th class="text-center">Data</th>
                    <th class="text-center">Designer</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @isset($pedidosArte)
                    @foreach($pedidosArte as $pedidoArte)
                        <tr data-id="{{ $pedidoArte->id }}">
                            <td class="text-center">{{ $pedidoArte->id }}</td>
                            <td class="text-center">{{ $pedidoArte->status }}</td>
                            <td class="text-center">
                                <input type="text" value="{{ $pedidoArte->observacoes }}" class="form-control" onchange="observacoesChanged(event)">
                            </td>
                            <td class="text-center">{{ $pedidoArte->data }}</td>
                            <td class="text-center">{{ $pedidoArte->designer }}</td>
                            <td class="text-center">
                                <a href="{{ $pedidoArte->link_trello }}" class="btn btn-primary ms-1" data-id="{{ $pedidoArte->id }}" onclick="return confirmarLink(this)" target="_blank">
                                    <i class="fa-brands fa-trello"></i> <!-- Ícone de cadeado do Font Awesome -->
                                </a>
                                <button class="btn-voltar-arte-final btn btn-warning ms-1" data-pedido-id="{{ $pedidoArte->id }}">
                                    <i class="fas fa-undo fa-lg"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
    @endif

        <hr>
        
        <h1>Tabela de Pedidos</h1>
        <table id="pedidosTable" class="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente ID</th>
                    <th>Vendedor</th>
                    <th>Produtos</th>
                    <th>Forma de Pagamento</th>
                    <th>Transportadora</th>
                    <th>Valor do Frete</th>
                    <th class="col-lg-6">Observação</th>
                    <th>Marcador</th>
                    <th>Data da Venda</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @isset($pedidos)
                    @foreach($pedidos as $pedido)
                        <tr class="pedido-row" data-pedido-id="{{ $pedido->id }}">
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->cliente_id }}</td>
                            <td>{{ $pedido->Vendedor }}</td>
                            <td>
                                <button class="btn-expand-produtos">
                                    Expandir
                                </button>
                            </td>                            
                            <td>{{ $pedido->forma_pagamento }}</td>
                            <td>{{ $pedido->transportadora }}</td>
                            <td>{{ $pedido->valor_frete }}</td>
                            <td class="expandir-observacoes" id="observacao" style="overflow: auto;" lang="pt">{{ $pedido->observacao }}</td>
                            <td>{{ $pedido->marcador }}</td>
                            <td>{{ date('Y-m-d', strtotime($pedido->data_venda)) }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-success btn-confirmar-pedido">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="openSwal(this)" class="btn btn-primary
                                        @if($listaUniformePorPedido[$pedido->id])
                                            btn-success
                                        @elseif(\App\Models\AcessoTemporario::linkCriadoParaPedido($pedido->id))
                                            btn-warning
                                        @else
                                            btn-danger
                                        @endif"
                                        data-toggle="modal" data-target="#modalListaUniforme" data-pedido-id="{{ $pedido->id }}">
                                        <i class="fas fa-tshirt"></i>
                                    </button>


                                    <button class="btn btn-warning btn-salvar-consultar-cliente" data-cliente-id="{{ $pedido->cliente_id }}">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="modalListasUniforme" tabindex="-1" role="dialog" aria-labelledby="modalListasUniformeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalListasUniformeLabel">Listas de Uniforme</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="listasUniformeTabs" role="tablist">
                <!-- Abas serão inseridas dinamicamente aqui -->
                </ul>
                <div class="tab-content" id="listasUniformeContent">
                <!-- Conteúdo das abas serão inseridos dinamicamente aqui -->
                </div>
            </div>
            </div>
        </div>
    </div>

@endsection
@section('extraScript')
    <script src="../js/pedidoInterno.js"></script>
    <script>
        $(document).ready(function() {
            $('#pedidosTable tbody').on('mouseenter', 'td.expandir-observacoes', function() {
                var td = $(this);
                var fullText = td.text();
                td.attr('title', fullText);
            });
        });
    </script>
    <script>
        function openSwal(button) {
            const pedidoId = button.getAttribute('data-pedido-id');

            Swal.fire({
            title: 'Escolha uma opção',
            showCancelButton: true,
            confirmButtonText: 'Gerar Link Temporário',
            cancelButtonText: 'Consultar Listas',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    // Esta é uma função de espaço reservado. Substitua pelo seu código de confirmação.
                    resolve();
                });
            }
            }).then((result) => {
                if (result.isConfirmed) {
                    generateTemporaryLink(pedidoId);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    openListasModal(pedidoId);
                }
            });


        }
        function generateTemporaryLink(pedidoId) {
            fetch('/gerarLinkListaProduto/' + pedidoId)
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        title: 'Link temporário',
                        text: data.link,
                        icon: 'info',
                        showCancelButton: false,
                        showConfirmButton: false,
                        html: `
                            <div>
                                <p>${data.link}</p>
                                <button id="copiar-link-btn" class="btn btn-primary">Copiar Link</button>
                            </div>
                        `,
                        customClass: {
                            content: 'text-center', // Alinha o conteúdo ao centro
                        },
                    });
        
                    // Adicionar evento de clique ao botão "Copiar Link"
                    const copiarLinkBtn = document.getElementById('copiar-link-btn');
                    copiarLinkBtn.addEventListener('click', function() {
                        const el = document.createElement('textarea');
                        el.value = data.link;
                        document.body.appendChild(el);
                        el.select();
                        document.execCommand('copy');
                        document.body.removeChild(el);
                        Swal.fire('Link copiado!', '', 'success');
                    });
                });
        }
        function openListasModal(pedidoId) {
            fetch('/listaUniformes/consultarListas/' + pedidoId)
                .then(response => response.json())
                .then(data => {
                    const modal = $('#modalListasUniforme');
                    const tabsContainer = $('#listasUniformeTabs');
                    const contentContainer = $('#listasUniformeContent');

                    // Limpa as abas e o conteúdo anterior
                    tabsContainer.empty();
                    contentContainer.empty();

                    // Verifica se há dados retornados
                    if (data && data.length > 0) {
                        // Renderiza uma aba para cada lista de Uniforme
                        data.forEach((lista, index) => {
                            const tabId = 'lista-tab-' + index;
                            const contentId = 'lista-content-' + index;

                    // Determina o nome da lista com base no índice
                    let nomeLista;
                    switch(index) {
                        case 0:
                            nomeLista = "Primeira Lista";
                            break;
                        case 1:
                            nomeLista = "Segunda Lista";
                            break;
                        case 2:
                            nomeLista = "Terceira Lista";
                            break;
                        case 3:
                            nomeLista = "Quarta Lista";
                            break;
                        case 4:
                            nomeLista = "Quinta Lista";
                            break;
                        case 5:
                            nomeLista = "Sexta Lista";
                            break;
                        case 6:
                            nomeLista = "Sétima Lista";
                            break;
                        case 7:
                            nomeLista = "Oitava Lista";
                            break;
                        case 8:
                            nomeLista = "Nona Lista";
                            break;
                        case 9:
                            nomeLista = "Décima Lista";
                            break;
                        default:
                            nomeLista = `Lista ${index + 1}`;
                            break;
                    }
                            // Adiciona a aba
                            tabsContainer.append(`<li class="nav-item"><a class="nav-link" id="${tabId}" data-toggle="tab" href="#${contentId}" role="tab" aria-controls="${contentId}" aria-selected="true">${nomeLista}</a></li>`);

                            // Adiciona o conteúdo da aba
                            const produtosHTML = lista.produtos.map(produto => {
                                return `
                                    <tr>
                                        <td>${produto.produto_nome}</td>
                                        <td>${produto.sexo}</td>
                                        <td>${produto.arte_aprovada}</td>
                                        <td>${produto.pacote}</td>
                                        <td>${produto.camisa}</td>
                                        <td>${produto.calcao}</td>
                                        <td>${produto.meiao}</td>
                                        <td>${produto.nome_jogador || ''}</td>
                                        <td>${produto.numero || ''}</td>
                                        <td>${produto.tamanho}</td>
                                        <td>${produto.gola}</td>
                                        <!-- Adicione mais informações do produto conforme necessário -->
                                    </tr>
                                `;
                            }).join('');

                            contentContainer.append(`<div class="tab-pane fade" id="${contentId}" role="tabpanel" aria-labelledby="${tabId}">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Produto</th>
                                                                    <th>Sexo</th>
                                                                    <th>Arte Aprovada</th>
                                                                    <th>Pacote</th>
                                                                    <th>Camisa</th>
                                                                    <th>Calção</th>
                                                                    <th>Meião</th>
                                                                    <th>Nome do Jogador</th>
                                                                    <th>Número</th>
                                                                    <th>Tamanho</th>
                                                                    <th>Gola</th>
                                                                    <!-- Adicione mais cabeçalhos de coluna conforme necessário -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                ${produtosHTML}
                                                            </tbody>
                                                        </table>
                                                    </div>`);
                        });
                    } else {
                        // Caso não haja dados retornados
                        contentContainer.append(`<p>Não há listas disponíveis.</p>`);
                    }

                    // Abre o modal
                    modal.modal('show');
                })
                .catch(error => {
                    console.error('Erro ao carregar listas de uniformes:', error);
                    // Trate o erro conforme necessário
                });
        }



    </script>
    
@endsection
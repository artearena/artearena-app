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
    }
</style>
<script>
    function observacoesChanged(event) {
        var id = $(this).closest('tr').data('id');        
        var observacoes = $(event.target).val();
        console.log(id + ' ' + observacoes);
        $.ajax({
            url: '/pedido/' + id,
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
        
    <div class="alert-table">
        <h2>Alertas</h2>
        <div class="alert-table">
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
                        <tr>
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
    </div>
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
                            <td id="observacao" style="overflow: auto;" lang="pt">{{ $pedido->observacao }}</td>
                            <td>{{ $pedido->marcador }}</td>
                            <td>{{ $pedido->data_venda }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-success btn-confirmar-pedido">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-primary btn-consultar-lista-uniforme" data-toggle="modal" data-target="#modalListaUniforme" data-pedido-id="{{ $pedido->id }}">
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
@endsection
@section('extraScript')
    <script src="../js/pedidoInterno.js"></script>
@endsection
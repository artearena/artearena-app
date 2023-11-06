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
    }
</style>
<script src="../js/pedidoInterno.js"></script>
@endsection

@section('content')
    <div class="container">
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
                                <button class="btn btn-link btn-expand-produtos">Expandir</button>
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
                            <td> 
                                @foreach($pedido->produtos ?? [] as $produto)
                                    <li>{{ $pedido->produtos }}</li>
                                @endforeach
                            </td>
                        </tr>
                        <tr class="produtos-row" style="display: none;">

                                    

                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
@endsection

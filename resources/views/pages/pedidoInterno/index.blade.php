@extends('layout.main')
@section('title', 'Tabela de pedidos')
@section('style')
<style>
    .table {
        border: 1px solid #ccc !important;
    }
    .table th,
    .table td {
        border: 1px solid #ccc !important;
    }
    .table th {
        text-align: center !important;
    }
    #observacao {
        overflow: auto !important; /* Oculta o overflow */
        overflow-y: auto !important; /* Adiciona barra de rolagem vertical apenas quando necessário */
        white-space: pre-wrap !important; /* Permite quebras de linha */
    }
    .container {
        width: 100% !important;
        padding-right: 15px !important;
        padding-left: 15px !important;
        margin-right: auto !important;
        margin-left: auto !important;
    }
    .btn-group {
        display: flex;
        justify-content: flex-start;
    }
    .btn-group .btn {
        margin-right: 5px;
    }
</style>
<script src="../../js/listaUniforme.js"></script>
@endsection
@section('content')
<div class="container">
    <h1>Tabela de Pedidos</h1>
    <table id="pedidosTable" class="table mt-4 custom-table table-responsive">
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
                    </div>
                </td>
            </tr>
            <tr class="produtos-row" style="display: none;">
                <td colspan="11">
                    <ul>
                        @foreach($pedido->produtos ?? [] as $produto)
                            <li>{{ $produto->produto_nome }} (Quantidade: {{ $produto->quantidade }}, Preço Unitário: {{ $produto->preco_unitario }})</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
            @endisset
        </tbody>
    </table>
</div>
<!-- Modal Lista Uniforme -->
<div class="modal fade" id="modalListaUniforme" tabindex="-1" role="dialog" aria-labelledby="modalListaUniformeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalListaUniformeLabel">Lista Uniforme</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formListaUniforme">
                    <!-- Campos para editar a lista de uniformes -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSalvarListaUniforme">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection
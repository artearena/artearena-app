@extends('layout.main')
@section('title', 'Tabela de Pedidos')
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
                    <td>
                        <i class="fas fa-link"></i> {{ $pedido->cliente_id }}
                    </td>
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
                            <button class="btn btn-primary btn-salvar-consultar-cliente" data-cliente-id="{{ $pedido->cliente_id }}">
                                <i class="fas fa-link"></i>
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
@endsection
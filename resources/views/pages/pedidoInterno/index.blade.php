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
@endsection
@section('content')
    <div class="app">
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
                @foreach ($listaProdutos as $listaProduto)
                    <tr class="pedido-row" data-pedido-id="{{ $pedido->id }}">
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->cliente_id }}</td>
                        <td>{{ $pedido->Vendedor }}</td>
                        <td>
                            <button class="btn-expand-produtos">
                                Expandir
                            </button>
                        </td>                            
                        <td>
                            <select name="sexo" class="form-control">
                                <option value="M" {{ $listaProduto->sexo == 'M' ? 'selected' : '' }}>M</option>
                                <option value="F" {{ $listaProduto->sexo == 'F' ? 'selected' : '' }}>F</option>
                            </select>
                        </td>
                        <td>
                            <select name="pacote" class="form-control">
                                <option value="start" {{ $listaProduto->pacote == 'start' ? 'selected' : '' }}>Start</option>
                                <option value="prata" {{ $listaProduto->pacote == 'prata' ? 'selected' : '' }}>Prata</option>
                                <option value="ouro" {{ $listaProduto->pacote == 'ouro' ? 'selected' : '' }}>Ouro</option>
                                <option value="diamante" {{ $listaProduto->pacote == 'diamante' ? 'selected' : '' }}>Diamante</option>
                                <option value="premium" {{ $listaProduto->pacote == 'premium' ? 'selected' : '' }}>Premium</option>
                                <option value="profissional" {{ $listaProduto->pacote == 'profissional' ? 'selected' : '' }}>Profissional</option>
                            </select>
                        </td>
                        <td>
                            <select name="lista_aprovada" class="form-control">
                                <option value="sim" {{ $listaProduto->lista_aprovada == 'sim' ? 'selected' : '' }}>Sim</option>
                                <option value="não" {{ $listaProduto->lista_aprovada == 'não' ? 'selected' : '' }}>Não</option>
                            </select>
                        </td>
                        <td>
                            <select name="tamanho" class="form-control">
                                <option value="P" {{ $listaProduto->tamanho == 'P' ? 'selected' : '' }}>P</option>
                                <option value="M" {{ $listaProduto->tamanho == 'M' ? 'selected' : '' }}>M</option>
                                <option value="G" {{ $listaProduto->tamanho == 'G' ? 'selected' : '' }}>G</option>
                                <option value="GG" {{ $listaProduto->tamanho == 'GG' ? 'selected' : '' }}>GG</option>
                                <option value="XG" {{ $listaProduto->tamanho == 'XG' ? 'selected' : '' }}>XG</option>
                                <option value="XGG" {{ $listaProduto->tamanho == 'XGG' ? 'selected' : '' }}>XGG</option>
                                <option value="XGGG" {{ $listaProduto->tamanho == 'XGGG' ? 'selected' : '' }}>XGGG</option>
                            </select>
                        </td>
                        <td id="observacao" style="overflow: auto;" lang="pt">{{ $pedido->observacao }}</td>
                        <td>{{ $pedido->marcador }}</td>
                        <td>{{ $pedido->data_venda }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-success btn-confirmar-pedido">
                                    <i class="fas fa-check"></i>
                                </button>
                                @php
                                    $hasUniforme = false;
                                @endphp
                                @foreach ($listaProdutos as $listaProduto)
                                    @if ($listaProduto->pedido_id == $pedido->id && in_array($listaProduto->produto_nome, ['Uniforme', 'Camiseta', 'Camisa', 'Short', 'Shorts', 'Abadá']))
                                        @php
                                            $hasUniforme = true;
                                        @endphp
                                        <button class="btn btn-primary btn-consultar-lista-uniforme" data-toggle="modal" data-target="#modalListaUniforme" data-pedido-id="{{ $pedido->id }}">
                                            <i class="fas fa-tshirt"></i>
                                        </button>
                                    @endif
                                @endforeach
                                @if (!$hasUniforme)
                                    <button class="btn btn-primary btn-consultar-lista-uniforme" data-toggle="modal" data-target="#modalListaUniforme" data-pedido-id="{{ $pedido->id }}" style="display: none;">
                                        <i class="fas fa-tshirt"></i>
                                    </button>
                                @endif
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
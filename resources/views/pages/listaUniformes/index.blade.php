@extends('layout.main')

@section('title', 'Lista de informações dos pedidos')

@section('content')

    <div class="container">

        <h1>Lista de informações dos pedidos</h1>

        @if ($pedidos)
            <p>Total de pedidos encontrados: {{ $pedidos->count() }}</p>

            <table class="table">

                <thead>
                    <tr>
                        <th>Nome do cliente</th>
                        <th>Número do pedido</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Sexo</th>
                        <th>Arte aprovada</th>
                        <th>Lista aprovada</th>
                        <th>Pacote</th>
                        <th>Camisa</th>
                        <th>Calção</th>
                        <th>Meia</th>
                        <th>Nome</th>
                        <th>Número</th>
                        <th>Tamanho</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($pedidos as $pedido)

                        {{-- Adicione verificação se $pedido é um objeto --}}
                        @if (is_object($pedido))

                            <tr>
                                <td>{{ $pedido->cliente_nome }}</td>
                                <td>{{ $pedido->id }}</td>
                                <td>{{ $pedido->produto_nome }}</td>
                                <td>{{ $pedido->quantidade }}</td>
                                <td>{{ $pedido->sexo }}</td>
                                <td>{{ $pedido->arte_aprovada }}</td>
                                <td>{{ $pedido->lista_aprovada }}</td>
                                <td>{{ $pedido->pacote }}</td>
                                <td>{{ $pedido->camisa }}</td>
                                <td>{{ $pedido->calcao }}</td>
                                <td>{{ $pedido->meiao }}</td>
                                <td>{{ $pedido->nome }}</td>
                                <td>{{ $pedido->numero }}</td>
                                <td>{{ $pedido->tamanho }}</td>
                            </tr>

                        @else
                            <p>Pedido não é um objeto: {{ gettype($pedido) }}</p>
                        @endif

                    @endforeach

                </tbody>

            </table>

        @else
            <p>Nenhum pedido encontrado.</p>
        @endif

    </div>

@endsection

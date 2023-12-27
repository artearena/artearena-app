@extends('layout.main')
@section('title', 'Lista de Produtos')
@section('content')
    <h1>Lista de Produtos</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nome do Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Sexo</th>
                <th>Arte Aprovada</th>
                <th>Lista Aprovada</th>
                <th>Pacote</th>
                <th>Camisa</th>
                <th>Calção</th>
                <th>Meião</th>
                <th>Nome do Jogador</th>
                <th>Número</th>
                <th>Tamanho</th>
                <th>ID da Lista</th>
            </tr>
        </thead>
        <tbody>
            @if ($produtos)
                @foreach ($produtos as $produto)
                    <tr>
                        <td>{{ $produto->produto_nome }}</td>
                        <td>{{ $produto->quantidade }}</td>
                        <td>{{ $produto->preco_unitario }}</td>
                        <td>{{ $produto->sexo }}</td>
                        <td>{{ $produto->arte_aprovada }}</td>
                        <td>{{ $produto->lista_aprovada }}</td>
                        <td>{{ $produto->pacote }}</td>
                        <td>{{ $produto->camisa }}</td>
                        <td>{{ $produto->calcao }}</td>
                        <td>{{ $produto->meiao }}</td>
                        <td>{{ $produto->nome_jogador }}</td>
                        <td>{{ $produto->numero }}</td>
                        <td>{{ $produto->tamanho }}</td>
                        <td>{{ $produto->id_lista }}</td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
@endsection

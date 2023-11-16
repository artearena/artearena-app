@extends('layout.main')

@section('title', 'Detalhes do Produto')

@section('content')

    <div class="container">

        <h1>Detalhes do Produto</h1>

        <div class="divProduto">

            <table class="table">

                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Tamanho</th>
                        <!-- Adicione outras colunas conforme necessário -->
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td>{{ $produto->produto_nome }}</td>
                        <td>{{ $produto->quantidade }}</td>
                        <td>{{ $produto->tamanho }}</td>
                        <!-- Adicione outras colunas conforme necessário -->
                    </tr>
                </tbody>

            </table>

        </div>

    </div>

@endsection

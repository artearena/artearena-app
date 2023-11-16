@extends('layout.main')

@section('title', 'Lista de informações dos produtos')

@section('content')

    <div class="container">

        <h1>Lista de informações dos produtos</h1>

        @if ($produtos)
            <p>Total de produtos encontrados: {{ $produtos->count() }}</p>

            <div class="divProduto">

                <table class="table">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Número</th>
                            <th>Tamanho</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($produtos as $produto)

                            {{-- Adicione verificação se $produto é um objeto --}}
                            @if (is_object($produto))

                                <tr>
                                    <td>{{ $produto->nome }}</td>
                                    <td>{{ $produto->numero }}</td>
                                    <td>{{ $produto->tamanho }}</td>
                                </tr>

                            @else
                                <p>Produto não é um objeto: {{ gettype($produto) }}</p>
                            @endif

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else
            <p>Nenhum produto encontrado.</p>
        @endif

    </div>

@endsection

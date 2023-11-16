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
                            @foreach($produtos->getAttributes() as $attribute => $value)
                                <th>{{ $attribute }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($produtos as $produto)

                            {{-- Adicione verificação se $produto é um objeto --}}
                            @if (is_object($produto))

                                <tr>
                                    @foreach($produto->getAttributes() as $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
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

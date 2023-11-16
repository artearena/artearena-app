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
                                <tr>
                                    <td>$produto</td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        @else
            <p>Nenhum produto encontrado.</p>
        @endif

    </div>

@endsection

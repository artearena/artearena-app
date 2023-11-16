@extends('layout.main')

@section('title', 'Lista de informações dos produtos')

@section('content')

    <div class="container">

        <h1>Lista de informações dos produtos</h1>

        @if ($produtos->isEmpty())
            <p>Nenhum produto encontrado.</p>
        @else
            <p>Total de produtos encontrados: {{ $produtos->count() }}</p>

            <div class="divProduto">

                <table class="table">

                    <thead>
                        <tr>
                            @foreach($produtos->first()->getAttributes() as $attribute => $value)
                                <th>{{ $attribute }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produtos as $produto)
                            <tr>
                                @foreach($produto->getAttributes() as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endif

    </div>

@endsection

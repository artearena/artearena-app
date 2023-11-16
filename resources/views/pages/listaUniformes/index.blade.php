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
                        
                    </tbody>
                </table>

            </div>
            @foreach($produtos as $produto)
                        {{$produto}}
            @endforeach
        @else
            <p>Nenhum produto encontrado.</p>
        @endif

    </div>

@endsection

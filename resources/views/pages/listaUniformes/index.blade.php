@extends('layout.main')
@section('title', 'Lista de informações dos produtos')
@section('content')
    <div class="container">
        <h1>Lista de informações dos produtos</h1>
        @php
            $hasUniforme = false;
            $hasChinelos = false;
        @endphp
        @foreach($produtos as $produto)
            @if(strpos($produto->produto_nome, 'uniforme') !== false)
                @php
                    $hasUniforme = true;
                @endphp
            @elseif(strpos($produto->produto_nome, 'chinelo') !== false)
                @php
                    $hasChinelos = true;
                @endphp
            @endif
        @endforeach
        @if($hasUniforme)
            <div class="divProduto">
                <h2>Uniformes</h2>
                <form id="cadastroFormUniforme">
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
                                @if(strpos($produto->produto_nome, 'uniforme') !== false)
                                    <tr>
                                        <td>{{ $produto->nome }}</td>
                                        <td>{{ $produto->numero }}</td>
                                        <td>{{ $produto->tamanho }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        @endif
        @if($hasChinelos)
            <div class="divProduto">
                <h2>Chinelos</h2>
                <form id="cadastroFormChinelos">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Tamanho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produtos as $produto)
                                @if(strpos($produto->produto_nome, 'chinelo') !== false)
                                    <tr>
                                        <td>{{ $produto->nome }}</td>
                                        <td>{{ $produto->tamanho }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        @endif
    </div>
@endsection
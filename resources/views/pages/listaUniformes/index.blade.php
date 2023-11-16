@extends('layout.main')

@section('title', 'Lista de informações dos produtos')

@section('content')

    <div class="container">

        <h1>Lista de informações dos produtos</h1>

        @php

            $hasUniforme = false;

            $hasChinelos = false;

        @endphp

        @if ($produtos)
            @foreach($produtos as $produto)

                {{-- Adicione verificação se $produto é um objeto --}}
                @if (is_object($produto))

                    @if(stripos($produto->produto_nome, 'Uniforme') !== false)

                        @php

                            $hasUniforme = true;

                        @endphp

                    @elseif(stripos($produto->produto_nome, 'chinelo') !== false)

                        @php

                            $hasChinelos = true;

                        @endphp

                    @endif

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

                                    {{-- Adicione verificação se $produto é um objeto --}}
                                    @if (is_object($produto) && stripos($produto->produto_nome, 'uniforme') !== false)

                                        @for($i = 0; $i < $produto->quantidade; $i++)
                                            <tr>
                                                <td>{{ $produto->nome }}</td>
                                                <td>{{ $produto->numero }}</td>
                                                <td>{{ $produto->tamanho }}</td>
                                            </tr>
                                        @endfor

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

                                    {{-- Adicione verificação se $produto é um objeto --}}
                                    @if (is_object($produto) && stripos($produto->produto_nome, 'chinelo') !== false)

                                        @for($i = 0; $i < $produto->quantidade; $i++)
                                            <tr>
                                                <td>{{ $produto->nome }}</td>
                                                <td>{{ $produto->tamanho }}</td>
                                            </tr>
                                        @endfor

                                    @endif

                                @endforeach

                            </tbody>

                        </table>

                    </form>

                </div>

            @endif
        @else
            <p>Nenhum produto encontrado.</p>
        @endif

    </div>

@endsection

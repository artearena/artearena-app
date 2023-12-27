@extends('layout.main')
@section('title', 'Lista de Produtos')
@section('content')
    <h1>Lista de Produtos</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nome do Produto</th>
                <th>Sexo</th>
                <th>Arte Aprovada</th>
                <th>Pacote</th>
                <th>Camisa</th>
                <th>Calção</th>
                <th>Meião</th>
                <th>Nome do Jogador</th>
                <th>Número</th>
                <th>Tamanho</th>
            </tr>
        </thead>
        <tbody>
            @if ($produtos)
                @foreach ($produtos as $produto)
                    @php
                        $nomeProdutoNormalizado = strtolower($produto->produto_nome);
                    @endphp

                    <tr class="produto-row" data-nome="{{ $nomeProdutoNormalizado }}">
                        <td>{{ $produto->produto_nome }}</td>
                        <td>{{ $produto->sexo }}</td>
                        <td>{{ $produto->arte_aprovada }}</td>
                        <td>{{ $produto->pacote }}</td>
                        <td>{{ $produto->camisa }}</td>
                        <td>{{ $produto->calcao }}</td>
                        <td>{{ $produto->meiao }}</td>
                        <td>{{ $produto->nome_jogador }}</td>
                        <td>{{ $produto->numero }}</td>
                        <td>{{ $produto->tamanho }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection

@section('extraScript')
    @parent {{-- Mantenha qualquer conteúdo JavaScript existente --}}
    <script>
        function normalize(text) {
            text = text.toLowerCase();
            text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
            return text;
        }

        function ehVestuario(nomeProduto) {
            var vestuario = [
                "Camisa Personalizada", "Boné Premium Personalizado", "Chinelo Slide Personalizado",
                "Chinelo Adulto Personalizado", "Abadá Personalizado", "Camiseta Personalizada",
                "Toalha Personalizada", "Colete Personalizado", "Sacochila Personalizada",
                "Braçadeira Personalizada", "Máscara Personalizada", "Máscara Caveira",
                "Máscara Pikachu", "Máscara o Máskara", "Máscara La Casa de Papel",
                "Máscara Homem Aranha", "Máscara Arlequina Coringa", "Máscara Et Alien",
                "Máscara Girl Power", "Máscara Girl Power - Rosa", "Máscara Girl Power - Branco",
                "Máscara Girl Power - Preto", "Máscara Good Vibes", "Máscara LGBT",
                "Máscara Oncinha", "Máscara Resiliência", "Máscara Resiliência - Rosa",
                "Máscara Resiliência - Preto", "Máscara Coringa", "Máscara Brasil",
                "Samba Canção Personalizado", "Roupão Personalizado", "Doleira",
                "Shorts Doll Personalizado", "Balaclava Personalizada"
            ];

            var nomeProdutoNormalizado = normalize(nomeProduto);

            for (var i = 0; i < vestuario.length; i++) {
                var item = normalize(vestuario[i]);

                if (nomeProdutoNormalizado.includes(item)) {
                    return true;
                }
            }

            return false;
        }

        // Função para mostrar/ocultar linhas de produtos com base na categoria
        function filtrarProdutos(categoria) {
            var rows = document.querySelectorAll('.produto-row');

            rows.forEach(function(row) {
                var nomeProduto = row.getAttribute('data-nome');
                if (ehVestuario(nomeProduto) && categoria === 'vestuario') {
                    row.style.display = 'table-row';
                } else if (!ehVestuario(nomeProduto) && categoria === 'outros') {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Adicione um evento de clique aos botões de filtro
        document.getElementById('btn-vestuario').addEventListener('click', function() {
            filtrarProdutos('vestuario');
        });

        document.getElementById('btn-outros').addEventListener('click', function() {
            filtrarProdutos('outros');
        });
    </script>
@endsection

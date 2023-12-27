@extends('layout.main')

@section('title', 'Lista de Produtos')

@section('content')
    <div class="container my-4"> <!-- Container adicionado para espaçamento -->
        <h1>Lista de Produtos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome do Produto</th>
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
                        @for ($i = 0; $i < $produto->quantidade; $i++)
                            <tr>
                                <td>{{ $produto->produto_nome }}</td>
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
                        @endfor
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
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
        
        // Executa a filtragem dos produtos após o carregamento da página
        document.addEventListener('DOMContentLoaded', function() {
            var produtos = @json($produtos); // Converte os produtos para um objeto JavaScript
            
            // Filtra os produtos
            var produtosFiltrados = produtos.filter(function(produto) {
                return ehVestuario(produto.produto_nome);
            });
            
            // Atualiza a tabela com os produtos filtrados
            var tbody = document.querySelector('tbody');
            tbody.innerHTML = '';
            
            produtosFiltrados.forEach(function(produto) {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${produto.produto_nome}</td>
                    <td>${produto.quantidade}</td>
                    <td>${produto.preco_unitario}</td>
                    <td>${produto.sexo}</td>
                    <td>${produto.arte_aprovada}</td>
                    <td>${produto.lista_aprovada}</td>
                    <td>${produto.pacote}</td>
                    <td>${produto.camisa}</td>
                    <td>${produto.calcao}</td>
                    <td>${produto.meiao}</td>
                    <td>${produto.nome_jogador}</td>
                    <td>${produto.numero}</td>
                    <td>${produto.tamanho}</td>
                    <td>${produto.id_lista}</td>
                `;
                tbody.appendChild(row);
            });
        });
    </script>
@endsection

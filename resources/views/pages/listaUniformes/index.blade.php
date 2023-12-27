@extends('layout.main')

@section('title', 'Lista de Produtos')

@section('content')
    <div class="container my-2">
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
                <!-- As linhas da tabela serão adicionadas dinamicamente pelo JavaScript -->
            </tbody>
        </table>
    </div>
@endsection

@section('extraScript')
    @parent
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
                "Shorts Doll Personalizado", "Balaclava Personalizada",
                // Adicione mais itens aqui conforme necessário
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
        
        document.addEventListener('DOMContentLoaded', function() {
            var produtos = @json($produtos);

            var tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            produtos.forEach(function(produto) {
                if (ehVestuario(normalize(produto.produto_nome))) {
                    for (var i = 0; i < produto.quantidade; i++) {
                        var row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${produto.produto_nome}</td>
                            <td><input type='text' value='${produto.sexo}'></td>
                            <td>${produto.arte_aprovada}</td>
                            <td>${produto.pacote}</td>
                            <td><input type='text' value='${produto.camisa}'></td>
                            <td><input type='text' value='${produto.calcao}'></td>
                            <td><input type='text' value='${produto.meiao}'></td>
                            <td><input type='text' value='${produto.nome_jogador}'></td>
                            <td><input type='number' value='${produto.numero}'></td>
                            <td><input type='text' value='${produto.tamanho}'></td>
                        `;
                        tbody.appendChild(row);
                    }
                }
            });
        });
    </script>
@endsection

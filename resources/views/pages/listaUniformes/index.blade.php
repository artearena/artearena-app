@extends('layout.main')

@section('title', 'Lista de Produtos')

@section('content')
    <div class="container my-2">
        <h1>Lista de Produtos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome do Produto</th>
                    <th>Categoria</th>
                    <th>Arte Aprovada</th>
                    <th>Pacote</th>
                    <th>Camisa</th>
                    <th>Calção</th>
                    <th>Meião</th>
                    <th>Nome do Jogador</th>
                    <th>Número</th>
                    <th>Tamanho</th>
                    <th>Gola</th>
                </tr>
            </thead>
            <tbody>
                <!-- As linhas da tabela serão adicionadas dinamicamente pelo JavaScript -->
            </tbody>
        </table>

        <!-- Botão para salvar a lista de uniformes -->
        <button onclick="salvarListaUniformes()" class="btn btn-primary">Salvar Lista de Uniformes</button>
    </div>
@endsection

@section('extraScript')
    @parent
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        function normalize(text) {
            text = text.toLowerCase();
            text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
            return text;
        }

        function ehVestuario(nomeProduto) {
            var vestuario = [
                "Camisa Personalizada", "Boné Premium Personalizado", "Chinelo Slide Personalizado",
                // ...resto da lista de vestuário...
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

        function salvarListaUniformes() {
            var listaUniformes = [];

            // Iterar sobre as linhas da tabela e extrair os dados
            $('tbody tr').each(function() {
                var uniforme = {
                    produto_nome: $(this).find('td:nth-child(1)').text(),
                    categoria: $(this).find('td:nth-child(2) select').val(),
                    arte_aprovada: $(this).find('td:nth-child(3)').text(),
                    pacote: $(this).find('td:nth-child(4)').text(),
                    camisa: $(this).find('td:nth-child(5)').text() === 'Sim',
                    calcao: $(this).find('td:nth-child(6)').text() === 'Sim',
                    meiao: $(this).find('td:nth-child(7)').text() === 'Sim',
                    nome_jogador: $(this).find('td:nth-child(8) input').val(),
                    numero: $(this).find('td:nth-child(9) input').val(),
                    tamanho: $(this).find('td:nth-child(10) select').val(),
                    gola: $(this).find('td:nth-child(11) select').val()
                };

                listaUniformes.push(uniforme);
            });

            // Agora você pode enviar a listaUniformes para o backend ou fazer o que for necessário com os dados.
            console.log('Lista de Uniformes:', listaUniformes);
            alert('Lista de uniformes salva com sucesso!');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var produtos = @json($produtos);

            var tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            produtos.forEach(function(produto) {
                if (ehVestuario(normalize(produto.produto_nome))) {
                    for (var i = 0; i < produto.quantidade; i++) {
                        var row = document.createElement('tr');
                        var sexoCategoria = produto.sexo === 'M' ? 'Masculino' : (produto.sexo === 'F' ? 'Feminino' : 'Infantil');
                        var camisaChecked = produto.camisa ? 'Sim' : 'Não';
                        var calcaoChecked = produto.calcao ? 'Sim' : 'Não';
                        var meiaoChecked = produto.meiao ? 'Sim' : 'Não';

                        row.innerHTML = `
                            <td>${produto.produto_nome}</td>
                            <td>
                                <select class='form-control'>
                                    <option value='M' ${produto.sexo === 'M' ? 'selected' : ''}>Masculino</option>
                                    <option value='F' ${produto.sexo === 'F' ? 'selected' : ''}>Feminino</option>
                                    <option value='I' ${produto.sexo === 'I' ? 'selected' : ''}>Infantil</option>
                                </select>
                            </td>
                            <td>${produto.arte_aprovada}</td>
                            <td>${produto.pacote !== null && produto.pacote !== '' ? produto.pacote : ''}</td>
                            <td>${camisaChecked}</td>
                            <td>${calcaoChecked}</td>
                            <td>${meiaoChecked}</td>
                            <td>${produto.nome_jogador !== null && produto.nome_jogador !== '' ? `<input type='text' value='${produto.nome_jogador}' class='form-control'>` : ''}</td>
                            <td>${produto.numero !== null && produto.numero !== '' ? `<input type='number' value='${produto.numero}' class='form-control'>` : ''}</td>
                            <td>
                                <select class='form-control'>
                                    <!-- Adicione as opções desejadas para Tamanho aqui -->
                                </select>
                            </td>
                            <td>
                                <select class='form-control'>
                                    <!-- Adicione as opções desejadas para Gola aqui -->
                                </select>
                            </td>
                        `;
                        tbody.appendChild(row);
                    }
                }
            });

            $(document).ready(function(){
                $('input[type="number"]').mask('00000');
            });
        });

    </script>
@endsection

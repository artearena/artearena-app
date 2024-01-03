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
        $(document).ready(function() {

            function salvarListaUniformes() {
                var listaUniformes = [];

                // Iterar sobre as linhas da tabela e extrair os dados
                $('tbody tr').each(function () {
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

                console.log('Dados a serem enviados:', JSON.stringify(listaUniformes, null, 2)); // Debug

                $.ajax({
                    type: 'POST',
                    url: '/listaUniformes/salvarListaUniformes',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { listaUniformes: listaUniformes },
                    success: function (response) {
                        console.log('Resposta do servidor:', response);
                        alert('Lista de uniformes salva com sucesso!');
                    },
                    error: function (error) {
                        console.error('Erro ao salvar lista de uniformes:', error);
                        alert('Erro ao salvar lista de uniformes. Verifique o console para mais detalhes.');
                    },
                });
            }
        });




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
                            <td>${sexoCategoria}</td>
                            <td>${produto.arte_aprovada}</td>
                            <td>${produto.pacote !== null && produto.pacote !== '' ? produto.pacote : ''}</td>
                            <td>${camisaChecked}</td>
                            <td>${calcaoChecked}</td>
                            <td>${meiaoChecked}</td>
                            <td>${produto.nome_jogador !== null && produto.nome_jogador !== '' ? `<input type='text' value='${produto.nome_jogador}' class='form-control'>` : `<input type='text' value='' class='form-control'>` }</td>
                            <td>${produto.numero !== null && produto.numero !== '' ? `<input type='number' value='${produto.numero}' class='form-control'>` : `<input type='number' value='' class='form-control'>` }</td>
                            <td>
                                <select class='form-control'>
                                    <option value='P'>Pequeno (P)</option>
                                    <option value='M'>Médio (M)</option>
                                    <option value='G'>Grande (G)</option>
                                    <option value='GG'>Extra Grande (GG)</option>
                                </select>
                            </td>
                            <td>
                                <select class='form-control'>
                                    <option value='GolaV'>Gola V</option>
                                    <option value='GolaRedonda'>Gola Redonda</option>
                                    <option value='GolaPolo'>Gola Polo</option>
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

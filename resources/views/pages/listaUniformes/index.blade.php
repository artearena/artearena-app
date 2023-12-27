@extends('layout.main')

@section('title', 'Lista de Produtos')

@section('head')
    @parent
    <style>
        .table input[type='text'], .table select, .table input[type='number'] {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        .table input[type='checkbox'] {
            margin-left: 5px;
        }
    </style>
@endsection

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

        document.addEventListener('DOMContentLoaded', function() {
            var produtos = @json($produtos);

            var tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            produtos.forEach(function(produto) {
                if (ehVestuario(normalize(produto.produto_nome))) {
                    for (var i = 0; i < produto.quantidade; i++) {
                        var row = document.createElement('tr');
                        var sexoSelecionadoM = produto.sexo === 'M' ? 'selected' : '';
                        var sexoSelecionadoF = produto.sexo === 'F' ? 'selected' : '';
                        var camisaChecked = produto.camisa ? 'checked' : '';
                        var calcaoChecked = produto.calcao ? 'checked' : '';
                        var meiaoChecked = produto.meiao ? 'checked' : '';

                        row.innerHTML = `
                            <td>${produto.produto_nome}</td>
                            <td>
                                <select>
                                    <option value='M' ${sexoSelecionadoM}>M</option>
                                    <option value='F' ${sexoSelecionadoF}>F</option>
                                </select>
                            </td>
                            <td>${produto.arte_aprovada}</td>
                            <td>${produto.pacote}</td>
                            <td><input type='checkbox' ${camisaChecked}></td>
                            <td><input type='checkbox' ${calcaoChecked}></td>
                            <td><input type='checkbox' ${meiaoChecked}></td>
                            <td><input type='text' value='${produto.nome_jogador}'></td>
                            <td><input type='number' value='${produto.numero}'></td>
                            <td><input type='text' value='${produto.tamanho}'></td>
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

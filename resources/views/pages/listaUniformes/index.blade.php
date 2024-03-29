@extends('layout.main')

@section('title', 'Lista de Produtos')

@section('content')
    <div class="container-fluid my-2">
        <h1>Lista de Produtos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th style="display: none">ID do pedido</th>
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
        // Função para normalizar texto
        function normalize(text) {
            text = text.toLowerCase();
            text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
            return text;
        }

        // Função para verificar se é vestuário
        function ehVestuario(nomeProduto) {
            var vestuario = [
                "camisa personalizada", "boné premium personalizado", "chinelo slide personalizado",  
                'uniforme',
                'balaclava',
                'calcao',
                'camisa',
                'camisao',
                'camiseta',
                'colete',
                'meiao',
                'samba',
                'abada',
                'roupao',
                'corte',
                'chinelo',
                'shorts'
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

        // Função para sincronizar tamanhos entre produtos do pacote Start
        function sincronizarTamanhosStart(novaOpcao) {
            $('tbody tr').each(function () {
                var pacote = $(this).find('td:nth-child(5)').text();

                if (pacote === 'Start') {
                    var selectTamanho = $(this).find('td:nth-child(11) select');

                    // Sincronizar o tamanho
                    selectTamanho.val(novaOpcao);
                }
            });
        }
        // Função para sincronizar nomes entre produtos do pacote Prata
        function sincronizarNomesPrata(novoNome) {
            $('tbody tr').each(function () {
                var pacote = $(this).find('td:nth-child(5)').text();

                if (pacote === 'Prata') {
                    var inputNome = $(this).find('td:nth-child(9) input');

                    // Sincronizar o nome
                    inputNome.val(novoNome);
                }
            });
        }

        // Função para aplicar regras por pacote
        function aplicarRegrasPorPacote(pacote, row, categoria) {
            // Adicione aqui as regras específicas para cada pacote
            switch (pacote) {
                case 'Start':
                    // Regras para o Pacote Start
                    // A única opção de gola será "Careca"
                    var selectGola = row.querySelector('td:nth-child(12) select');
                    if (selectGola) {
                        selectGola.innerHTML = '<option value="Careca">Careca</option>';
                    }

                    // As opções de tamanho serão M ou G
                    var selectTamanho = row.querySelector('td:nth-child(11) select');
                    selectTamanho.innerHTML = `
                        <option value='M'>Médio (M)</option>
                        <option value='G'>Grande (G)</option>
                    `;

                    // Adicionar evento de alteração para sincronizar tamanhos
                    selectTamanho.addEventListener('change', function () {
                        var novaOpcao = $(this).val();
                        sincronizarTamanhosStart(novaOpcao);
                    });

                    // Desabilitar a entrada do nome
                    var inputNome = row.querySelector('td:nth-child(9) input');
                    if (inputNome) {
                        inputNome.setAttribute('disabled', 'disabled');
                    }
                    break;

                    case 'Prata':
                        // Regras para o Pacote Prata
                        var selectGola = row.querySelector('td:nth-child(12) select');
                        if (selectGola) {
                            selectGola.innerHTML = `<option value="Careca">Careca</option>
                                                    <option value="V">V</option>`;
                        }

                        // As opções de tamanho serão M ou G
                        var selectTamanho = row.querySelector('td:nth-child(11) select');
                        selectTamanho.innerHTML = `
                            <option value='P'>Pequeno (P)</option>
                            <option value='M'>Médio (M)</option>    
                            <option value='G'>Grande (G)</option>
                            <option value='GG'>Muito Grande (GG)</option>
                            <option value='XG'>Extra Grande (XG)</option>
                            <option value='XXG'>Extra Grande 2 (XXG)</option>
                            <option value='XXXG'>Extra Grande 3 (XXXG)</option>
                        `;
                        // Permitir nomes, sincronizar conforme digitado
                        var inputNomePrata = row.querySelector('td:nth-child(9) input');
                        
                        if (inputNomePrata) {
                            // Adicionar evento de digitação para sincronizar nomes
                            inputNomePrata.addEventListener('input', function () {
                                var novoNome = $(this).val();
                                var idLista = $(this).closest('tr').find('td:nth-child(1)').text();
                                sincronizarNomesPrata(novoNome, idLista);
                            });
                        }
                        break;     
                    case 'Ouro':
                        // Regras para o Pacote Prata
                        var selectGola = row.querySelector('td:nth-child(12) select');
                        if (selectGola) {
                            selectGola.innerHTML = `<option value="Careca">Careca</option>
                                                    <option value="V">V</option>
                                                    <option value="Bayard">Bayard</option>
                                                    `;
                        }

                        // As opções de tamanho serão M ou G
                        var selectTamanho = row.querySelector('td:nth-child(11) select');
                        selectTamanho.innerHTML = `
                            <option value='P'>Pequeno (P)</option>
                            <option value='M'>Médio (M)</option>    
                            <option value='G'>Grande (G)</option>
                            <option value='GG'>Muito Grande (GG)</option>
                            <option value='XG'>Extra Grande (XG)</option>
                            <option value='XXG'>Extra Grande 2 (XXG)</option>
                            <option value='XXXG'>Extra Grande 3 (XXXG)</option>
                        `;

                        break;
                    case 'Diamante':
                        // Regras para o Pacote Prata
                        var selectGola = row.querySelector('td:nth-child(12) select');
                        if (selectGola) {
                            selectGola.innerHTML = `<option value="Careca">Careca</option>
                                                    <option value="V">V</option>
                                                    <option value="Bayard">Bayard</option>
                                                    <option value="Polo">Polo</option>
                                                    `;
                        }

                        // As opções de tamanho serão M ou G
                        var selectTamanho = row.querySelector('td:nth-child(11) select');
                        selectTamanho.innerHTML = `
                            <option value='P'>Pequeno (P)</option>
                            <option value='M'>Médio (M)</option>    
                            <option value='G'>Grande (G)</option>
                            <option value='GG'>Muito Grande (GG)</option>
                            <option value='XG'>Extra Grande (XG)</option>
                            <option value='XXG'>Extra Grande 2 (XXG)</option>
                            <option value='XXXG'>Extra Grande 3 (XXXG)</option>
                        `;

                        break;         
                    case 'Premium':
                        // Regras para o Pacote Prata
                        var selectGola = row.querySelector('td:nth-child(12) select');
                        if (selectGola) {
                            selectGola.innerHTML = `<option value="Careca">Careca</option>
                                                    <option value="V">V</option>
                                                    <option value="Bayard">Bayard</option>
                                                    <option value="Polo">Polo</option>
                                                    `;
                        }

                        // As opções de tamanho serão M ou G
                        var selectTamanho = row.querySelector('td:nth-child(11) select');
                        selectTamanho.innerHTML = `
                            <option value='P'>Pequeno (P)</option>
                            <option value='M'>Médio (M)</option>    
                            <option value='G'>Grande (G)</option>
                            <option value='GG'>Muito Grande (GG)</option>
                            <option value='XG'>Extra Grande (XG)</option>
                            <option value='XXG'>Extra Grande 2 (XXG)</option>
                            <option value='XXXG'>Extra Grande 3 (XXXG)</option>
                        `;

                        break;      
                    case 'Profissional':
                        // Regras para o Pacote Prata
                        var selectGola = row.querySelector('td:nth-child(12) select');
                        if (selectGola) {
                            selectGola.innerHTML = `<option value="Careca">Careca</option>
                                                    <option value="V">V</option>
                                                    <option value="Bayard">Bayard</option>
                                                    <option value="Polo">Polo</option>
                                                    `;
                        }

                        // As opções de tamanho serão M ou G
                        var selectTamanho = row.querySelector('td:nth-child(11) select');
                        selectTamanho.innerHTML = `
                            <option value='P'>Pequeno (P)</option>
                            <option value='M'>Médio (M)</option>    
                            <option value='G'>Grande (G)</option>
                            <option value='GG'>Muito Grande (GG)</option>
                            <option value='XG'>Extra Grande (XG)</option>
                            <option value='XXG'>Extra Grande 2 (XXG)</option>
                            <option value='XXXG'>Extra Grande 3 (XXXG)</option>
                        `;

                        break;    
                default:
                    // Regras padrão, caso nenhum pacote específico seja correspondido
                    break;
            }
            if(categoria == 'I' || categoria == 'Infantil'){
                var selectTamanho = row.querySelector('td:nth-child(11) select');
                    selectTamanho.innerHTML = `
                        <option value='2'>Pequeno 2</option>
                        <option value='4'>Médio 4</option>    
                        <option value='6'>Grande 6</option>
                        <option value='8'>Muito Grande 8</option>
                        <option value='10'>Extra Grande 10</option>
                        <option value='12'>2 Extra Grande 12 </option>
                        <option value='14'>3 Extra Grande 14 </option>
                        <option value='16'>4 Extra Grande 16 </option>
                    `;
            }
        
        }


        document.addEventListener('DOMContentLoaded', function () {
            var produtos = @json($produtos);
            var tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            produtos.forEach(function (produto) {
                if (ehVestuario(normalize(produto.produto_nome))&& !produto.inativar) {
                    for (var i = 0; i < produto.quantidade; i++) {
                        var row = document.createElement('tr');
                        var sexo = produto.categoria; // Caso o sexo não esteja definido
                        var sexoCategoria = '';
                        console.log(produto);

                        switch (sexo) {
                            case 'M':
                                sexoCategoria = 'Masculino';
                                break;
                            case 'F':
                                sexoCategoria = 'Feminino';
                                break;
                            case 'I':
                                sexoCategoria = 'Infantil';
                                break;
                            case null:
                                sexoCategoria = 'Masculino';
                                break;
                            default:
                                sexoCategoria = sexo;
                                break;
                        }                        
                        var camisaChecked = produto.camisa ? 'Sim' : 'Não';
                        var calcaoChecked = produto.calcao ? 'Sim' : 'Não';
                        var meiaoChecked = produto.meiao ? 'Sim' : 'Não';
                        console.log(sexoCategoria);

                        row.innerHTML = `
                            <td style="display: none">${produto.pedido_id}</td> 
                            <td>${produto.produto_nome}</td>
                            <td>${sexoCategoria}</td>
                            <td>${produto.arte_aprovada}</td>
                            <td>${produto.pacote !== null && produto.pacote !== '' ? produto.pacote : ''}</td>
                            <td>${camisaChecked}</td>
                            <td>${calcaoChecked}</td>
                            <td>${meiaoChecked}</td>
                            <td>${produto.nome_jogador !== null && produto.nome_jogador !== '' ? `<input type='text' value='${produto.nome_jogador}' class='form-control'>` : `<input type='text' value='' class='form-control'>`}</td>
                            <td>${produto.numero !== null && produto.numero !== '' ? `<input type='number' value='${produto.numero}' class='form-control'>` : `<input type='number' value='' class='form-control'>`}</td>
                            <td>
                                <select class='form-control'>
                                    <!-- Opções de gola serão preenchidas dinamicamente pela função aplicarRegrasPorPacote -->
                                </select>
                            </td>
                            <td>
                                <select class='form-control'>
                                    <!-- Opções de gola serão preenchidas dinamicamente pela função aplicarRegrasPorPacote -->
                                </select>
                            </td>
                        `;

                        // Aplicar regras específicas por pacote
                        aplicarRegrasPorPacote(produto.pacote, row, produto.categoria);

                        tbody.appendChild(row);
                    }
                }
            });

            // ...


            $(document).ready(function(){
                $('input[type="number"]').mask('00000');
            });
        });

        // Função para salvar a lista de uniformes
        function salvarListaUniformes() {
            var urlParams = new URLSearchParams(window.location.search);
            var idLista = urlParams.get('id_lista');
            var token = urlParams.get('token'); 
            
            var listaUniformes = [];

            $('tbody tr').each(function () {
                var uniforme = {
                    pedido_id: $(this).find('td:nth-child(1)').text(),
                    produto_nome: $(this).find('td:nth-child(2)').text(),
                    sexo: $(this).find('td:nth-child(3)').text(),
                    arte_aprovada: $(this).find('td:nth-child(4)').text(),
                    pacote: $(this).find('td:nth-child(5)').text(),
                    camisa: $(this).find('td:nth-child(6)').text(),
                    calcao: $(this).find('td:nth-child(7)').text(),
                    meiao: $(this).find('td:nth-child(8)').text(),
                    nome_jogador: $(this).find('td:nth-child(9) input').val(),
                    numero: $(this).find('td:nth-child(10) input').val(),
                    tamanho: $(this).find('td:nth-child(11) select').val(),
                    gola: $(this).find('td:nth-child(12) select').val(),
                    id_lista: idLista,
                    token,
                };
                console.log(token);
                listaUniformes.push(uniforme);
            });

            console.log('Dados a serem enviados:', JSON.stringify(listaUniformes, null, 2)); // Debug

            $.ajax({
                type: 'POST',
                url: '/gravarLista',
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
    </script>
@endsection

@extends('layout.main')

@section('title')
Consulta de Pedidos
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

<style>
     .detalhe-expandido {
        white-space: normal !important;
    }
    .col-md-10 {
        width: 100%;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    .form-row {
        margin-bottom: 10px;
    }

    .form-row label {
        font-weight: bold;
        margin-right: 10px;
    }

    .full-width {
        width: 100%;
    }

    .hidden-form {
        display: none;
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .visible-form {
        display: block;
        visibility: visible;
        opacity: 1;
    }
    td {
        text-align: center;
    }
    /* Estilização para os campos com cores */
    td[data-color="red"] {
        background-color: #fa7f72; /* Vermelho */
    }

    td[data-color="yellow"] {
        background-color: #FFFF00; /* Amarelo */
    }

    td[data-color="green"] {
        background-color: #00FF00; /* Verde */
    }

    td[data-color="lightgreen"] {
        background-color: #ADFF2F; /* Verde claro */
    }

    td[data-color="orange"] {
        background-color: #FFE5A0; /* Laranja */
    }
    td[data-color="pink"] {
        background-color: #FFC0CB; /* rosa */
    }
    td[data-color="purple"] {
        background-color: #800080; /* roxo */
    }
    td[data-color="blue"] {
        background-color: #0000FF; /* azul */
    }
    td[data-color="lightblue"] {
        background-color: #C6DBE1; /* azul */
    }
    td[data-color="lightgray"] {
        background-color: #E6E6E6; /* azul */
    }
    td[data-color="darkblue"] {
        background-color: #215A6C; /* azul */
    }
    /* Definindo cores de texto para os campos */
    td[data-color="red"], td[data-color="orange"], td[data-color="pink"], td[data-color="purple"], td[data-color="blue"] {
        color: white;
    }
   
    #tabela-pedidos thead th {
        text-align: center;
        vertical-align: middle;
        background-color: black;
        color: white;
    }


    /* Add borders to the table */
    #tabela-pedidos {
        border: 1px solid #ddd;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 20px; /* Adjust the value as needed */
    }
    #tabela-pedidos thead th,
    #tabela-pedidos tbody td {
        border: 1px solid #ddd;
        vertical-align: middle;
        text-align: center;
    }
    #tabela-pedidos input[type="text"],
    #tabela-pedidos input[type="number"],
    #tabela-pedidos select {
        background-color: transparent; /* Remove o fundo branco */
        border: none; /* Remove as bordas */
        outline: none; /* Remove o contorno de foco ao clicar */
        font-family: "Arial", sans-serif; /* Define a fonte como "Arial" e fontes alternativas caso não esteja disponível */
    }

    /* Estilo para deixar a borda inferior nos campos de input somente ao focar */
    #tabela-pedidos input[type="text"]:focus,
    #tabela-pedidos input[type="number"]:focus,
    #tabela-pedidos select:focus {
        border-bottom: 1px solid white; /* Adiciona borda inferior ao focar */
    }

    /* Estilo para a seleção nos campos de input */
    #tabela-pedidos input[type="text"]::selection,
    #tabela-pedidos input[type="number"]::selection,
    #tabela-pedidos select::selection {
        background-color: rgba(255, 255, 255, 0.3); /* Define a cor da seleção */
    }
    #metragem_total{
        font-family: "Arial Narrow", Arial, sans-serif; /* Fonte compacta sugerida: Arial Narrow */
        font-weight: bold;
        font-size: 15px; 
    }
        /* Tamanho de fonte sugerido: 14 pixels */
</style>
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-10">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <h1>Consulta de Pedidos</h1>
                    <button id="toggle-button" class="btn btn-primary">Mostrar/Esconder Formulário</button>
                    <form id="my-form" class="hidden-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-row">
                                    <label for="data">ID:</label>
                                    <input type="text" class="form-control" name="id" id="id">
                                </div>
                                <div class="form-row">
                                    <label for="data">Data:</label>
                                    <input type="date" class="form-control" name="data" id="data">
                                </div>
                                <div class="form-row">
                                    <label for="produto">Produto:</label>
                                    <select class="form-control" name="produto" id="produto">
                                        @foreach($categoriasProduto as $categoria)
                                            <option value="{{ $categoria->descricao }}">{{ $categoria->descricao }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label for="material">Material:</label>
                                                
                                    <select class="form-control" name="material" id="material">
                                            <option value=""></option>
                                        @foreach ($materiais as $material)
                                            <option value="{{ $material->id }}">{{ $material->descricao }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label for="medida_linear">Medida Linear:</label>
                                    <input type="number" step="0.01" class="form-control" name="medida_linear" id="medida_linear">
                                </div>
                                <div class="form-row">
                                    <label for="observacoes">Observações:</label>
                                    <textarea class="form-control full-width" name="observacoes" id="observacoes"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <label for="status">Status:</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="Prensa / Calandra">Prensa / Calandra</option>
                                        <option value="Checagem">Checagem</option>
                                        <option value="Corte / Preparação">Corte / Preparação</option>
                                        <option value="Prateleira / Pendente">Prateleira / Pendente</option>
                                        <option value="Costura / Confecção">Costura / Confecção</option>
                                        <option value="Conferencia Final">Conferencia Final</option>
                                        <option value="Finalizado">Finalizado</option>
                                        <option value="Reposição">Reposição</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label for="rolo">Rolo:</label>
                                    <input type="text" class="form-control" name="rolo" id="rolo">
                                </div>
                                <div class="form-row">
                                    <label for="tiny">Tiny:</label>
                                    <input type="text" class="form-control" name="tiny" id="tiny">
                                </div>
                            </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="cadastrarPedido">Cadastrar Pedido</button>
                    </form>
                    <hr>
                        <div id="metragem_total"></div>
                    <hr>
                        <div id="qtd-dia-artes">Quantidade de artes</div>
                    <hr>
                    <div class="tabela-container">
                    <div id="loading" class="text-center" style="display: none;">
                        <p>Carregando...</p>
                    </div>
                    <div id="recordsInfoContainer" style="font-size: 1.2em; font-weight: bold;"></div>

                    <table id="tabela-pedidos" class="table table-striped">
                        <thead>
                            <tr>
                                <th data-filter="true">ID</th>
                                <th data-filter="true">Data</th>
                                <th data-filter="true">Produto</th>
                                <th data-filter="true">Material</th>
                                <th data-filter="true">Medida Linear</th>
                                <th data-filter="true">Observações</th>
                                <th data-filter="true">Status</th>
                                <th data-filter="true">Rolo</th>
                                <th>Mover</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                            @if($pedido->etapa == 'C')
                            <tr data-id="{{ $pedido->id }}">
                                <!-- Tornar o campo ID editável -->
                                <td>{{ $pedido->id }}</td>
                                <!-- Tornar o campo Data editável e adicionar o Datepicker -->
                                <td>
                                    <input type="text" class="form-control datepicker" name="data" value="{{ date('d/m/Y', strtotime($pedido->data)) }}">
                                </td>
                                <td>
                                    <select class='form-control' name='produto'>
                                        @foreach($categoriasProduto as $categoria)
                                        <option value="{{ $categoria->descricao }}" {{ $pedido->produto == $categoria->descricao ? 'selected' : '' }}>
                                            {{ $categoria->descricao }}
                                        </option>
                                        @endforeach
                                        <option value="{{ $pedido->produto }}" {{ !in_array($pedido->produto, $categoriasProduto->pluck('descricao')->toArray()) ? 'selected' : '' }}>
                                            {{ $pedido->produto }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="material">
                                        <option value=""></option>
                                        @foreach ($materiais as $material)
                                        <option value="{{ $material->id }}" {{ $pedido->material == $material->id ? 'selected' : '' }}>
                                            {{ $material->descricao }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td><input type='number' step='0.01' class='form-control' name='medida_linear' value="{{ $pedido->medida_linear }}"></td>
                                <td class="expandir-observacoes">
                                    <input type="text" class="form-control observacoes-field" name="observacoes" value="{{ $pedido->observacoes }}">
                                </td>

                                <td>
                                    <select class="form-control" name="status" id="status">
                                        <option value="Prensa / Calandra" {{ $pedido->status == 'Prensa / Calandra' ? 'selected' : '' }}>Prensa / Calandra</option>
                                        <option value="Checagem" {{ $pedido->status == 'Checagem' ? 'selected' : '' }}>Checagem</option>
                                        <option value="Corte / Preparação" {{ $pedido->status == 'Corte / Preparação' ? 'selected' : '' }}>Corte / Preparação</option>
                                        <option value="Prateleira / Pendente" {{ $pedido->status == 'Prateleira / Pendente' ? 'selected' : '' }}>Prateleira / Pendente</option>
                                        <option value="Costura / Confecção" {{ $pedido->status == 'Costura / Confecção' ? 'selected' : '' }}>Costura / Confecção</option>
                                        <option value="Conferencia Final" {{ $pedido->status == 'Conferencia Final' ? 'selected' : '' }}>Conferencia Final</option>
                                        <option value="Finalizado" {{ $pedido->status == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                                        <option value="Reposição" {{ $pedido->status == 'Reposição' ? 'selected' : '' }}>Reposição</option>
                                    </select>
                                </td>
                                <td><input type='text' class='form-control' name='rolo' value="{{ $pedido->rolo }}"></td>
                                <td>
                                    <button type="button" class="btn btn-primary mover-pedido" data-id="{{ $pedido->id }}">
                                        <i class="bi bi-arrow-clockwise"></i> <!-- Ícone de quatro setas do Bootstrap -->
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger excluir-pedido" data-id="{{ $pedido->id }}">
                                        <i class="fas fa-trash-alt"></i> <!-- Ícone de caixa de lixo do Font Awesome -->
                                    </button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>
                </div>
            </div>
        </main>
    </div>
</div>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" id="closeExcluirButton" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir este pedido?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelExcluirButton" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmMoverImpressaoModal" tabindex="-1" role="dialog" aria-labelledby="confirmMoverImpressaoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmMoverImpressaoModalLabel">Confirmação de Movimentação para Impressão</h5>
                <button type="button" class="close" id="closeMoverImpressaoButton" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja mover este pedido para a etapa de Reposição?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelMoverImpressaoButton" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmMoverImpressaoButton">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var toggleButton = document.getElementById('toggle-button');
    var form = document.getElementById('my-form');

    toggleButton.addEventListener('click', function () {
        form.classList.toggle('visible-form');
    });
</script>

@endsection

@section('extraScript')
<!-- Carregue o jQuery primeiro -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Em seguida, carregue a biblioteca Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>

<!-- Em seguida, carregue o plugin bootstrap-datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>

<!-- Carregue o DataTables após o jQuery e o Bootstrap -->
<script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script>
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


$(document).ready(function(){
    configurarTabela();
    atualizarQuantidadeRegistros();
    updateColors(); // Função para atualizar as cores de fundo dos campos
    reatribuirEventosChange(); // Função para reatribuir o evento "change" após a paginação ou ordenação
    reatribuirEventosExcluir(); 
    
    function configurarTabela() {
    let table = $('#tabela-pedidos').DataTable({
        fixedHeader: true,
        order: [[1, 'asc']],
        "lengthMenu": [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
        "pageLength": 200,
        "columnDefs": [
            // Definições das colunas, incluindo a função "render" para formatar a data
            {
                "targets": [0, 4],
                "width": "13px",
            },
            {
                "targets": [1],
                "width": "80px"
            },
            {
                "targets": [2],
                "width": "90px"
            },
            {
                "targets": [6],
                "width": "120px"
            },
            {
                "targets": [1],
                "type": "date-br",
                "render": function(data, type, row) {
                    if (type === "sort" || type === "type") {
                        return row[1].replace(/(\d{2})\/(\d{2})\/(\d{4})/, "$3-$2-$1");
                    }
                    return data;
                }
            }
            
            // Adicione mais definições de colunas conforme necessário
        ],
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Mostrar _MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            },
            "select": {
                "rows": {
                    "_": "%d linhas selecionadas",
                    "0": "Nenhuma linha selecionada",
                    "1": "1 linha selecionada"
                }
            }
        },
        "infoCallback": function (settings, start, end, max, total, pre) {
                // Update the content of the 'recordsInfoContainer' with the total record count
                $('#recordsInfoContainer').html('Quantidade: ' + total + ' registros');
                // Return an empty string to prevent the default info display
                return '';
        },
        "ordering": true
    });

    $('#tabela-pedidos tbody').on('mouseenter', 'td.expandir-observacoes', function() {
        var inputField = $(this).find('.observacoes-field');
        var fullText = inputField.val();
        inputField.attr('title', fullText);
    });
    function contarRegistrosPorData() {
            let tabelaPedidos = table;
            let registrosPorData = {};

            // Percorre as linhas da tabela
            tabelaPedidos.rows().every(function () {
                let dataPedido = moment(this.data()[1], 'DD/MM/YYYY').format('DD/MM/YYYY');

                if (!registrosPorData[dataPedido]) {
                    registrosPorData[dataPedido] = 0;
                }

                registrosPorData[dataPedido]++;
            });

            // Ordena as chaves em ordem crescente
            let chavesOrdenadas = Object.keys(registrosPorData).sort();

            // Exibe o resultado na div com o id "qtd-dia-artes"
            let resultado = '';
            for (let i = 0; i < chavesOrdenadas.length; i++) {
                let data = chavesOrdenadas[i];
                resultado += 'Data: ' + data + ' - Registros: ' + registrosPorData[data] + '<br>';
            }
            document.getElementById("qtd-dia-artes").innerHTML = resultado;
        }
        contarRegistrosPorData();
    // Restante do código para configurar a tabela
    // ...
}

    // Função para cadastrar um novo pedido
    $('#cadastrarPedido').click(function(e) {
        e.preventDefault(); // Evita o comportamento padrão do formulário
        
        // Obtenha os valores dos campos do formulário
        var id = $('#id').val();
        var data = $('#data').val();
        var produto = $('#produto').val();
        var material = $('#material').val();
        var medida_linear = $('#medida_linear').val();
        var observacoes = $('#observacoes').val();
        var status = $('#status').val();
        var rolo = $('#rolo').val();
        var tiny = $('#tiny').val();
        var etapa = 'C';


        // Enviar a requisição AJAX para salvar o pedido
        $.ajax({
            url: '/pedido/criar', // Atualize o URL para '/pedido/criar'
            method: 'POST',
            data: {
                id: id,
                data: data,
                produto: produto,
                material: material,
                medida_linear: medida_linear,
                observacoes: observacoes,
                status: status,
                rolo: rolo,
                    tiny: tiny,
                etapa: etapa,
                "_token": "{{ csrf_token() }}" // Adicione o token CSRF do Laravel para prevenir ataques CSRF
            },
            success: function(response) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Pedido criado com sucesso. atualize a página para que o registro entre em vigor',
                    icon: 'success',
                    timer: 1500, // Defina o tempo que o alerta será exibido (em milissegundos)
                    showConfirmButton: false // Ocultar o botão "OK"
                });
                var newRow = '<tr>';
                newRow += '<td>' + response.pedido.id + '</td>';
                newRow += '<td>' + response.pedido.data + '</td>';
                newRow += '<td>' + response.pedido.produto + '</td>';
                newRow += '<td>' + response.pedido.material + '</td>';
                newRow += '<td>' + response.pedido.medida_linear + '</td>';
                newRow += '<td>' + response.pedido.observacoes + '</td>';
                newRow += '<td>' + response.pedido.status + '</td>';
                newRow += '<td>' + response.pedido.rolo + '</td>';
                newRow += '<td>' + response.pedido.tiny + '</td>';
                newRow += '</tr>';
                
                // Insira a nova linha na tabela
                $('tbody').prepend(newRow);
                $('#tabela-pedidos').load(location.href + ' #tabela-pedidos');

            },
             error: function(xhr, status, error) {
                // Tratamento de erro: exibir pop-up com a mensagem de erro filtrada
                var errorMessage = "Erro ao criar pedido: ";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += filtrarMensagemErro(xhr.responseJSON.message);
                } else {
                    errorMessage += "Ocorreu um erro inesperado.";
                }
                alert(errorMessage);
            }
        });

    });
    // Estilize o campo form-control com jQuery
    $(".form-control").css({
            "font-size": "15px",
            "text-align": "center"
    });
    function filtrarMensagemErro(message) {
        // Exemplo: verificar se a mensagem contém um erro de id duplicado
        if (message.includes("Duplicate entry")) {
            return "O ID fornecido já existe. Por favor, forneça um ID diferente.";
        }

        // Se nenhum filtro corresponder, retorne a mensagem original
        return message;
    }
    $('#tabela-pedidos').on('draw.dt', function() {
        updateColors(); // Função para atualizar as cores de fundo dos campos
        reatribuirEventosChange(); // Função para reatribuir o evento "change" após a paginação ou ordenação
        reatribuirEventosExcluir(); // Função para reatribuir o evento de exclusão após a paginação ou ordenação
    });



    $('.table input, .table select').change(function () {
        var id = $(this).closest('tr').data('id');
        var field = $(this).attr('name');
        var value = $(this).val();
        var medidaLinearValue = $(this).closest('tr').find('input[name="medida_linear"]').val();
        
        if (field === 'data') {
            var dateParts = value.split('/');
            if (dateParts.length === 3) {
                value = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0] + ' 00:00:00';
            } else {
                console.error('Formato de data inválido. Formato esperado: dd/mm/yyyy');
                return;
            }
        }   
        /* if (field === 'status') {
            var pedidoId = id;
            var novoStatus = value;
            var mensagem = 'Pedido:' + pedidoId + ' teve o status alterado para: ' + novoStatus;
            
            var url = 'http://artearena.kinghost.net/enviarNotificacaoSlack?mensagem=' + mensagem;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    console.log('Notificação enviada para o servidor com sucesso!');
                } else {
                    throw new Error('Erro ao enviar notificação para o servidor');
                }
            })
            .catch(error => {
                console.error('Erro ao enviar notificação para o servidor: ' + error.message);
            });
        } */
        
        // Verifica se o campo é uma medida linear
        var isLinearMeasurementField = ['medida_linear'].includes(field);

        $.ajax({
            url: '/pedido/' + id,
            method: 'PUT',
            data: {
                [field]: value,
                "_token": "{{ csrf_token() }}",
            },
            success: function (response) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Pedido atualizado com sucesso.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
    function reatribuirEventosChange() {
        $('#tabela-pedidos').off('change', '.table input, .table select');
        $('#tabela-pedidos').on('change', '.table input, .table select', function () {
            var id = $(this).closest('tr').find('td:first-child').text();
            var field = $(this).attr('name');
            var value = $(this).val();
            var $this = $(this);
            if (field === 'data') {
                var dateParts = value.split('/');
                if (dateParts.length === 3) {
                    value = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0] + ' 00:00:00';
                } else {
                    console.error('Formato de data inválido. Formato esperado: dd/mm/yyyy');
                    return;
                }
            }
            
            var isLinearMeasurementField = ['medida_linear'].includes(field);

            if (isLinearMeasurementField && !value.match(/^\d+(\.\d{1,2})?$/)) {
                swal('Atenção', 'Insira um número positivo com até duas casas decimais.', 'warning');
                return;
            }

          /*  if (field === 'status') {
              /*   var pedidoId = id;
                var novoStatus = value;
                var mensagem = 'Pedido:' + pedidoId + ' teve o status alterado para: ' + novoStatus;
 */
               // var url = 'http://artearena.kinghost.net/enviarNotificacaoSlack?mensagem=' + mensagem;

              /*   fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Notificação enviada para o servidor com sucesso!');
                    } else {
                        throw new Error('Erro ao enviar notificação para o servidor');
                    }
                })
                .catch(error => {
                    console.error('Erro ao enviar notificação para o servidor: ' + error.message);
                }); 
            } */
            
            $.ajax({
                url: '/pedido/' + id,
                method: 'PUT',
                data: {
                    [field]: value,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    console.log(response.message);
                    var table = $('#tabela-pedidos').DataTable();
                    var row = table.row($this.closest('tr'));
                    row.data(response.pedido);
                    row.draw();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    }


$('.mover-pedido').click(function () {
        var pedidoId = $(this).attr('data-id');

        // Defina o valor do atributo "data-id" no botão de confirmação para o id do pedido
        $('#confirmMoverImpressaoButton').attr('data-id', pedidoId);

        // Abra o modal de confirmação
        $('#confirmMoverImpressaoModal').modal('show');
    });
    $('#closeMoverImpressaoButton').click(function () {
        $('#confirmMoverImpressaoModal').modal('hide');
    });
    $('#cancelMoverImpressaoButton').click(function () {
        $('#confirmMoverImpressaoModal').modal('hide');
    });

    // Script para processar a movimentação do pedido após a confirmação
    $('#confirmMoverImpressaoButton').click(function () {
        var pedidoId = $(this).attr('data-id');

        // Enviar a requisição AJAX para mover o pedido para a etapa de "Reposição"
        $.ajax({
            url: "/pedido/mover/" + pedidoId,
            method: 'PUT',
            data: {
                etapa: 'R', // Considerando 'R' como a etapa de "Reposição"
                "_token": "{{ csrf_token() }}", // Adicione o token CSRF do Laravel para prevenir ataques CSRF
            },
            success: function(response) {
                console.log(response.message);

                var table = $('#tabela-pedidos').DataTable();
                var row = table.row($('tr[data-id="' + pedidoId + '"]'));

                // Remova a linha da tabela após o movimento bem-sucedido
                row.remove().draw(false);

                // Feche o modal após a confirmação
                $('#confirmMoverImpressaoModal').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error(error); // Log any errors that occur during the AJAX request.
            }
        });
    });


        $('#cancelExcluirButton').click(function () {
             $('#confirmDeleteModal').modal('hide');
         });
         $('#closeExcluirButton').click(function () {
             $('#confirmDeleteModal').modal('hide');
         });

        // Vincule um evento de clique ao botão "Excluir" para abrir o modal de confirmação
        $('.excluir-pedido').click(function() {
            var pedidoId = $(this).closest('td').siblings(':first-child').text();
            var row = $(this).closest('tr'); // Obter a linha da tabela

            // Defina o valor do atributo "data-id" no botão de confirmação para o id do pedido
            $('#confirmDeleteButton').attr('data-id', pedidoId);

            // Abra o modal de confirmação
            $('#confirmDeleteModal').modal('show');
        });

        // Vincule um evento de clique ao botão "Confirmar" do modal de confirmação
        function reatribuirEventosExcluir() {
        $('.excluir-pedido').off('click').on('click', function() {
            var pedidoId = $(this).closest('td').siblings(':first-child').text();
            var row = $(this).closest('tr'); // Obter a linha da tabela

            // Defina o valor do atributo "data-id" no botão de confirmação para o id do pedido
            $('#confirmDeleteButton').attr('data-id', pedidoId);

            // Abra o modal de confirmação
            $('#confirmDeleteModal').modal('show');
        });

        // Vincule um evento de clique ao botão "Confirmar" do modal de confirmação
        $('#confirmDeleteButton').off('click').on('click', function() {
            var pedidoId = $(this).attr('data-id');
            var row = $('tr[data-id="' + pedidoId + '"]');

            // Enviar a requisição AJAX para excluir o pedido
            $.ajax({
                url: "/pedido/" + pedidoId,
                method: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    row.remove();
                    console.log('Excluído com sucesso');
                    // Feche o modal após a exclusão
                    $('#confirmDeleteModal').modal('hide');
                }
            });
        });
    }

        // Função para definir a cor de fundo do campo "Status"
        function setStatusColor(value, element) {
            if (value === "Prensa / Calandra") {
                element.attr("data-color", "orange");
            } else if (value === "Checagem") {
                element.attr("data-color", "darkblue");
            } else if (value === "Corte / Preparação") {
                element.attr("data-color", "lightblue");
            } else if (value === "Prateleira / Pendente") {
                element.attr("data-color", "gray");
            } else if (value === "Costura / Confecção") {
                element.attr("data-color", "blue");
            } else if (value === "Conferencia Final") {
                element.attr("data-color", "lightgreen");
            } else if (value === "Finalizado") {
                element.attr("data-color", "purple");
            } else if (value === "Reposição") {
                element.attr("data-color", "red");
            } else {
                element.removeAttr("data-color");
            }
        }

         // Função para definir a cor de fundo do campo "Checagem Final"
         function setChecagemFinalColor(value, element) {
            if (value === "OK") {
                element.attr("data-color", "green");
            } else if (value === "Ajustado") {
                element.attr("data-color", "lightgreen");
            } else if (value === "Erro") {
                element.attr("data-color", "red");
            } else if (value === "Pendente") {
                element.attr("data-color", "yellow");
            } else {
                element.removeAttr("data-color");
            }
        }
        function setDataColor(value, element) {
            var today = new Date();
            
            // Converta a string de data (dd/mm/yyyy) para um objeto Date reconhecível
            var dateParts = value.split("/");
            var data = new Date(dateParts[2], dateParts[1] -1, dateParts[0]);
            
            var diffInDays = Math.floor((data - today) / (1000 * 60 * 60 * 24));


            if (isNaN(data.getTime())) {
                // Se a data for inválida, defina a cor como verde
                element.attr("data-color", "green");
            } else if (diffInDays < -1) {
                // Se a data for igual ou posterior ao dia atual, a cor será vermelha
                element.attr("data-color", "red");
            } 
            else if(diffInDays > -1){
                // Caso contrário, a cor será verde
                element.attr("data-color", "lightgreen");
            } else if (diffInDays = -1) {
                // Se estiver dentro dos três dias futuros a partir do dia atual, a cor será amarela
                element.attr("data-color", "green");
            }
            
        }


        // Função para atualizar as cores de fundo dos campos
        function updateColors() {
            $("#tabela-pedidos tbody tr").each(function() {
                var status = $(this).find("select[name='status']").val();
                var data = $(this).find("input[name='data']").val();

                setStatusColor(status, $(this).find("td:nth-child(7)"));
                setDataColor(data, $(this).find("td:nth-child(2)"));

            });
        }
        function atualizarQuantidadeRegistros() {
            let quantidadeRegistros = $('#tabela-pedidos').DataTable().data().count();
            $('#quantidade-registros').text('Quantidade: ' + quantidadeRegistros + ' registros');
        }
        // Chamada inicial para atualizar as cores ao carregar a página
        updateColors();

        $("#tabela-pedidos").on("change", "select[name='status'], input[name='data']", function() {
            updateColors();
        });

        // Evento "draw.dt" para manter as cores ao mudar de página
        $('#tabela-pedidos').on('draw.dt', function() {
            updateColors();
        });
        // Inicialize o Datepicker para o campo de data
        $('.datepicker').datepicker({
            dateFormat: 'dd/mm/yy',
            language: 'pt-BR',
            autoclose: true,
            onSelect: function (dateText, inst) {
                // Quando uma data for selecionada no datepicker, atualizar o valor na célula da tabela
                let cell = table.cell($(this).closest('td'));
                cell.data(dateText).draw();
            }


    });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const tabelaPedidos = document.getElementById('tabela-pedidos');
  const metragemTotalDiv = document.getElementById('metragem_total');
  // Função para calcular a metragem total
  function calcularMetragemTotal() {
    let metragemTotal = 0;
    // Loop pelas linhas da tabela
    for (let i = 0; i < tabelaPedidos.rows.length; i++) {
        const linha = tabelaPedidos.rows[i];
        // Seleciona o input
        const inputMedida = linha.querySelector('input[name="medida_linear"]');
        // Verifica se o input existe antes de tentar ler o value
        if (inputMedida) {
        const medidaLinear = parseFloat(inputMedida.value);
        // Soma apenas se tiver uma medida válida
        if (!isNaN(medidaLinear)) {
            metragemTotal += medidaLinear; 
        }
        }
    }
    return metragemTotal.toFixed(2);
    }
    function converterTempo(tempoEmHoras) {
    if (tempoEmHoras >= 24) {
        const dias = Math.floor(tempoEmHoras / 24);
        const horasRestantes = tempoEmHoras % 24;
        return `${dias} dia(s) e ${horasRestantes} hora(s)`;
    } else if (tempoEmHoras < 1) {
        const minutos = Math.floor(tempoEmHoras * 60);
        return `${minutos} minuto(s)`;
    } else {
        const horas = Math.floor(tempoEmHoras);
        const minutosRestantes = Math.floor((tempoEmHoras - horas) * 60);
        return `${horas} hora(s) e ${minutosRestantes} minuto(s)`;
    }
    }
  // Função para calcular a metragem por hora
    function calcularMetragemPorHora() {
        const metragemTotal = calcularMetragemTotal();
        const metrosPorHora = 60; // Altere o valor conforme necessário
        const metragemPorHora = (metragemTotal / metrosPorHora).toFixed(2);
        return converterTempo(metragemPorHora);
    }
  // Função para calcular a metragem por tipo de material
  function calcularMetragemPorMaterial() {
    const metragemPorMaterial = {};
    // Loop pelas linhas da tabela
    for (let i = 0; i < tabelaPedidos.rows.length; i++) {
        const linha = tabelaPedidos.rows[i];
        // Seleciona os elementos
        const selectMaterial = linha.querySelector('select[name="material"]');
        console.log(selectMaterial);
        const inputMedida = linha.querySelector('input[name="medida_linear"]');
        // Verifica se os elementos existem antes de tentar ler os valores
        if (selectMaterial && inputMedida) {
        const material = selectMaterial.options[selectMaterial.selectedIndex].text;
        const medidaLinear = parseFloat(inputMedida.value);
        // Faz validação extra da medida linear
        if (!isNaN(medidaLinear)) {
            // Soma no objeto de metragem por material
            if (metragemPorMaterial[material]) {
            metragemPorMaterial[material] += medidaLinear;
            } else {
            metragemPorMaterial[material] = medidaLinear;
            }
        }
        }
    }
    for (const material in metragemPorMaterial) {
        metragemPorMaterial[material] = metragemPorMaterial[material].toFixed(2);
    }
        return metragemPorMaterial;
    }
    // Função para calcular a quantidade de cada produto
    function calcularQuantidadePorProduto() {
        const quantidadePorProduto = {};
        // Loop pelas linhas da tabela
        for (let i = 0; i < tabelaPedidos.rows.length; i++) {
            const linha = tabelaPedidos.rows[i];
            // Seleciona o select de produto
            const selectProduto = linha.querySelector('select[name="produto"]');
            // Verifica se o select existe antes de tentar ler o value
            if (selectProduto) {
            const produto = selectProduto.value;
            // Soma a quantidade apenas se tiver produto válido
            if (produto) {
                if (quantidadePorProduto[produto]) {
                quantidadePorProduto[produto] += 1; 
                } else {
                quantidadePorProduto[produto] = 1;
                }
            }
            }
        }
        
        // Ordena o objeto de quantidadePorProduto por quantidade
        const quantidadeOrdenada = Object.entries(quantidadePorProduto).sort((a, b) => b[1] - a[1]);
        // Retorna o objeto de quantidadePorProduto ordenado
        return quantidadeOrdenada;
    }
    function atualizarMetragemTotal() {
        const metragemTotal = calcularMetragemTotal();
        const metragemPorHora = calcularMetragemPorHora();
        const metragemPorMaterial = calcularMetragemPorMaterial();
        const quantidadePorProduto = calcularQuantidadePorProduto();
        console.log(metragemPorMaterial);
        metragemTotalDiv.innerHTML = `
            <div style="display: flex; flex-direction: row;">
            <div style="margin-right: 20px;">
                <p>Metragem Total: ${metragemTotal}M</p>
                <p>Metragem por Hora: ${metragemPorHora}</p>
                <p>Metragem por Material:</p>
                <ul>
                ${Object.entries(metragemPorMaterial)
                    .map(([material, metragem]) => `<li>${material ? material : 'Sem material definido'}: ${metragem}M</li>`)
                    .join('')}
                </ul>
            </div>
            <div style="margin-left: 20px;">
                <p>Quantidade por Produto:</p>
                <ul>
                ${(() => {
                    let lista = '';
                    quantidadePorProduto.forEach(([produto, quantidade]) => {
                        lista += `<li>${produto}(s): ${quantidade} </li>`;
                    });
                    return lista;
                })()}
                </ul>
            </div>
            </div>
        `;
    }
  // Atualizar as informações quando houver mudanças nos campos relevantes
  tabelaPedidos.addEventListener('input', atualizarMetragemTotal);
  // Atualizar as informações quando a página for carregada
  atualizarMetragemTotal();
});
</script>
@endsection

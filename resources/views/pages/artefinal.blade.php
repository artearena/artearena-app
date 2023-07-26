@extends('layout.main')

@section('title')
Consulta de Pedidos
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.dataTables.min.css">

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
        background-color: #FF0000; /* Vermelho */
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
        background-color: #FFA500; /* Laranja */
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
    /* Definindo cores de texto para os campos */
    td[data-color="red"], td[data-color="orange"], td[data-color="pink"], td[data-color="purple"], td[data-color="blue"] {
        color: white;
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
                                        <option value="Pendente">Pendente</option>
                                        <option value="Em andamento">Em andamento</option>
                                        <option value="Arte concluída">Arte concluída</option>
                                        <option value="Em confirmação">Em confirmação</option>
                                        <option value="Em espera">Em espera</option>
                                        <option value="Cor teste">Cor teste</option>
                                        <option value="Terceirizado">Terceirizado</option>
                                        <option value="Análise pendente">Análise pendente</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label for="designer">Designer:</label>
                                    <select class="form-control" name="designer" id="designer">
                                        <option value=""></option>
                                        @foreach($designers as $designer)
                                        <option value="{{ $designer }}">{{ $designer }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label for="tipo_pedido">Tipo de Pedido:</label>
                                    <select class="form-control" name="tipo_pedido" id="tipo_pedido">
                                        <option value="Prazo normal">Prazo normal</option>
                                        <option value="Antecipação">Antecipação</option>
                                        <option value="Faturado">Faturado</option>
                                        <option value="Metade/Metade">Metade/Metade</option>
                                        <option value="Amostra">Amostra</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label for="checagem_final">Checagem Final:</label>
                                    <select class="form-control" name="checagem_final" id="checagem_final">
                                        <option value="Pendente">Pendente</option>
                                        <option value="Ajustado">Ajustado</option>
                                        <option value="Erro">Erro</option>
                                        <option value="OK">OK</option>
                                    </select>
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
                    <h2>Pedidos existentes:</h2>
                    <div class="tabela-container">
                    <div id="loading" class="text-center" style="display: none;">
                        <p>Carregando...</p>
                    </div>
                    <table id="tabela-pedidos" class="table table-striped">
                        <thead>
                            <tr>
                                <th data-filter="true">Pedido</th>
                                <th data-filter="true">Data</th>
                                <th data-filter="true">Produto</th>
                                <th data-filter="true">Material</th>
                                <th data-filter="true">Medida Linear</th>
                                <th data-filter="true">Observações</th>
                                <th data-filter="true">Dificuldade</th>
                                <th data-filter="true">Status</th>
                                <th data-filter="true">Designer</th>
                                <th data-filter="true">Tipo de Pedido</th>
                                <th data-filter="true">Checagem Final</th>
                                <th>Tiny</th>
                                <th>Mover</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                            @if($pedido->etapa == 'A')
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
                                    <select class='form-control' name='dificuldade'>
                                        <option value="" {{ $pedido->dificuldade === null ? 'selected' : '' }}></option>
                                        <option value="Muito fácil" {{ $pedido->dificuldade === 'Muito fácil' ? 'selected' : '' }}>Muito fácil</option>
                                        <option value="Fácil" {{ $pedido->dificuldade === 'Fácil' ? 'selected' : '' }}>Fácil</option>
                                        <option value="Médio" {{ $pedido->dificuldade === 'Médio' ? 'selected' : '' }}>Médio</option>
                                        <option value="Difícil" {{ $pedido->dificuldade === 'Difícil' ? 'selected' : '' }}>Difícil</option>
                                        <option value="Muito difícil" {{ $pedido->dificuldade === 'Muito difícil' ? 'selected' : '' }}>Muito difícil</option>
                                    </select>
                                </td>


                                <td>
                                    <select class='form-control' name='status'>
                                        <option value="Pendente" {{ $pedido->status == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="Em andamento" {{ $pedido->status == 'Em andamento' ? 'selected' : '' }}>Em andamento</option>
                                        <option value="Arte concluída" {{ $pedido->status == 'Arte concluída' ? 'selected' : '' }}>Arte concluída</option>
                                        <option value="Em confirmação" {{ $pedido->status == 'Em confirmação' ? 'selected' : '' }}>Em confirmação</option>
                                        <option value="Em espera" {{ $pedido->status == 'Em espera' ? 'selected' : '' }}>Em espera</option>
                                        <option value="Cor teste" {{ $pedido->status == 'Cor teste' ? 'selected' : '' }}>Cor teste</option>
                                        <option value="Terceirizado" {{ $pedido->status == 'Terceirizado' ? 'selected' : '' }}>Terceirizado</option>
                                        <option value="Análise pendente" {{ $pedido->status == 'Análise pendente' ? 'selected' : '' }}>Análise pendente</option>
                                        <option value="{{ $pedido->status }}" {{ !in_array($pedido->status, ['Pendente', 'Em andamento', 'Arte concluída', 'Em confirmação', 'Em espera', 'Cor teste', 'Terceirizado', 'Análise pendente']) ? 'selected' : '' }}>
                                            {{ $pedido->status }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class='form-control' name='designer'>
                                        @foreach($designers as $designer)
                                        <option value="{{ $designer }}" {{ $pedido->designer == $designer ? 'selected' : '' }}>
                                            {{ $designer }}
                                        </option>
                                        @endforeach
                                        <option value="{{ $pedido->designer }}" {{ !in_array($pedido->designer, $designers->toArray()) ? 'selected' : '' }}>
                                            {{ $pedido->designer }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class='form-control' name='tipo_pedido'>
                                        <option value="Prazo normal" {{ $pedido->tipo_pedido == 'Prazo normal' ? 'selected' : '' }}>Prazo normal</option>
                                        <option value="Antecipação" {{ $pedido->tipo_pedido == 'Antecipação' ? 'selected' : '' }}>Antecipação</option>
                                        <option value="Faturado" {{ $pedido->tipo_pedido == 'Faturado' ? 'selected' : '' }}>Faturado</option>
                                        <option value="Metade/Metade" {{ $pedido->tipo_pedido == 'Metade/Metade' ? 'selected' : '' }}>Metade/Metade</option>
                                        <option value="Amostra" {{ $pedido->tipo_pedido == 'Amostra' ? 'selected' : '' }}>Amostra</option>
                                        <option value="{{ $pedido->tipo_pedido }}" {{ !in_array($pedido->tipo_pedido, ['Prazo normal', 'Antecipação', 'Faturado', 'Metade/Metade', 'Amostra']) ? 'selected' : '' }}>
                                            {{ $pedido->tipo_pedido }}
                                        </option>
                                    </select>
                                </td>
                                <td class="@if($pedido->checagem_final == 'Pendente') table-warning
                                            @elseif($pedido->checagem_final == 'Ajustado') table-info
                                            @elseif($pedido->checagem_final == 'Erro') table-danger
                                            @elseif($pedido->checagem_final == 'OK') table-success
                                            @endif">
                                    <select class='form-control' name='checagem_final'>
                                        <option value="Pendente" {{ $pedido->checagem_final == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="Ajustado" {{ $pedido->checagem_final == 'Ajustado' ? 'selected' : '' }}>Ajustado</option>
                                        <option value="Erro" {{ $pedido->checagem_final == 'Erro' ? 'selected' : '' }}>Erro</option>
                                        <option value="OK" {{ $pedido->checagem_final == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="{{ $pedido->checagem_final }}" {{ !in_array($pedido->checagem_final, ['Pendente', 'Ajustado', 'Erro', 'OK']) ? 'selected' : '' }}>
                                            {{ $pedido->checagem_final }}
                                        </option>
                                    </select>
                                </td>
                                <td><input type='text' class='form-control' name='tiny' value="{{ $pedido->tiny }}"></td>
                                <td>
                                    <button type="button" class="btn btn-primary mover-pedido" data-id="{{ $pedido->id }}">
                                        <i class="bi bi-arrows-move"></i> <!-- Ícone de quatro setas do Bootstrap -->
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
                Tem certeza de que deseja mover este pedido para a etapa de Impressão?
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
                "width": "70px"
            },
            {
                "targets": [2],
                "width": "90px"
            },
            {
                "targets": [7],
                "width": "120px"
            },
            {
                "targets": [9],
                "width": "100px"
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
            },
            {
                "targets": [11], "visible": false
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
        "infoCallback": function(settings, start, end, max, total, pre) {
            return '<span style="font-size: 1.2em; font-weight: bold;">Quantidade: ' + total + ' registros</span>';
        },
        "ordering": true
    });

    $('#tabela-pedidos tbody').on('mouseenter', 'td.expandir-observacoes', function() {
        var inputField = $(this).find('.observacoes-field');
        var fullText = inputField.val();
        inputField.attr('title', fullText);
    });

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
        var designer = $('#designer').val();
        var tipo_pedido = $('#tipo_pedido').val();
        var checagem_final = $('#checagem_final').val();
        var tiny = $('#tiny').val();
        var etapa = 'A';


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
                designer: designer,
                tipo_pedido: tipo_pedido,
                checagem_final: checagem_final,
                tiny: tiny,
                etapa: etapa,
                "_token": "{{ csrf_token() }}" // Adicione o token CSRF do Laravel para prevenir ataques CSRF
            },
            success: function(response) {
                console.log(response.message);
                
                var newRow = '<tr>';
                newRow += '<td>' + response.pedido.id + '</td>';
                newRow += '<td>' + response.pedido.data + '</td>';
                newRow += '<td>' + response.pedido.produto + '</td>';
                newRow += '<td>' + response.pedido.material + '</td>';
                newRow += '<td>' + response.pedido.medida_linear + '</td>';
                newRow += '<td>' + response.pedido.observacoes + '</td>';
                newRow += '<td>' + response.pedido.status + '</td>';
                newRow += '<td>' + response.pedido.designer + '</td>';
                newRow += '<td>' + response.pedido.tipo_pedido + '</td>';
                newRow += '<td>' + response.pedido.checagem_final + '</td>';
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



    $('.table input, .table select').change(function() {
    var id = $(this).closest('td').siblings(':first-child').text();
    var field = $(this).attr('name');
    var value = $(this).val();
    console.log(id);
    console.log(field);
    console.log(value);

    // Verifica se o campo é uma data e converte para o formato correto (YYYY-MM-DD HH:mm:ss)
    if (field === 'data') {
        var dateParts = value.split('/');
        if (dateParts.length === 3) {
            value = dateParts[2] + '-' + dateParts[0] + '-' + dateParts[1] + ' 00:00:00';
        } else {
            console.error('Formato de data inválido. Formato esperado: dd/mm/yyyy');
            return;
        }
    }
    console.log(value);

    $.ajax({
        url: '/pedido/' + id, // Atualize o URL para '/pedido/{id}'
        method: 'PUT',
        data: {
            [field]: value,
            "_token": "{{ csrf_token() }}", // Adicione o token CSRF do Laravel para prevenir ataques CSRF
        },
        success: function(response) {
            console.log(response.message);
        },
        error: function(xhr, status, error) {
            console.error(error); // Log any errors that occur during the AJAX request.
        }
    });
});

function reatribuirEventosChange() {
    $('#tabela-pedidos').off('change', '.table input, .table select'); // Remover eventos "change" anteriores
    $('#tabela-pedidos').on('change', '.table input, .table select', function() {
        var id = $(this).closest('tr').find('td:first-child').text();
        var field = $(this).attr('name');
        var value = $(this).val();
        var $this = $(this); // Salvar a referência do this aqui
        console.log(value);
        
        // Verifica se o campo é uma data e converte para o formato correto (yyyy-mm-dd HH:mm:ss)
        if (field === 'data') {
            var dateParts = value.split('/');
            if (dateParts.length === 3) {
                value = dateParts[2] + '-' + dateParts[0] + '-' + dateParts[1] + ' 00:00:00';
            } else {
                console.error('Formato de data inválido. Formato esperado: dd/mm/yyyy');
                return;
            }
        }

        $.ajax({
            url: '/pedido/' + id,
            method: 'PUT',
            data: {
                [field]: value,
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                console.log(response.message);

                // Atualize os dados na tabela após a requisição bem-sucedida
                var table = $('#tabela-pedidos').DataTable();
                var row = table.row($this.closest('tr')); // Usar a referência $this aqui
                row.data(response.pedido);
                row.draw();
            },
            error: function(xhr, status, error) {
                console.error(error); // Log any errors that occur during the AJAX request.
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

    $('#cancelMoverImpressaoButton').click(function () {
        $('#confirmMoverImpressaoModal').modal('hide');
    });

    // Script para processar a movimentação do pedido após a confirmação
    $('#confirmMoverImpressaoButton').click(function () {
        var pedidoId = $(this).attr('data-id');

        // Enviar a requisição AJAX para mover o pedido para a etapa de "Impressão"
        $.ajax({
            url: "/pedido/mover/" + pedidoId,
            method: 'PUT',
            data: {
                etapa: 'I', // Considerando 'I' como a etapa de "Impressão"
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
        function setDificuldadeColor(value, element) {
            if (value === "Muito fácil") {
                element.attr("data-color", "green");
            } else if (value === "Fácil") {
                element.attr("data-color", "lightgreen");
            } else if (value === "Médio") {
                element.attr("data-color", "yellow");
            } else if (value === "Difícil") {
                element.attr("data-color", "orange");
            } else if (value === "Muito difícil") {
                element.attr("data-color", "red");
            } else {
                element.removeAttr("data-color");
            }
        }
        // Função para definir a cor de fundo do campo "Status"
        function setStatusColor(value, element) {
            if (value === "Em andamento") {
                element.attr("data-color", "lightgreen");
            } else if (value === "Pendente") {
                element.attr("data-color", "yellow");
            } else if (value === "Arte concluída") {
                element.attr("data-color", "green");
            } else if (value === "Em confirmação") {
                element.attr("data-color", "orange");
            } else if (value === "Em espera") {
                element.attr("data-color", "yellow");
            } else if (value === "Cor teste") {
                element.attr("data-color", "blue");
            } else if (value === "Terceirizado") {
                element.attr("data-color", "purple");
            } else if (value === "Análise pendente") {
                element.attr("data-color", "pink");
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
            var data = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
            
            var diffInDays = Math.floor((data - today) / (1000 * 60 * 60 * 24));

            if (isNaN(data.getTime())) {
                // Se a data for inválida, defina a cor como verde
                element.attr("data-color", "green");
            } else if (diffInDays <= 0) {
                // Se a data for igual ou posterior ao dia atual, a cor será vermelha
                element.attr("data-color", "red");
            } else if (diffInDays <= 3) {
                // Se estiver dentro dos três dias futuros a partir do dia atual, a cor será amarela
                element.attr("data-color", "yellow");
            } else {
                // Caso contrário, a cor será verde
                element.attr("data-color", "green");
            }
        }

        function setTipoPedidoColor(value, element) {
            if (value === "Prazo normal") {
                element.attr("data-color", "blue");
            } else if (value === "Antecipação") {
                element.attr("data-color", "purple");
            } else if (value === "Faturado") {
                element.attr("data-color", "green");
            } else if (value === "Metade/Metade") {
                element.attr("data-color", "orange");
            } else if (value === "Amostra") {
                element.attr("data-color", "pink");
            } else {
                element.removeAttr("data-color");
            }
        }
        // Função para atualizar as cores de fundo dos campos
        function updateColors() {
            $("#tabela-pedidos tbody tr").each(function() {
                var dificuldade = $(this).find("select[name='dificuldade']").val();
                var status = $(this).find("select[name='status']").val();
                var checagemFinal = $(this).find("select[name='checagem_final']").val();
                var data = $(this).find("input[name='data']").val();
                var tipoPedido = $(this).find("select[name='tipo_pedido']").val(); // Adicione essa linha

                setDificuldadeColor(dificuldade, $(this).find("td:nth-child(7)"));
                setStatusColor(status, $(this).find("td:nth-child(8)"));
                setChecagemFinalColor(checagemFinal, $(this).find("td:nth-child(11)"));
                setDataColor(data, $(this).find("td:nth-child(2)"));
                setTipoPedidoColor(tipoPedido, $(this).find("td:nth-child(10)")); // Adicione essa linha

            });
        }
        function atualizarQuantidadeRegistros() {
            let quantidadeRegistros = $('#tabela-pedidos').DataTable().data().count();
            $('#quantidade-registros').text('Quantidade: ' + quantidadeRegistros + ' registros');
        }
        // Chamada inicial para atualizar as cores ao carregar a página
        updateColors();

        $("#tabela-pedidos").on("change", "select[name='dificuldade'], select[name='status'], select[name='checagem_final'], input[name='data'], select[name='tipo_pedido']", function() {
            updateColors();
        });

        // Evento "draw.dt" para manter as cores ao mudar de página
        $('#tabela-pedidos').on('draw.dt', function() {
            updateColors();
        });
        // Inicialize o Datepicker para o campo de data
        $('.datepicker').datepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function (dateText, inst) {
            // Quando uma data for selecionada no datepicker, atualizar o valor na célula da tabela
            let cell = table.cell($(this).closest('td'));
            cell.data(dateText).draw();
        }


    });
});

</script>
@endsection

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
<link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.4/css/colReorder.dataTables.min.css">

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
        background-color: #ffff00; /* Amarelo */
    }

    td[data-color="green"] {
        background-color: #7DD100; /* Verde */
    }

    td[data-color="lightgreen"] {
        background-color: #BDFF43; /* Verde claro */
    }

    td[data-color="orange"] {
        background-color: #FF8C00; /* Laranja */
    }
    td[data-color="pink"] {
        background-color: #FFC8AA; /* rosa */
    }
    td[data-color="lightpink"] {
        background-color: #FFCFC9; /* rosa claro*/
    }
    td[data-color="purple"] {
        background-color: #8B008B; /* roxo */
    }
    td[data-color="blue"] {
        background-color: #007FFF; /* azul */
    }
    td[data-color="cyan"] {
        background-color: #BFE1F6; /* ciano */
    }
    td[data-color="white"] {
        background-color: white; /* branco */
    }
    td[data-color="gray"] {
        background-color: #3D3D3D; /* cinza */
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
    .mensagem-flutuante {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #333;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    .mensagem-flutuante.mostrar {
        opacity: 1;
    }
    tr.selected td {
        color: white;
    }
    .destacado {
        background-color: orange;
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
                                    <input class="form-control datepicker" name="data" id="data">
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
                                        <option value="Arte OK">Arte OK</option>
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
                                    <label for="link_trello">Link do Trello:</label>
                                    <input type="text" class="form-control" name="link_trello" id="link_trello">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="cadastrarPedido">Cadastrar Pedido</button>
                    </form>
                    <hr>
                    <div class="tabela-container">
                    <div id="loading" class="text-center" style="display: none;">
                        <p>Carregando...</p>
                    </div>
                    <div id="recordsInfoContainer" style="font-size: 1.2em; font-weight: bold;"></div>

                    <table id="tabela-pedidos" class="table table-striped table-colreorder">
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
                                <th>Ações</th>
                                <th style="display:none">ID Usuario</th> 

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
                                        <option value="Arte OK" {{ $pedido->status == 'Arte OK' ? 'selected' : '' }}>Arte OK</option>
                                        <option value="Em confirmação" {{ $pedido->status == 'Em confirmação' ? 'selected' : '' }}>Em confirmação</option>
                                        <option value="Em espera" {{ $pedido->status == 'Em espera' ? 'selected' : '' }}>Em espera</option>
                                        <option value="Cor teste" {{ $pedido->status == 'Cor teste' ? 'selected' : '' }}>Cor teste</option>
                                        <option value="Terceirizado" {{ $pedido->status == 'Terceirizado' ? 'selected' : '' }}>Terceirizado</option>
                                        <option value="Análise pendente" {{ $pedido->status == 'Análise pendente' ? 'selected' : '' }}>Análise pendente</option>
                                        <option value="{{ $pedido->status }}" {{ !in_array($pedido->status, ['Pendente', 'Em andamento', 'Arte OK', 'Em confirmação', 'Em espera', 'Cor teste', 'Terceirizado', 'Análise pendente']) ? 'selected' : '' }}>
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
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-primary ms-1 abrir-modal" data-bs-toggle="modal" data-bs-target="#pedidoModal" data-id-pedido="{{ $pedido->id }}">
                                            <i class="bi bi-eye"></i> <!-- Ícone do olho do Bootstrap Icons -->
                                        </button>
                                        <a href="{{ $pedido->link_trello }}" class="btn btn-primary ms-1" data-id="{{ $pedido->id }}" onclick="return confirmarLink(this)" target="_blank">
                                            <i class="fa-brands fa-trello"></i> <!-- Ícone de cadeado do Font Awesome -->
                                        </a>
                                        <button type="button" class="btn btn-primary ms-1 mover-pedido" data-id="{{ $pedido->id }}">
                                            <i class="bi bi-arrows-move"></i> <!-- Ícone de quatro setas do Bootstrap -->
                                        </button>
                                        <button type="button" class="btn btn-danger ms-1 excluir-pedido" data-id="{{ $pedido->id }}">
                                            <i class="fas fa-trash-alt"></i> <!-- Ícone de caixa de lixo do Font Awesome -->
                                        </button>
                                        
                                    </div>
                                </td>
                                <td style="display:none">{{ auth()->id() }}</td> 

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
<div class="modal" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pedidoModalLabel">Detalhes do Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Número do Pedido:</strong> <span id="numeroPedido"></span></p>
        <p><strong>Data Prevista:</strong> <span id="dataPrevista"></span></p>
        <p><strong>Observação do Pedido:</strong> <span id="observacaoPedido"></span></p>
        <h6><strong>Produtos do Pedido:</strong></h6>
        <ul id="listaProdutos"></ul>
        <p><strong>Transportadora:</strong> <span id="transportadora"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
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
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script src="https://cdn.datatables.net/colreorder/1.5.4/js/dataTables.colReorder.min.js"></script>

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
            select: true,
            order: [[1, 'asc']],
            "lengthMenu": [[10, 25, 50, 100, 200, 300], [10, 25, 50, 100, 200, 300]],
            "pageLength": 300,
            "columnDefs": [
                // Definições das colunas, incluindo a função "render" para formatar a data
                
                {
                    "targets": [0],
                    "width": "3px",
                },
                {
                    "targets": [4],
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
                    "targets": [11], "visible": true
                },
                {
                    "targets": [10], "visible": true
                },
                {
                    "targets": [9], "visible": false
                } 
                // -Adicione mais definições de colunas conforme necessário
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

            ordering: true,
            columnResizing: true,
            colReorder: true,
        });
        // Selecione a linha onde o ID do usuário bate com o logado
        let row = table.row(function(idx, data) {
        return data[18] === {{ auth()->id() }}; 
        });

        // Adicione uma classe CSS para destacar
        row.nodes().to$().addClass('destacado');

        table.on('select', function() {
            var contador = table.rows({ selected: true }).count();
            $('#contador-registros-selecionados').text(contador);

            var mensagem = contador + ' registros selecionados';
            exibirMensagemFlutuante(mensagem);
        });

        function exibirMensagemFlutuante(mensagem) {
            var mensagemFlutuante = $('<div class="mensagem-flutuante">' + mensagem + '</div>');
            $('body').append(mensagemFlutuante);

            setTimeout(function() {
            mensagemFlutuante.addClass('mostrar');
            }, 100);

            setTimeout(function() {
            mensagemFlutuante.removeClass('mostrar');
            setTimeout(function() {
                mensagemFlutuante.remove();
            }, 500);
            }, 3000);
        }

        $('#tabela-pedidos tbody').on('mouseenter', 'td.expandir-observacoes', function() {
            var inputField = $(this).find('.observacoes-field');
            var fullText = inputField.val();
            inputField.attr('title', fullText);
        });

        // Restante do código para configurar a tabela
        // ...
    }

    $('#cadastrarPedido').click(function(e) {
        e.preventDefault(); // Evita o comportamento padrão do formulário
        
        // Obtenha os valores dos campos do formulário
        var id = $('#id').val();
        var data = $('#data').val();
        var partesData = data.split('/');
        var data = partesData[2] + '-' + partesData[1] + '-' + partesData[0];
        var produto = $('#produto').val();
        var material = $('#material').val();
        var medida_linear = $('#medida_linear').val();
        var observacoes = $('#observacoes').val();
        var status = $('#status').val();
        var designer = $('#designer').val();
        var tipo_pedido = $('#tipo_pedido').val();
        var checagem_final = $('#checagem_final').val();
        var link_trello = $('#link_trello').val();
        var etapa = 'A';
        
        // Verificar se os campos obrigatórios estão preenchidos
        if (id === '' || data === '' || link_trello === '') {
            var campoFaltante = '';
            if (id === '') campoFaltante = 'o ID';
            else if (data === '') campoFaltante = 'a data';
            else if (link_trello === '') campoFaltante = 'o link do trello';

            Swal.fire({
                title: 'Campos obrigatórios',
                text: 'Por favor, preencha ' + campoFaltante,
                icon: 'warning',
                timer: 3000,
                showConfirmButton: false
            });
            return;
        }
        
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
                etapa: etapa,
                link_trello: link_trello,
                "_token": "{{ csrf_token() }}" // Adicione o token CSRF do Laravel para prevenir ataques CSRF
            },
            success: function(response) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Pedido criado com sucesso. Atualize a página para que o registro entre em vigor.',
                    icon: 'success',
                    timer: 3000, // Defina o tempo que o alerta será exibido (em milissegundos)
                    showConfirmButton: false // Ocultar o botão "OK"
                });
                
                // Restante do código...
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
            // Enviar notificação para o servidor após a alteração do status
            var pedidoId = id;
            var novoStatus = value;
            var mensagem = 'Pedido: ' + pedidoId + ' teve o status alterado para: ' + novoStatus;
            
            // Fazer a requisição para o servidor enviando a mensagem como parâmetro na URL
            var url = 'https://artearena.kinghost.net/enviarNotificacaoSlack?mensagem=' + mensagem;
            console.log(url);
            
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
            
            // Verifique se o campo é uma data e converte para o formato correto (yyyy-mm-dd HH:mm:ss)
            if (field === 'data') {
                var dateParts = value.split('/');
                if (dateParts.length === 3) {
                    value = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0] + ' 00:00:00';
                } else {
                    console.error('Formato de data inválido. Formato esperado: dd/mm/yyyy');
                    return;
                }
            }
            
            // Verifica se o campo é uma medida linear
            var isLinearMeasurementField = ['medida_linear'].includes(field);
            
            // Verifica se o campo é uma medida linear e se o valor está no formato correto (número positivo com até duas casas decimais)
            if (isLinearMeasurementField && !value.match(/^\d+(\.\d{1,2})?$/)) {
                swal('Atenção', 'Insira um número positivo com até duas casas decimais.', 'warning');
                return;
            }
            
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
    $('#tabela-pedidos').on('click', '.btn-check', function() {
        var cadastroId = $(this).data('id');
        // Aqui você pode adicionar a lógica para marcar o cadastro com o ID cadastroId
        console.log('Cadastro marcado:', cadastroId);
    });
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
            var medidaLinearValue = $('tr[data-id="' + pedidoId + '"]').find('input[name="medida_linear"]').val();

            // Verifique se o campo "Medida Linear" está preenchido
            if (medidaLinearValue === '') {
                // Mostra o aviso com o SweetAlert
                Swal.fire({
                    title: 'Atenção',
                    text: 'O campo "Medida Linear" deve ser preenchido antes de mover o pedido para a etapa de "Impressão".',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

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
                    element.attr("data-color", "cyan");
                } else if (value === "Difícil") {
                    element.attr("data-color", "blue");
                } else if (value === "Muito difícil") {
                    element.attr("data-color", "purple");
                } else {
                    element.removeAttr("data-color");
                }
            }
            // Função para definir a cor de fundo do campo "Status"
            function setStatusColor(value, element) {
                if (value === "Em andamento") {
                    element.attr("data-color", "cyan");
                } else if (value === "Pendente") {
                    element.attr("data-color", "white");
                } else if (value === "Arte OK") {
                    element.attr("data-color", "green");
                } else if (value === "Em confirmação") {
                    element.attr("data-color", "red");
                } else if (value === "Em espera") {
                    element.attr("data-color", "pink");
                } else if (value === "Cor teste") {
                    element.attr("data-color", "lightpink");
                } else if (value === "Terceirizado") {
                    element.attr("data-color", "purple");
                } else if (value === "Análise pendente") {
                    element.attr("data-color", "gray");
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
            function confirmarLink(link) {
                var confirmacao = confirm("Deseja ir para o link: " + link.href + "?");
                if (confirmacao) {
                    return true; // Continua para o link
                } else {
                    return false; // Cancela o evento de clique
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
                    setChecagemFinalColor(checagemFinal, $(this).find("td:nth-child(10)"));
                    setDataColor(data, $(this).find("td:nth-child(2)"));
                    //setTipoPedidoColor(tipoPedido, $(this).find("td:nth-child(10)")); // Adicione essa linha

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
            language: 'pt-BR',
            autoclose: true,
            onSelect: function (dateText, inst) {
                // Quando uma data for selecionada no datepicker, atualizar o valor na célula da tabela
                let cell = table.cell($(this).closest('td'));
                cell.data(dateText).draw();
            }


        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const abrirModalButtons = document.querySelectorAll('.abrir-modal');
        
        abrirModalButtons.forEach(button => {
            button.addEventListener("click", function () {
            // Obtém o ID do pedido a partir da primeira coluna da linha da tabela
            const idPedido = this.dataset.idPedido;
            exibirModalPedido(idPedido);
            });
        });

        // Função para preencher e exibir o modal com os dados do pedido
        function exibirModalPedido(idPedido) {
            const apiUrl = `https://artearena.kinghost.net/consultar-pedido?numero=${idPedido}`;

            // Realiza a requisição à sua própria API
            fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById("numeroPedido").textContent = data.numeroPedido;
                document.getElementById("dataPrevista").textContent = data.dataPrevista;
                document.getElementById("observacaoPedido").textContent = data.observacaoPedido; // Exibe a observação do pedido

                const listaProdutos = document.getElementById("listaProdutos");
                listaProdutos.innerHTML = "";
                data.produtos.forEach(produto => {
                const li = document.createElement("li");
                li.innerHTML = `<strong>Descrição:</strong> ${produto.descricao}, <strong>Código SKU:</strong> ${produto.codigoSku}, <strong>Quantidade:</strong> ${produto.quantidade}`;
                listaProdutos.appendChild(li);
                });

                document.getElementById("transportadora").textContent = data.transportadora;

                // Exibe o modal
                const modal = document.getElementById("pedidoModal");
                modal.style.display = "block";
            })
            .catch(error => {
            console.error("Erro na requisição:", error);
            });
        }
        });




    </script>
    @endsection

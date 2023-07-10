@extends('layout.main')

@section('title')
Consulta de Pedidos
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
<style>
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
                    <table id="tabela-pedidos" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Data</th>
                                <th>Produto</th>
                                <th>Material</th>
                                <th>Medida Linear</th>
                                <th>Observações</th>
                                <th>Status</th>
                                <th>Designer</th>
                                <th>Tipo de Pedido</th>
                                <th>Checagem Final</th>
                                <th>Tiny</th>
                                <th>Mover</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                            @if($pedido->etapa == 'A')
                            <tr data-id="{{ $pedido->id }}">
                                <td>{{ $pedido->id }}</td>
                                <td class="col-1">{{ date('Y-m-d', strtotime($pedido->data)) }}</td>
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

                                <td class="col-md-auto"><input type='number' step='0.01' class='form-control' name='medida_linear' value="{{ $pedido->medida_linear }}"></td>
                                <td><input type='text' class='form-control' name='observacoes' value="{{ $pedido->observacoes }}"></td>
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
                                    <button type="button" class="btn btn-primary mover-pedido" data-id="{{ $pedido->id }}">Mover</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger excluir-pedido" data-id="{{ $pedido->id }}">Excluir</button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </main>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- jQuery -->
<script>
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$(document).ready(function(){
    // Função para cadastrar um novo pedido
    $('#cadastrarPedido').click(function(e) {
        e.preventDefault(); // Evita o comportamento padrão do formulário
        
        // Obtenha os valores dos campos do formulário
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
        console.log('Dados do Pedido:');
        console.log('Data:', data);
        console.log('Produto:', produto);
        console.log('Material:', material);
        console.log('Medida Linear:', medida_linear);
        console.log('Observações:', observacoes);
        console.log('Status:', status);
        console.log('Designer:', designer);
        console.log('Tipo de Pedido:', tipo_pedido);
        console.log('Checagem Final:', checagem_final);
        console.log('Tiny:', tiny);
        console.log('etapa:', etapa);

        // Enviar a requisição AJAX para salvar o pedido
        $.ajax({
            url: '/pedido/criar', // Atualize o URL para '/pedido/criar'
            method: 'POST',
            data: {
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

            }
        });

    });

    // Função para atualizar um pedido existente dentro da tabela
    $('.table input, .table select').change(function() {
        var id = $(this).closest('td').siblings(':first-child').text();
        var field = $(this).attr('name');
        var value = $(this).val();

        $.ajax({
            url: '/pedido/' + id, // Atualize o URL para '/pedido/{id}'
            method: 'PUT',
            data: {
                [field]: value,
                "_token": "{{ csrf_token() }}", // Adicione o token CSRF do Laravel para prevenir ataques CSRF
            },
            success: function(response) {
                console.log(response.message);

            }
        });

    });

    // Função para mover um pedido
    $('.mover-pedido').click(function() {
        var pedidoId = $(this).closest('td').siblings(':first-child').text();
        var row = $(this).closest('tr'); // Obter a linha da tabela
        var etapa = 'I';

        // Enviar a requisição AJAX para mover o pedido
        $.ajax({
            url: '/pedido/mover/' + pedidoId,
            method: 'PUT',
            data: {
                etapa: etapa,
                "_token": "{{ csrf_token() }}", // Adicione o token CSRF do Laravel para prevenir ataques CSRF
            },
            success: function(response) {
                console.log(response.message);
                row.remove();
            }
        });

    });

    // Função para excluir um pedido
    try {
        $('.excluir-pedido').click(function() {

            var pedidoId = $(this).closest('td').siblings(':first-child').text();
            var row = $(this).closest('tr'); // Obter a linha da tabela

            // Enviar a requisição AJAX para excluir o pedido

            $.ajax({
                url: "/pedido/" + pedidoId,
                method: 'delete',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    row.remove();
                    console.log('Excluido com sucesso');
                    // Atualize a tabela ou faça outras ações após a exclusão do pedido
                }
            });
        });
    } catch (error) {
        console.log(error);
    }


});
</script>
@endsection

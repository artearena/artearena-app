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
                                <label for="observacoes">Observações:</label>
                                <textarea class="form-control full-width" name="observacoes" id="observacoes"></textarea>
                            </div>
                            <div class="form-row">
                                <label for="observacoes_reposicao">Observações de Reposição:</label>
                                <textarea class="form-control full-width" name="observacoes_reposicao" id="observacao_reposicao"></textarea>
                            </div>
                        </div>
                 
                        <div class="col-md-6">
                            <div class="form-row">
                                <label for="medida_linear">Medida Linear:</label>
                                <input type="number" step="0.01" class="form-control" name="medida_linear" id="medida_linear">
                            </div>
                            <div class="form-row">
                                <label for="status">Status:</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="Pendente">Pendente</option>
                                    <option value="Processando">Processando</option>
                                    <option value="Renderizado">Renderizado</option>
                                    <option value="Impresso">Impresso</option>
                                    <option value="Em impressão">Em impressão</option>
                                    <option value="Separação">Separação</option>
                                </select>
                            </div>
                            <div class="form-row">
                                <label for="rolo">Rolo:</label>
                                <input type="text" class="form-control" name="rolo" id="rolo">
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
                                <th>PEDIDO</th>
                                <th>DATA</th>
                                <th>PRODUTO</th>
                                <th>MATERIAL</th>
                                <th>MEDIDA LINEAR</th>
                                <th>OBSERVAÇÕES</th>
                                <th>STATUS</th>
                                <th>ROLO</th>
                                <th>OBS. DE REPOSIÇÃO</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                            @if($pedido->etapa == 'R')
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
                                    <select class="form-control" name="status" id="status">
                                        <option value="Pendente" {{ $pedido->status == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="Aguardando arquivo" {{ $pedido->status == 'Aguardando arquivo' ? 'selected' : '' }}>Aguardando arquivo</option>
                                        <option value="Renderizado" {{ $pedido->status == 'Renderizado' ? 'selected' : '' }}>Renderizado</option>
                                        <option value="Em impressão" {{ $pedido->status == 'Em impressão' ? 'selected' : '' }}>Em impressão</option>
                                        <option value="Impresso" {{ $pedido->status == 'Impresso' ? 'selected' : '' }}>Impresso</option>
                                        <option value="{{ $pedido->status }}" {{ !in_array($pedido->status, ['Pendente', 'Aguardando arquivo', 'Renderizado', 'Impresso', 'Em impressão']) ? 'selected' : '' }}>
                                            {{ $pedido->status }}
                                        </option>
                                    </select>
                                </td>

                               
                                
                                <td><input type='text' class='form-control' name='rolo' value="{{ $pedido->rolo }}"></td>
                                <td><input type='text' class='form-control' name='observacao_reposicao' value="{{ $pedido->observacao_reposicao }}"></td>

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
        var rolo = $('#rolo').val();
        var etapa = 'R';
        var observacao_reposicao = $('#observacao_reposicao').val();

        console.log('Dados do Pedido:');
        console.log('Data:', data);
        console.log('Produto:', produto);
        console.log('Material:', material);
        console.log('Medida Linear:', medida_linear);
        console.log('Observações:', observacoes);
        console.log('Status:', status);
        console.log('etapa:', etapa);
        console.log('observacao_reposicao', observacao_reposicao);
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
                etapa: etapa,
                rolo: rolo,
                observacao_reposicao: observacao_reposicao,
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

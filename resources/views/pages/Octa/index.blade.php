@extends('layout.main')
@section('title')
    Listagem de Clientes
@endsection
@section('style')
    <style>
        @import "compass/css3";

        /*

        RESPONSTABLE 2.0 by jordyvanraaij
        Designed mobile first!

        If you like this solution, you might also want to check out the 1.0 version:
        https://gist.github.com/jordyvanraaij/9069194

        */

        // Default options for table style
        $table-breakpoint: 480px;
        $table-background-color: #FFF;
        $table-text-color: #024457;
        $table-outer-border: 1px solid #167F92;
        $table-cell-border: 1px solid #D9E4E6;

        // Extra options for table style (parse these arguments when including your mixin)
        $table-border-radius: 10px;
        $table-highlight-color: #EAF3F3;
        $table-header-background-color: #167F92;
        $table-header-text-color: #FFF;
        $table-header-border: 1px solid #FFF;

        // The Responstable mixin

        @mixin responstable(
        $breakpoint: $table-breakpoint,
        $background-color: $table-background-color,
        $text-color: $table-text-color,
        $outer-border: $table-outer-border,
        $cell-border: $table-cell-border,
        $border-radius: none,
        $highlight-color: none,
        $header-background-color: $table-background-color,
        $header-text-color: $table-text-color,
        $header-border: $table-cell-border) {
        
        .responstable {
            margin: 1em 0;
            width: 100%;
            overflow: hidden;  
            background: $background-color;
            color: $text-color;
            border-radius: $border-radius;
            border: $outer-border;
        
            tr {
            border: $cell-border; 
            &:nth-child(odd) { // highlight the odd rows with a color
                background-color: $highlight-color;
            }  
            }
        
            th {
            display: none; // hide all the table header for mobile
            border: $header-border;
            background-color: $header-background-color;
            color: $header-text-color;
            padding: 1em;  
            &:first-child { // show the first table header for mobile
                display: table-cell;
                text-align: center;
            }
            &:nth-child(2) { // show the second table header but replace the content with the data-th from the markup for mobile
                display: table-cell;
                span {display:none;}
                &:after {content:attr(data-th);}
            }
            @media (min-width: $breakpoint) {
                &:nth-child(2) { // hide the data-th and show the normal header for tablet and desktop
                span {display: block;}
                &:after {display: none;}
                }
            }
            }
        
            td {
            display: block; // display the table data as one block for mobile
            word-wrap: break-word;
            max-width: 7em;
            &:first-child { 
                display: table-cell; // display the first one as a table cell (radio button) for mobile
                text-align: center;
                border-right: $cell-border;
            }
            @media (min-width: $breakpoint) {
                border: $cell-border;
            }
            }
        
            th, td {
            text-align: left;
            margin: .5em 1em;  
            @media (min-width: $breakpoint) {
                display: table-cell; // show the table as a normal table for tablet and desktop
                padding: 1em;
            }
            }  
        }    
        }

        // Include the mixin (with extra options as overrides)

        @include responstable(
        $border-radius: $table-border-radius,
        $highlight-color: $table-highlight-color,
        $header-background-color: $table-header-background-color,
        $header-text-color: $table-header-text-color,
        $header-border: $table-header-border);

        // General styles

        body {
        padding: 0 2em;
        font-family: Arial, sans-serif;
        color: #024457;
        background: #f2f2f2;
        }

        h1 {
        font-family: Verdana;
        font-weight: normal;
        color: #024457;
        span {color: #167F92;}
        }    

</style>
@endsection
@section('content')
    <div id="app">
        <div class="search-container">
            <input type="text" placeholder="Pesquisar..." id="search-input">
            <button type="button" id="search-button">Buscar</button>
        </div>
        <table id="clientesTable" class="small-font responstable">
            <thead>
                <tr>
                    <th style="display:none">ID</th>
                    <th>ID Octa</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th style="display:none">Email</th>
                    <th>Empresa</th>
                    <th>Responsável</th>
                    <th style="display:none">Origem</th>
                    <th>Status</th>
                    <th>Criado em</th>
                    <th>Agendamento</th>
                    <th>Template</th>
                    <th>Bloqueado</th>
                    <th>Categoria</th>
                    <th>Termômetro</th>
                    <th>Card</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td class="cliente-id text-center" style="display:none">{{ $cliente->id }}</td>
                        <td class="text-center">{{ $cliente->id }}</td>
                        <td class="text-center" style="word-wrap: break-word;">
                            <a href="https://app.octadesk.com/chat/{{ $cliente->url_octa }}/opened" target="_blank">
                                {{ mb_substr($cliente->nome, 0, 25) . (mb_strlen($cliente->nome) > 25 ? '...' : '') }}
                            </a>
                        </td>
                        <td class="text-center">{{ $cliente->telefone }}</td>
                        <td class="text-center" style="display:none">{{ $cliente->email }}</td>
                        <td class="text-center">{{ $cliente->empresa }}</td>
                        <td class="text-center">
                            <select name="responsavel_contato" class="form-control responsavel-contato">
                                <option value="">Selecione um responsável</option>
                                @foreach ($vendedores as $vendedor)
                                    <option value="{{ $vendedor }}" @if ($cliente->responsavel_contato == $vendedor) selected @endif>
                                        {{ $vendedor }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-center" style="display:none">{{ $cliente->origem }}</td>
                        <td>
                            <select class="form-control" name="status_conversa">
                                <option value="">Selecione uma opção</option>
                                <option value="Lead" {{ $cliente->status_conversa == 'Lead' ? 'selected' : '' }}>Lead</option>
                                <option value="Venda Concluída" {{ $cliente->status_conversa == 'Venda Concluída' ? 'selected' : '' }}>Venda Concluída</option>
                                <option value="Enviado" {{ $cliente->status_conversa == 'Enviado' ? 'selected' : '' }}>Enviado</option>
                                <option value="Aberto" {{ $cliente->status_conversa == 'Aberto' ? 'selected' : '' }}>Aberto</option>
                            </select>
                        </td>
                        <td class="text-center">{{ $cliente->created_at }}</td>
                        <td class="text-center">
                            <div class='date datetimepicker'>
                                <input type="datetime-local" class="form-control" id="date" lang="pt-br"
                                    value="{{ $cliente->data_agendamento ? (new DateTime($cliente->data_agendamento))->format('Y-m-d\TH:i:s') : '' }}">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            <select name="mensagem_id" class="form-control mensagem_id" @if (!$cliente->data_agendamento)
                                disabled @endif>
                                <option value="">Selecione uma mensagem</option>
                                @php
                                    $mensagensOrdenadas = $mensagens->sortBy('titulo');
                                @endphp
                                @foreach ($mensagensOrdenadas as $mensagem)
                                    <option value="{{ $mensagem->id }}"
                                        @if ($cliente->mensagem_template_id == $mensagem->id) selected @endif>
                                        {{ $mensagem->titulo }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-center">
                            <label class="switch">
                                <input type="checkbox" class="table_checkbox" id="checkbox" value="{{ $cliente->contato_bloqueado }}" @if($cliente->contato_bloqueado == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-center">Prov.</td>
                        <td class="text-center">Prov.</td>
                        <td class="text-center">Prov.</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-primary ms-1" target="_blank">
                                <i class="fa-brands fa-trello"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $clientes->links() }}
    </div>
@endsection
@section('extraScript')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/pt-br.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            /* $('#clientesTable').DataTable({
                info: false, // Desabilita a exibição de informações sobre
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
                },
                "paging": true, // Ativar a paginação
                "lengthMenu": [10, 25, 50, 100], // Opções de quantidade de registros por página
                "pageLength": 10, // 
            });
            */
            $('.datetimepicker').on('change', function() {
                var id = $(this).closest('tr').find('.cliente-id').text();
                var newDateTime = $(this).closest('tr').find('#date').val();
                console.log(newDateTime);

                // Habilitar ou desabilitar o campo template_message com base no valor do campo data_agendamento
                var templateMessageField = $(this).closest('tr').find('.mensagem_id');
                if (newDateTime) {
                    templateMessageField.prop('disabled', false);
                } else {
                    templateMessageField.prop('disabled', true);
                }

                // Enviar requisição AJAX para atualizar a tabela com os novos dados
                $.ajax({
                    url: '/crm/atualizar-data/' + id,
                    method: 'PUT',
                    data: {
                        id: id,
                        newDateTime: newDateTime,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
            
            $('.mensagem_id').on('change', function() {
                var mensagemId = $(this).val();
                var clienteId = $(this).closest('tr').find('.cliente-id').text();

                // Enviar solicitação AJAX para atualizar o registro no banco de dados
                $.ajax({
                    url: '/crm/atualizar-mensagem',
                    method: 'POST',
                    data: {
                        clienteId: clienteId,
                        mensagemId: mensagemId,
                        "_token": "{{ csrf_token() }}"

                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            $('.responsavel-contato').on('change', function() {
                var clienteId = $(this).closest('tr').find('.cliente-id').text();
                var novoVendedor = $(this).val();

                // Enviar requisição ao servidor para atualizar o vendedor
                fetch(`/crm/atualizar-vendedor/${clienteId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ responsavel_contato: novoVendedor }),
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Vendedor atualizado com sucesso!');
                    } else {
                        console.error('Falha ao atualizar o vendedor.');
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                });
            });

            $('.table_checkbox').on('change', function() {
                var clienteId = $(this).closest('tr').find('.cliente-id').text();
                var valor = $(this).prop('checked') ? 1 : 0; // Obtém o valor corretamente
                // Enviar solicitação AJAX para atualizar o registro no banco de dados
                $.ajax({
                    url: `/crm/atualizar-bloqueado/${clienteId}`,
                    method: 'PUT',
                    data: { 
                        clienteId: clienteId,
                        bloqueado: valor,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
        
    </script>
    <script>
        $('#search-button').on('click', function() {
            var searchQuery = $('#search-input').val();
            // Enviar solicitação AJAX para buscar os registros
            $.ajax({
                url: '/crm/buscar-registros',
                method: 'GET',
                data: {
                    search: searchQuery
                },
                success: function(response) {
                    // Atualizar a tabela com os registros encontrados
                    $('#clientesTable tbody').html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
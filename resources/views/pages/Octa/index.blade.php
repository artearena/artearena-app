@extends('layout.main')
@section('title')
    Listagem de Clientes
@endsection
@section('style')
    <style>
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
            background-color: #212529;
            color: white;
            text-align: center !important;
        }

        td {
            font-size: 0.9em;
            padding: 4px;
        }

        tr {
            margin: 2px;
        }

        tfoot td {
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tbody tr:hover {
            background-color: #ebebeb;
        }

    </style>
@endsection
@section('content')
    <div id="app">
        <table id="clientesTable">
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
                    <th>Status da Conversa</th>
                    <th>Criado em</th>
                    <th>Agendamento</th>
                    <th>Template</th>
                    <th>Card</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td class="cliente-id" style="display:none">{{ $cliente->id }}</td>
                        <td>{{ $cliente->id_octa }}</td>
                        <td style="word-wrap: break-word;">
                            <a href="https://app.octadesk.com/chat/{{ $cliente->url_octa }}/opened" target="_blank">
                                <?php echo chunk_split($cliente->nome, 25, "<br>"); ?>
                            </a>
                        </td>
                        <td>{{ $cliente->telefone }}</td>
                        <td style="display:none">{{ $cliente->email }}</td>
                        <td>{{ $cliente->empresa }}</td>
                        <td>
                            <select name="responsavel_contato">
                                <option value="">Selecione um responsável</option>
                                @foreach ($vendedores as $vendedor)
                                    <option value="{{ $vendedor }}" @if ($cliente->responsavel_contato == $vendedor) selected @endif>
                                        {{ $vendedor }}
                                    </option>
                                @endforeach
                            </select>
                        </td>                        
                        <td style="display:none">{{ $cliente->origem }}</td>
                        <td>{{ $cliente->status_conversa }}</td>
                        <td>{{ $cliente->created_at }}</td>
                        <td>
                            <div class='date datetimepicker'>
                                <input type="datetime-local" class="form-control" id="date" lang="pt-br" value="{{ $cliente->data_agendamento ? (new DateTime($cliente->data_agendamento))->format('Y-m-d\TH:i:s') : '' }}">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <select name="mensagem_id" class="mensagem_id">
                                <option value="">Selecione uma mensagem</option>
                                @php
                                    $mensagensOrdenadas = $mensagens->sortBy('titulo');
                                @endphp
                                @foreach ($mensagensOrdenadas as $mensagem)
                                    <option value="{{ $mensagem->id }}" @if ($cliente->mensagem_template_id == $mensagem->id) selected @endif>
                                        {{ $mensagem->titulo }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary ms-1" target="_blank">
                                <i class="fa-brands fa-trello"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
            $('#clientesTable').DataTable({
                searching: false, // Desabilita a funcionalidade de pesquisa
                info: false, // Desabilita a exibição de informações sobre
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
                }
            });

            $('.datetimepicker').on('change', function() {

                var id = $(this).closest('tr').find('.cliente-id').text();
                var newDateTime = $(this).closest('tr').find('#date').val();

                console.log(newDateTime);
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
        });
    </script>
@endsection
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
            color: gray;
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
                        <td>{{ $cliente->responsavel_contato }}</td>
                        <td style="display:none">{{ $cliente->origem }}</td>
                        <td>{{ $cliente->status_conversa }}</td>
                        <td>{{ $cliente->created_at }}</td>
                        <td>
                        <div class="tui-datepicker-input tui-datetime-input tui-has-focus">
                            <input type="text" id="tui-date-picker-target" aria-label="Date-Time" />
                            <span class="tui-ico-date"></span>
                        </div>
                        <div id="tui-date-picker-container" style="margin-top: -1px;"></div>
                        </td>
                        <td>
                            <select name="mensagem_id" class="mensagem_id">
                                <option value="">Selecione uma mensagem</option>
                                @foreach ($mensagens as $mensagem)
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
        <link href="tui-time-picker.css" rel="stylesheet">
        <link href="tui-date-picker.css" rel="stylesheet">        
        <script type="text/javascript" src="tui-time-picker.js"></script>
        <script type="text/javascript" src="tui-date-picker.js"></script>
        <script>
        $(document).ready(function() {
            $('#clientesTable').DataTable({
                searching: false, // Desabilita a funcionalidade de pesquisa
                info: false, // Desabilita a exibição de informações sobre
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
                }
            });

            $('.tui-datetime-input').datetimepicker({
                format: 'DD/MM/YYYY HH:mm',
                language: 'pt-br'
            });
            $('.datetimepicker').on('dp.change', function(e) {
                var id = $(this).data('id');
                var newDateTime = e.date.format('YYYY-MM-DD HH:mm:ss');

                
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
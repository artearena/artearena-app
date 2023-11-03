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
        .small-font {
            font-size: 0.8em;
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

        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

    </style>
@endsection
@section('content')
    <div id="app">
    <table id="clientesTable" class="small-font">
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
            <th>Qualificado</th>
            <th>Motivo da perda</th>
            <th>Categoria</th>
            <th>Termometro</th>
            <th>Card</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $index => $cliente)
            @if ($index < 10)
                <tr>
                    <td class="cliente-id text-center" style="display:none">{{ $cliente->id }}</td>
                    <td class="text-center">{{ $cliente->id }}</td>
                    <td class="text-center" style="word-wrap: break-word;">
                        <a href="https://app.octadesk.com/chat/{{ $cliente->url_octa }}/opened" target="_blank">
                            <?php echo chunk_split($cliente->nome, 25, "<br>"); ?>
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
                    <td class="text-center">Prov.</td>
                    <td class="text-center">
                        <a href="#" class="btn btn-primary ms-1" target="_blank">
                            <i class="fa-brands fa-trello"></i>
                        </a>
                    </td>
                </tr>
            @else
                @break
            @endif
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
            // Inicialização do DataTables
            let table = $('#clientesTable').DataTable({
                columns: [
                    { data: 'ID', visible: false },
                    { data: 'ID Octa' },
                    { data: 'Nome' },
                    { data: 'Telefone' },
                    { data: 'Email', visible: false },
                    { data: 'Empresa' },
                    { data: 'Responsável' },
                    { data: 'Origem', visible: false },
                    { data: 'Status' },
                    { data: 'Criado em' },
                    { data: 'Agendamento' },
                    { data: 'Template' },
                    { data: 'Bloqueado' },
                    { data: 'Qualificado' },
                    { data: 'Motivo da perda' },
                    { data: 'Categoria' },
                    { data: 'Termometro' },
                    { data: 'Card' }
                ],
                columnDefs: [
                    {
                        targets: 2, // Coluna "Nome"
                        render: function (data, type, row, meta) {
                            return '<a href="https://app.octadesk.com/chat/' + row['ID Octa'] + '/opened" target="_blank">' + data + '</a>';
                        }
                    },
                    {
                        targets: 6, // Coluna "Responsável"
                        render: function (data, type, row, meta) {
                            var selectOptions = '<select name="responsavel_contato" class="form-control responsavel-contato">' +
                                '<option value="">Selecione um responsável</option>';
                            $.each(vendedores, function (index, vendedor) {
                                selectOptions += '<option value="' + vendedor + '"';
                                if (data == vendedor) {
                                    selectOptions += ' selected';
                                }
                                selectOptions += '>' + vendedor + '</option>';
                            });
                            selectOptions += '</select>';
                            return selectOptions;
                        }
                    },
                    {
                        targets: 8, // Coluna "Status"
                        render: function (data, type, row, meta) {
                            var selectOptions = '<select class="form-control" name="status_conversa">' +
                                '<option value="">Selecione uma opção</option>' +
                                '<option value="Lead"' + (data == 'Lead' ? ' selected' : '') + '>Lead</option>' +
                                '<option value="Venda Concluída"' + (data == 'Venda Concluída' ? ' selected' : '') + '>Venda Concluída</option>' +
                                '<option value="Enviado"' + (data == 'Enviado' ? ' selected' : '') + '>Enviado</option>' +
                                '<option value="Aberto"' + (data == 'Aberto' ? ' selected' : '') + '>Aberto</option>' +
                                '</select>';
                            return selectOptions;
                        }
                    },
                    {
                        targets: 10, // Coluna "Agendamento"
                        render: function (data, type, row, meta) {
                            var datetimePicker = '<div class="date datetimepicker">' +
                                '<input type="datetime-local" class="form-control" id="date" lang="pt-br" value="' + (data ? moment(data).format('YYYY-MM-DD[T]HH:mm:ss') : '') + '">' +
                                '<span class="input-group-addon">' +
                                '<span class="glyphicon glyphicon-calendar"></span>' +
                                '</span>' +
                                '</div>';
                            return datetimePicker;
                        }
                    },
                    {
                        targets: 11, // Coluna "Template"
                        render: function (data, type, row, meta) {
                            var selectOptions = '<select name="mensagem_id" class="form-control mensagem_id" ' + (row['Agendamento'] ? '' : 'disabled') + '>' +
                                '<option value="">Selecione uma mensagem</option>';
                            var mensagensOrdenadas = mensagens.sortBy('titulo');
                            $.each(mensagensOrdenadas, function (index, mensagem) {
                                selectOptions += '<option value="' + mensagem.id + '"';
                                if (data == mensagem.id) {
                                    selectOptions += ' selected';
                                }
                                selectOptions += '>' + mensagem.titulo + '</option>';
                            });
                            selectOptions += '</select>';
                            return selectOptions;
                        }
                    },
                    {
                        targets: 12, // Coluna "Bloqueado"
                        render: function (data, type, row, meta) {
                            var checkbox = '<label class="switch">' +
                                '<input type="checkbox" class="table_checkbox" id="checkbox" value="' + data + '"';
                            if (data == 1) {
                                checkbox += ' checked';
                            }
                            checkbox += '>' +
                                '<span class="slider round"></span>' +
                                '</label>';
                            return checkbox;
                        }
                    }
                ],
            });

            // Adicionar evento para mostrar/ocultar detalhes da linha
            $('#clientesTable tbody').on('click', 'td', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // Ocultar detalhes da linha
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Mostrar detalhes da linha
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
            // Adicionar evento para expandir/contrair a linha
            $('#clientesTable tbody').on('click', 'td', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // Contrair a linha
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Expandir a linha
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

            // Função para formatar os detalhes da linha
            function format(data) {
                return '<dl>' +
                    '<dt>Full name:</dt>' +
                    '<dd>' + data.Nome + '</dd>' +
                    '<dt>Extension number:</dt>' +
                    '<dd>' + data.Telefone + '</dd>' +
                    '<dt>Extra info:</dt>' +
                    '<dd>And any further details here (images etc)...</dd>' +
                    '</dl>';
            }
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
@endsection
@extends('layout.main') 
@section('title') 
    Listagem de Clientes 
@endsection 
@section('style') 
    <style> 
        table { 
            width: 100%; 
            border-collapse: collapse; 
        } 
        th, td { 
            padding: 8px; 
            border-bottom: 1px solid #ddd; 
            text-align: center; 
        } 
        th { 
            background-color: #f2f2f2; 
            font-weight: bold; 
            text-align: center !important; 
        } 
        td { 
            font-size: .9em; 
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
        <table> 
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
                            @foreach ($cliente->agendamentos as $agendamento)
                                <div class='input-group date datetimepicker'>
                                    @php
                                        $formattedDateTime = \Carbon\Carbon::parse($agendamento->horario)->format('d/m/Y H:i');
                                    @endphp
                                    <input type='text' class="form-control" value="{{ $formattedDateTime }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            @endforeach
                        </td>
                        <td></td>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/pt-br.js"></script>
@endsection 
@section('extraScript')
<script>
    $(function() {
        $('.datetimepicker').datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            locale: 'pt-br',
            autoclose: true
        });
    });
    $('.datetimepicker').on('dp.change', function(e) {
            var id = $(this).data('id');
            var newDateTime = e.date.format('YYYY-MM-DD HH:mm:ss');

            // Enviar requisição AJAX para atualizar a tabela com os novos dados
            $.ajax({
                url: '/atualizar-data',
                method: 'POST',
                data: {
                    id: id,
                    newDateTime: newDateTime
                },
                success: function(response) {
                    // Atualizar a tabela com os dados atualizados
                    // Exemplo: location.reload();
                },
                error: function(xhr, status, error) {
                    // Tratar erros
                }
            });
        });
</script>
@endsection 
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
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        } 
        th { 
            background-color: #f2f2f2; 
            font-weight: bold; 
            text-align: center; 
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
    <!-- Carregar CSS e JS do datetimepicker --> 
    <!-- Remover referências ao datepicker --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/> 
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
                    <th>Email</th> 
                    <th>Empresa</th> 
                    <th>Responsável</th> 
                    <th style="display:none">Origem</th> 
                    <th>Status da Conversa</th> 
                    <th>Criado em</th> 
                    <th>Data de Agendamento</th> 
                    <th style="display:none">Atualizado em</th> 
                    <th>Trello</th> 
                </tr> 
            </thead> 
            <tbody> 
                @foreach ($clientes as $cliente) 
                    <tr> 
                        <td class="cliente-id" style="display:none">{{ $cliente->id }}</td> 
                        <td>{{ $cliente->id_octa }}</td> 
                        <td> 
                            <a href="https://app.octadesk.com/chat/{{ $cliente->url_octa }}/opened" target="_blank"> 
                                {{ $cliente->nome }} 
                            </a> 
                        </td> 
                        <td>{{ $cliente->telefone }}</td> 
                        <td>{{ $cliente->email }}</td> 
                        <td>{{ $cliente->empresa }}</td> 
                        <td>{{ $cliente->responsavel_contato }}</td> 
                        <td style="display:none">{{ $cliente->origem }}</td> 
                        <td>{{ $cliente->status_conversa }}</td> 
                        <td>{{ $cliente->created_at }}</td> 
                        <td> 
                            <input class="form-control datepicker" id="dataAgendamento">                         
                        </td> 
                        <td style="display:none">{{ $cliente->updated_at }}</td> 
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
    <button id="btnAgendar">Agendar Teste</button>
@endsection 
@section('extraScript') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js">>  
<script  src="https://code.jquery.com/jquery-3.6.0.min.js">> 
<script  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js">> 
<script  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">> 
<script  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js">> 
<script  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">> 
<script> 
    $('.datepicker').datetimepicker({ 
        format: 'dd/mm/yyyy HH:mm:ss', 
        language: 'pt-BR', 
        autoclose: true, 
    }); 
    $('.datepicker').on('changeDate', function() { 
        var clienteId = $(this).closest('tr').find('.cliente-id').text(); 
        var novaData = moment($(this).val(), 'DD/MM/YYYY HH:mm:ss').format('YYYY-MM-DD HH:mm:ss'); 
        $.ajax({ 
            url: 'crm/atualizar-data/'+clienteId, 
            type: 'POST', 
            data: { 
                data_agendamento: novaData, 
                "_token": "{{ csrf_token() }}" 
            }, 
            success: function(response) { 
                alert('Data atualizada com sucesso!'); 
            } 
        }); 
    }); 
</script>
<script>
    function agendarConversa() {

    const url = 'https://artearena.api004.octadesk.services/chat/conversation/send-template';

    const data = {
        target: {
            contact: {
            phoneContact: {
                number: '+5511987430004'
            }
            }
        },
        content: {
            templateMessage: {
            id: '64d2e17f6f8d1b0007de15f3' 
            }
        },
        origin: {
            from: {
            number: '+5511964965907'
            }
        },
        options: {
            automaticAssign: true
        }        
    };

    const headers = {
        'X-API-KEY': '3b8f740e-6dd3-4da3-a59e-30ee20169c49.31b74e42-c05f-4341-b386-320b5231125d',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    fetch(url, {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(data) 
    })
    .then(response => {
    if(!response.ok) {
        throw new Error('Erro na requisição'); 
    }
    return response.json();
    })
    .then(data => {
        console.log(data); 
    })
    .catch(error => {
        console.error(error);
    });
    }
    document.getElementById("btnAgendar").addEventListener("click", agendarConversa);
</script> 
@endsection 
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
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<!-- Datetimepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
                            @foreach ($cliente->agendamentos as $agendamento)
                                <input type="text" class="form-control datetimepicker" value="{{ $agendamento->horario }}">
                            @endforeach
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
<script>
    $(document).ready(function() {
        $('.datetimepicker').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        });
    });
</script> 
@endsection 
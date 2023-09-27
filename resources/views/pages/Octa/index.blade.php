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
        }
        td {
            font-size: .9em;
        }
        tfoot td {
            font-weight: bold;
        }
        tbody tr:hover {
            background-color: #f5f5f5;
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
                <th>Email</th>
                <th>Origem</th>
                <th>Criado em</th>
                <th style="display:none">Atualizado em</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td style="display:none">{{ $cliente->id }}</td>
                    <td>{{ $cliente->id_octa }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->telefone }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->origem }}</td>
                    <td>{{ $cliente->created_at }}</td>
                    <td style="display:none">{{ $cliente->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
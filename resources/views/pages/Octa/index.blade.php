@extends('layout.main')

@section('title')
    Listagem de Clientes
@endsection

@section('content')
    <div id="app">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Origem</th>
                    <th>ID Octa</th>
                    <th>Criado em</th>
                    <th>Atualizado em</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ $cliente->telefone }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->origem }}</td>
                        <td>{{ $cliente->id_octa }}</td>
                        <td>{{ $cliente->created_at }}</td>
                        <td>{{ $cliente->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
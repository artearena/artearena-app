@extends('layout.main')

@section('title')
    Logs
@endsection

@section('content')
    <form method="GET" action="{{ route('logs.index') }}">
        <input type="text" name="search" placeholder="Search logs" value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Atualizado por</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id_pedido }}</td>
                    <td>{{ $log->descricao }}</td>
                    <td>{{ $log->tipo }}</td>
                    <td>{{ $log->data }}</td>
                    <td>{{ $log->usuario ? $log->usuario->name : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $logs->links() }}
@endsection
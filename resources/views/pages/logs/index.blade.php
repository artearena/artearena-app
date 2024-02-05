@extends('layout.main')

@section('title')
    Logs
@endsection

@section('content')
    <form method="GET" action="{{ route('logs.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search logs" value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
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
                        <td>{{ $log->usuario ? $log->usuario->nome_usuario : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $logs->links("pagination::bootstrap-4") }}
@endsection

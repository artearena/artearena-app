@extends('layout.main')
@section('title')
    Tabela de pedidos
@endsection
@section('style')

endsection
@section('content')
<div class="row">
        <div class="col-md-6">
            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="produtos">Produtos:</label>
                    <input type="text" class="form-control" id="produtos" name="produtos">
                </div>
                <div class="form-group">
                    <label for="confecção">Confecção:</label>
                    <input type="text" class="form-control" id="confecção" name="confecção">
                </div>
                <div class="form-group">
                    <label for="fase">Fase:</label>
                    <input type="text" class="form-control" id="fase" name="fase">
                </div>
                <div class="form-group">
                    <label for="tempo_por_peca">Tempo por peça:</label>
                    <input type="text" class="form-control" id="tempo_por_peca" name="tempo_por_peca">
                </div>
                <div class="form-group">
                    <label for="pronto">Pronto:</label>
                    <input type="text" class="form-control" id="pronto" name="pronto">
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar Pedido</button>
            </form>
        </div>
        <div class="col-md-6">
            <table id="tabela-pedidos" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produtos</th>
                        <th>Confecção</th>
                        <th>Fase</th>
                        <th>Tempo por peça</th>
                        <th>Pronto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->produtos }}</td>
                            <td>{{ $pedido->confecção }}</td>
                            <td>{{ $pedido->fase }}</td>
                            <td>{{ $pedido->tempo_por_peca }}</td>
                            <td>{{ $pedido->pronto }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('extraScript')
    <script>
    </script>
@endsection
@extends('layout.main')
@section('title')
    Tabela de pedidos
@endsection
@section('style')

endsection
@section('content')
    <div class="row">
            <div class="col-md-6">
                <form action="{{ route('erros.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="departamento">Departamento:</label>
                        <input type="text" class="form-control" id="departamento" name="departamento">
                    </div>
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="date" class="form-control" id="data" name="data">
                    </div>
                    <div class="form-group">
                        <label for="responsavel">Responsável:</label>
                        <input type="text" class="form-control" id="responsavel" name="responsavel">
                    </div>
                    <div class="form-group">
                        <label for="pedido">Nº Pedido:</label>
                        <input type="text" class="form-control" id="pedido" name="pedido">
                    </div>
                    <div class="form-group">
                        <label for="tipo_produto">Tipo de Produto:</label>
                        <input type="text" class="form-control" id="tipo_produto" name="tipo_produto">
                    </div>
                    <div class="form-group">
                        <label for="tipo_erro">Tipo de Erro:</label>
                        <input type="text" class="form-control" id="tipo_erro" name="tipo_erro">
                    </div>
                    <div class="form-group">
                        <label for="erro">Erro:</label>
                        <textarea class="form-control" id="erro" name="erro"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="consequencia_erro">Consequência do Erro:</label>
                        <textarea class="form-control" id="consequencia_erro" name="consequencia_erro"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="custo">Custo:</label>
                        <input type="text" class="form-control" id="custo" name="custo">
                    </div>
                    <div class="form-group">
                        <label for="descontado">Descontado:</label>
                        <input type="text" class="form-control" id="descontado" name="descontado">
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar Erro</button>
                </form>
            </div>
        </div>
        <hr>
        <table id="tabela-erros" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Departamento</th>
                    <th>Data</th>
                    <th>Responsável</th>
                    <th>Nº Pedido</th>
                    <th>Tipo de Produto</th>
                    <th>Tipo de Erro</th>
                    <th>Erro</th>
                    <th>Consequência do Erro</th>
                    <th>Custo</th>
                    <th>Descontado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($erros as $erro)
                    <tr>
                        <td>{{ $erro->id }}</td>
                        <td>{{ $erro->departamento }}</td>
                        <td>{{ $erro->data }}</td>
                        <td>{{ $erro->responsavel }}</td>
                        <td>{{ $erro->pedido }}</td>
                        <td>{{ $erro->tipo_produto }}</td>
                        <td>{{ $erro->tipo_erro }}</td>
                        <td>{{ $erro->erro }}</td>
                        <td>{{ $erro->consequencia_erro }}</td>
                        <td>{{ $erro->custo }}</td>
                        <td>{{ $erro->descontado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table><div class="row">
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
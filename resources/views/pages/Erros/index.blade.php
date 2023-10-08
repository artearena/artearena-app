@extends('layout.main')
@section('title')
    Tabela de erros
@endsection
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
    </table>
@endsection

@section('extraScript')
    <script>
        $(document).ready(function() {
            $('#tabela-erros').DataTable({
                ajax: {
                    url: '/api/erros', // Substitua pela rota correta para buscar os dados dos erros
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    { data: 'departamento' },
                    { data: 'data' },
                    { data: 'responsavel' },
                    { data: 'pedido' },
                    { data: 'tipo_produto' },
                    { data: 'tipo_erro' },
                    { data: 'erro' },
                    { data: 'consequencia_erro' },
                    { data: 'custo' },
                    { data: 'descontado' }
                ]
            });
        });
    </script>
@endsection
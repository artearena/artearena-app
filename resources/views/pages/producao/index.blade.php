@extends('layout.main')
@section('title')
    Tabela de pedidos
@endsection
@section('style')

@endsection
@section('content')
<div class="row">
        <div class="col-md-6">
            <form action="{{ route('producao.criar') }}" method="POST">
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
                <table id="tabela-produtos" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pedido ID</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Categoria</th>
                            <th>Arte Aprovada</th>
                            <th>Lista Aprovada</th>
                            <th>Pacote</th>
                            <th>Camisa</th>
                            <th>Calção</th>
                            <th>Meião</th>
                            <th>Nome Jogador</th>
                            <th>Número</th>
                            <th>Tamanho</th>
                            <th>ID Lista</th>
                            <th>Gola</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <!-- Adicione mais colunas conforme necessário -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidoProdutos as $produto)
                            <tr>
                                <td>{{ $produto->id }}</td>
                                <td>{{ $produto->pedido_id }}</td>
                                <td>{{ $produto->produto_nome }}</td>
                                <td>{{ $produto->quantidade }}</td>
                                <td>{{ $produto->preco_unitario }}</td>
                                <td>{{ $produto->categoria }}</td>
                                <td>{{ $produto->arte_aprovada }}</td>
                                <td>{{ $produto->lista_aprovada }}</td>
                                <td>{{ $produto->pacote }}</td>
                                <td>{{ $produto->camisa }}</td>
                                <td>{{ $produto->calcao }}</td>
                                <td>{{ $produto->meiao }}</td>
                                <td>{{ $produto->nome_jogador }}</td>
                                <td>{{ $produto->numero }}</td>
                                <td>{{ $produto->tamanho }}</td>
                                <td>{{ $produto->id_lista }}</td>
                                <td>{{ $produto->gola }}</td>
                                <td>{{ $produto->created_at }}</td>
                                <td>{{ $produto->updated_at }}</td>
                                <!-- Adicione mais colunas conforme necessário -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
@endsection

@section('extraScript')
    <script>
    </script>
@endsection
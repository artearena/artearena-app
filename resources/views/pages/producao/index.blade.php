@extends('layout.main')

@section('title')
    Tabela de pedidos
@endsection

@section('style')
    <!-- Adicione estilos aqui, se necessário -->
@endsection

@section('content')

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
                @forelse ($produtos_confeccao as $produto)
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
                @empty

                    <tr>
                        <td colspan="20">Nenhum produto disponível - produtos_confeccao: {{ count($produtos_confeccao) }}, pedidos: {{ count($pedidos) }}, produtos_info: {{ count($produtos_info) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
@endsection

@section('extraScript')
    <script>
    </script>
@endsection
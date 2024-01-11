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
                    <th>Produto</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produtos_confeccao as $produto)
                    <tr>
                        <td>{{ $produto->produto_nome }}</td>
                        <td>{{ $produto->quantidade }}</td>
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
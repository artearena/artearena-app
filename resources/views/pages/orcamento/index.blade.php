@extends('layout.main')
@section('title', 'Tabela de Orçamentos')
@section('style')
    <!-- Adicione seus estilos específicos aqui, se necessário -->
    <style>
        .dataTable {
            /* Adicione estilos específicos para a tabela, se necessário */
        }

        .dataTable th, .dataTable td {
            /* Adicione estilos específicos para as células da tabela, se necessário */
        }

        /* Adicione mais estilos conforme necessário */
    </style>
@endsection

@section('content')
<div class="app container-with-margin">
    <h1>Tabela de Orçamentos</h1>
    
    <!-- Link para a página de criação de novo orçamento -->
    <a href="{{ route('orcamentos.create') }}" class="btn btn-primary">Novo Orçamento</a>

    <!-- Tabela de Orçamentos -->
    <table id="tabelaOrcamentos" class="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Octa</th>
                <th>Detalhes do Orçamento</th>
                <th>Nome da Transportadora</th>
                <th>Valor do Frete</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orcamentos as $orcamento)
            <tr>
                <td>{{ $orcamento->id }}</td>
                <td>{{ $orcamento->id_octa }}</td>
                <td>{{ $orcamento->detalhes_orcamento }}</td>
                <td>{{ $orcamento->nome_transportadora }}</td>
                <td>{{ $orcamento->valor_frete }}</td>
                <td>
                    <!-- Link para visualizar detalhes do orçamento -->
                    <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-info">Detalhes</a>

                    <!-- Link para editar o orçamento -->
                    <a href="{{ route('orcamentos.edit', $orcamento->id) }}" class="btn btn-warning">Editar</a>

                    <!-- Botão para excluir o orçamento -->
                    <button class="btn btn-danger" onclick="deleteOrcamento({{ $orcamento->id }})">Excluir</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Nenhum orçamento encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Adicione seus modais ou scripts específicos aqui, se necessário -->
@endsection

@section('extraScript')
<script>
    function deleteOrcamento(id) {
        Swal.fire({
            title: 'Você tem certeza?',
            text: 'Esta ação não pode ser desfeita!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/orcamentos/destroy/" + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: response.message,
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        // Adicione código para atualizar a tabela ou UI conforme necessário
                    },
                    error: function(error) {
                        console.error(error);
                        // Trate a resposta de erro conforme necessário
                    }
                });
            }
        });
    }
</script>
@endsection

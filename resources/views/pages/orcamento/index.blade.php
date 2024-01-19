@extends('layout.main')
@section('title', 'Tabela de Orçamentos')
@section('style')
    <!-- Adicione seus estilos específicos aqui, se necessário -->
    <style>
        /* Adicione estilos específicos para a tabela, se necessário */
        .table-container {
            margin-top: 20px;
        }

        #tabelaOrcamentos {
            width: 100%;
            border-collapse: collapse;
        }

        #tabelaOrcamentos th, #tabelaOrcamentos td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #tabelaOrcamentos th {
            background-color: #f2f2f2;
        }

        /* Adicione mais estilos conforme necessário */
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="app container-with-margin">
    <h1>Tabela de Orçamentos</h1>
    
    <!-- Link para a página de criação de novo orçamento -->
    <a href="{{ route('orcamentos.create') }}" class="btn btn-primary">Novo Orçamento</a>

    <div class="float-right mb-3">
        <!-- Campo de pesquisa -->
        <div class="input-group">
            <input type="text" id="search" class="form-control" placeholder="Pesquisar...">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" onclick="pesquisar()">Pesquisar</button>
            </div>
        </div>
    </div>

    <!-- Tabela de Orçamentos -->
    <div class="table-container">
        <table id="tabelaOrcamentos">
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
</div>

<!-- Adicione seus modais ou scripts específicos aqui, se necessário -->
@endsection

@section('extraScript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        var tabelaOrcamentos = $('#tabelaOrcamentos').DataTable({
            searching: false, // Desativar a funcionalidade de busca inicialmente
            paging: true, // Ativar a paginação
        });

        // Adicionar evento de input para a pesquisa
        $('#search').on('keyup', function () {
            tabelaOrcamentos.search(this.value).draw();
        });
    });

    function pesquisar() {
        // Ativar a funcionalidade de busca ao clicar no botão Pesquisar
        var tabelaOrcamentos = $('#tabelaOrcamentos').DataTable();
        tabelaOrcamentos.search($('#search').val()).draw();
    }

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

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

@endsection

@section('content')
<div class="app container-lg">
    <h1>Tabela de Orçamentos</h1>
    
    <!-- Link para a página de criação de novo orçamento -->
    <a href="{{ route('orcamentos.create') }}" class="btn btn-primary">Novo Orçamento</a>

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
                    <th>Criado por</th>
                    <th>Data de Criação</th>
                    <th>Qtd. por cliente</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orcamentos as $orcamento)
                <tr>
                    <td>{{ $orcamento->id }}</td>
                    <td>{{ $orcamento->id_octa }}</td>
                    <td style="max-width: 500px; overflow: hidden; text-overflow: ellipsis;">{{ $orcamento->detalhes_orcamento }}</td>
                    <td>{{ $orcamento->nome_transportadora }}</td>
                    <td>{{ $orcamento->valor_frete }}</td>
                    <td>
                        @if($orcamento->usuario)
                            {{ $orcamento->usuario->nome_usuario }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $orcamento->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $orcamento->quantidade_repeticoes }}</td>
                    <td>
                        <!-- Link para visualizar detalhes do orçamento -->
                        <a href="#" class="btn btn-info">Detalhes</a>

                        <!-- Link para editar o orçamento -->
                        <a href="#" class="btn btn-warning">Editar</a>

                        <!-- Botão para excluir o orçamento -->
                        <button class="btn btn-danger">Excluir</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">Nenhum orçamento encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Adicione seus modais ou scripts específicos aqui, se necessário -->
@endsection
@section('extraScript')
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        var tabelaOrcamentos = $('#tabelaOrcamentos').DataTable({
            paging: true, // Ativar a paginação
            searching: true, // Desativar a funcionalidade de busca inicialmente
            bInfo: false, // Remover informações de quantidade de registros
            dom: 'lBfrtip', // Definir layout personalizado
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
            order: [[5, 'desc']],
            buttons: [
                'excel', 'pdf', 'print' // Adicionar botões para exportar
            ]
        });

        // Adicionar campo de pesquisa
        $('#tabelaOrcamentos thead th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Pesquisar ' + title + '" />');
        });

        // Aplicar a pesquisa no DataTable
        tabelaOrcamentos.columns().every(function() {
            var that = this;

            $('input', this.header()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
    });

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

@section('style')
<style>
    /* Estilos específicos para a tabela, se necessário */
    .table-container {
        margin-top: 20px;
    }

    #tabelaOrcamentos {
        width: 100%;
        border-collapse: collapse;
    }

    #tabelaOrcamentos th,
    #tabelaOrcamentos td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #tabelaOrcamentos th {
        background-color: #f2f2f2;
    }

    /* Estilos para os botões de exportação */
    .dt-buttons {
        margin-bottom: 10px;
    }

    .dt-button {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
        border-radius: 5px;
        margin-right: 10px;
    }

    /* Estilos para os inputs de pesquisa */
    input[type="text"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 12px;
    }
</style>
@endsection

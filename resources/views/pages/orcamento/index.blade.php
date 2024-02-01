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

        /* Estilos para os botões de paginação */
        .pagination {
            margin-top: 10px;
        }

        /* Estilos para o campo de pesquisa */
        #searchInput {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 12px;
        }

        /* Estilos para expandir observações */
        .expandir-observacoes {
            max-width: 250px; /* Defina a largura máxima que deseja */
            white-space: nowrap; /* Evita que o texto quebre em várias linhas */
            overflow: auto; /* Adiciona uma barra de rolagem horizontal quando necessário */
            text-overflow: ellipsis; /* Adiciona reticências (...) quando o texto estiver além da largura máxima */
        }
    </style>
@endsection

@section('content')
<div class="app container-lg">
    <h1>Tabela de Orçamentos</h1>
    
    <!-- Link para a página de criação de novo orçamento -->
    <a href="{{ route('orcamento') }}" class="btn btn-primary">Novo Orçamento</a>
    
    <!-- Campo de pesquisa -->
    <input type="text" id="searchInput" placeholder="Pesquisar...">

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
                    <td class="expandir-observacoes" title="{{ $orcamento->detalhes_orcamento }}">{{ $orcamento->detalhes_orcamento }}</td>
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

    <!-- Adicione a paginação aqui -->
    {{ $orcamentos->links() }}

</div>

<!-- Adicione seus modais ou scripts específicos aqui, se necessário -->
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        $('#tabelaOrcamentos tbody').on('mouseenter', 'td.expandir-observacoes', function() {
            var td = $(this);
            var fullText = td.text();
            td.attr('title', fullText);
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

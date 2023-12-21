    @extends('layout.main')

    @section('title')
    Calculadora de Bandeiras
    @endsection

    @section('content')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <div class="container">
            <h1>Administrar Permissões</h1>

            <div class="my-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarPermissao">Adicionar Permissão</button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Configuração de Permissão</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissoes as $permissao)
                        <tr>
                            <td>{{ $permissao->id }}</td>
                            <td>{{ $permissao->nome }}</td>
                            <td>{{ $permissao->configuracao_permissao }}</td>
                            <td>
                                <!-- Botão Editar -->
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarPermissao{{ $permissao->id }}">
                                    Editar
                                </button>

                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarExclusao{{ $permissao->id }}">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Adicionar Permissão -->
        <div class="modal fade" id="modalAdicionarPermissao" tabindex="-1" aria-labelledby="modalAdicionarPermissaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAdicionarPermissaoLabel">Adicionar Permissão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('permissoes.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="configuracao_permissao" class="form-label">Configuração de Permissão</label>
                                <select class="form-control select2" id="configuracao_permissao" name="configuracao_permissao[]" multiple style="width: 100%">
                                    @foreach ($telas as $tela)
                                        @if ($tela->tipo == 'Não acessível' || $tela->tipo == 'Desativado')
                                            @continue
                                        @endif
                                        <option value="{{ $tela->id }}">{{ $tela->nome_tela }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('.select2').select2({
                                        placeholder: 'Selecione as telas',
                                        allowClear: true,
                                        tags: true,
                                        dropdownParent: $('#modalAdicionarPermissao') // Especifica o seletor do modal como o contêiner
                                    });
                                });

                            </script>

                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Permissão -->
        <div class="modal fade" id="modalEditarPermissao{{ $permissao->id }}" tabindex="-1" aria-labelledby="modalEditarPermissaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarPermissaoLabel">Editar Permissão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('permissoes.update', $permissao->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ $permissao->nome }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="configuracao_permissao" class="form-label">Configuração de Permissão</label>

                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Exclusão -->
        <div class="modal fade" id="modalConfirmarExclusao{{ $permissao->id }}" tabindex="-1" aria-labelledby="modalConfirmarExclusaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmarExclusaoLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Você tem certeza que deseja excluir esta permissão?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('permissoes.destroy', $permissao->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection



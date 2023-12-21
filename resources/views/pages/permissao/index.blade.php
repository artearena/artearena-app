@extends('layout.main')

@section('title')
Calculadora de Bandeiras
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<div class="container">
    <h1>Administrar Permissões</h1>

    <div class="my-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarPermissao">Adicionar
            Permissão</button>
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
                    <button class="btn btn-primary btn-editar" data-bs-toggle="modal"
                        data-bs-target=".modal-editar-permissao[data-permissao-id='{{ $permissao->id }}']">
                        Editar
                    </button>

                    <button class="btn btn-danger btn-excluir" data-bs-toggle="modal"
                        data-bs-target="#modalConfirmarExclusao{{ $permissao->id }}">
                        Excluir
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalAdicionarPermissao" tabindex="-1" aria-labelledby="modalAdicionarPermissaoLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('permissoes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="configuracao_permissao" class="form-label">Configuração de Permissão</label>
                    <select class="form-control select2" id="configuracao_permissao" name="configuracao_permissao[]"
                        multiple style="width: 100%">
                        @foreach ($telas as $tela)
                        @if ($tela->tipo == 'Não acessível' || $tela->tipo == 'Desativado')
                        @continue
                        @endif
                        <option value="{{ $tela->id }}">{{ $tela->nome_tela }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
</div>

@foreach ($permissoes as $permissao)
<div class="modal fade modal-editar-permissao" data-permissao-id="{{ $permissao->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('permissoes.update', $permissao->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ $permissao->nome }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="configuracao_permissao{{ $permissao->id }}" class="form-label">Configuração de
                        Permissão</label>
                    @php
                    $configuracao_permissao = explode(',', $permissao->configuracao_permissao);
                    @endphp
                    <select class="form-control select2" id="configuracao_permissao{{ $permissao->id }}"
                        name="configuracao_permissao[]" multiple style="width: 100%">
                        @foreach ($telas as $tela)
                        @if ($tela->tipo == 'Não acessível' || $tela->tipo == 'Desativado')
                        @continue
                        @endif
                        <option value="{{ $tela->id }}">{{ $tela->nome_tela }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach ($permissoes as $permissao)
<div class="modal fade" id="modalConfirmarExclusao{{ $permissao->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            Você tem certeza que deseja excluir esta permissão?
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
@endforeach

<script>
    $(document).ready(function () {
        $('.btn-editar').on('click', function () {
            var permissaoId = $(this).data('permissao-id');
            $('#configuracao_permissao' + permissaoId).select2({
                placeholder: 'Selecione as telas',
                allowClear: true,
                tags: true,
                dropdownParent: $('.modal-editar-permissao[data-permissao-id="' + permissaoId + '"]')
            });
        });
    });
</script>
@endsection

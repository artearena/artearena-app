@extends('layout.main')
@section('title', 'Tabela de Telas')
@section('style')
<style>
    /* Estilos personalizados */
    .dataTable {
        display: block;
        width: 100%;
        margin: 1em 0;
    }
    .dataTable thead,
    .dataTable tbody,
    .dataTable thead tr,
    .dataTable th {
        display: block;
    }
    .dataTable thead {
        float: left;
    }
    .dataTable tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .dataTable td,
    .dataTable th {
        padding: .625em;
        line-height: 1.5em;
        border-bottom: 1px dashed #ccc;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .dataTable th {
        text-align: center;
        background: #212529;
        color: white;
        border-bottom: 1px dashed #aaa;
    }
    .dataTable tbody tr {
        display: table-cell;
    }
    .dataTable tbody td {
        display: block;
    }
    .dataTable tr:nth-child(odd) {
        background: rgba(0, 0, 0, 0.07);
    }
    .dataTable .select-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dataTable .select-container select {
        margin: 0;
    }
    @media screen and (min-width: 50em) {
        .dataTable {
            display: table;
        }
        .dataTable thead {
            display: table-header-group;
            float: none;
        }
        .dataTable tbody {
            display: table-row-group;
        }
        .dataTable thead tr,
        .dataTable tbody tr {
            display: table-row;
        }
        .dataTable th,
        .dataTable tbody td {
            display: table-cell;
        }
        .dataTable td,
        .dataTable th {
            width: auto;
        }
        .dataTable .select-container {
            display: table-cell;
        }
        .dataTable .select-container select {
            margin: auto;
        }
        .red-text {
            color: red;
        }
    }

    /* New container styles */
    .container-with-margin {
        margin: 20px; /* Adjust the margin size as needed */
    }
</style>
<script>
    // Script personalizado
</script>
@endsection
@section('content')
<div class="app container-with-margin">
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome_usuario">Nome do Usuário</label>
            <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Digite o nome do usuário">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite o email">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite a senha">
        </div>
        <div class="form-group">
            <label for="permissoes">Permissões</label>
            <select class="form-control" id="permissoes" name="permissoes">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Criar Usuário</button>
    </form>
    <table id="tabelaUsuarios" class="dataTable">
        <thead>
            <tr>
                <th>Nome do Usuário</th>
                <th>Email</th>
                <th>Permissões</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td contenteditable="true" class="edit" data-id="{{ $usuario->id }}" data-field="nome_usuario">{{ $usuario->nome_usuario }}</td>
                <td contenteditable="true" class="edit" data-id="{{ $usuario->id }}" data-field="email">{{ $usuario->email }}</td>
                <td>
                    <select class="form-control edit-select" data-id="{{ $usuario->id }}" data-field="permissoes">
                        @foreach($permissoes as $permissao)
                            <option value="{{ $permissao->id }}" {{ $usuario->permissoes == $permissao->id ? 'selected' : '' }}>{{ $permissao->nome }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('extraScript')
<script>
    $(document).ready(function(){
        // Seu JavaScript aqui
    });
</script>
@endsection
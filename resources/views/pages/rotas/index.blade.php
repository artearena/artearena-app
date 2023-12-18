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
    <form action="{{ route('rotas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome_tela">Nome da Tela</label>
            <input type="text" class="form-control" id="nome_tela" name="nome_tela" placeholder="Digite o nome da tela">
        </div>
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <select class="form-control" id="tipo" name="tipo">
                <option value="Ativado">Ativado</option>
                <option value="Desativado">Desativado</option>
                <option value="Não acessível">Não acessível</option>
            </select>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Digite a descrição">
        </div>
        <div class="form-group">
            <label for="rota">URL</label>
            <input type="text" class="form-control" id="rota" name="rota" placeholder="Digite a rota">
        </div>
        <button type="submit" class="btn btn-primary">Criar Rota</button>
    </form>
    <table id="tabelaTelas" class="dataTable">
        <thead>
            <tr>
                <th>Nome da Tela</th>
                <th>Tipo</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($telas as $tela)
            <tr>
                <td contenteditable="true" class="edit" data-id="{{ $tela->id }}" data-field="nome_tela">{{ $tela->nome_tela }}</td>
                <td>
                    <select class="form-control edit-select" data-id="{{ $tela->id }}" data-field="tipo">
                        <option value="Ativado" {{ $tela->tipo == 'Ativado' ? 'selected' : '' }}>Ativado</option>
                        <option value="Desativado" {{ $tela->tipo == 'Desativado' ? 'selected' : '' }}>Desativado</option>
                        <option value="Não acessível" {{ $tela->tipo == 'Não acessível' ? 'selected' : '' }}>Não acessível</option>
                    </select>
                </td>
                <td contenteditable="true" class="edit" data-id="{{ $tela->id }}" data-field="descricao">{{ $tela->descricao }}</td>
                <td>
                    <a href="{{ $tela->rota }}"><i class="fas fa-external-link-alt"></i></a>
                    <button class="btn btn-primary"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('extraScript')
    <script src="../js/rotas.js"></script>
@endsection
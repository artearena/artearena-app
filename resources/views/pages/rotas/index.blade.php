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
</style>
<script>
    // Script personalizado
</script>
@endsection
@section('content')
<div class="app">
    <table id="tabelaTelas" class="dataTable">
        <thead>
            <tr>
                <th>Nome da Tela</th>
                <th>Tipo</th>
                <th>Rota</th>
                <th>Editar Rota</th>
                <th>Excluir Rota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($telas as $tela)
            <tr>
                <td>{{ $tela->nome_tela }}</td>
                <td><input type="checkbox" name="tipo" value="{{ $tela->tipo }}"></td>
                <td><a href="{{ $tela->rota }}"><i class="fas fa-external-link-alt"></i></a></td>
                <td><button class="btn btn-primary"><i class="fas fa-edit"></i></button></td>
                <td><button class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
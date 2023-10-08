@extends('layout.main')
@section('title')
    Tabela de erros
@endsection
@section('content')
    <form action="{{ route('erros.store') }}" method="POST">
        @csrf
        <label for="departamento">Departamento:</label>
        <input type="text" id="departamento" name="departamento">
        <label for="data">Data:</label>
        <input type="date" id="data" name="data">
        <label for="responsavel">Responsável:</label>
        <input type="text" id="responsavel" name="responsavel">
        <label for="pedido">Nº Pedido:</label>
        <input type="text" id="pedido" name="pedido">
        <label for="tipo_produto">Tipo de Produto:</label>
        <input type="text" id="tipo_produto" name="tipo_produto">
        <label for="tipo_erro">Tipo de Erro:</label>
        <input type="text" id="tipo_erro" name="tipo_erro">
        <label for="erro">Erro:</label>
        <textarea id="erro" name="erro"></textarea>
        <label for="consequencia_erro">Consequência do Erro:</label>
        <textarea id="consequencia_erro" name="consequencia_erro"></textarea>
        <label for="custo">Custo:</label>
        <input type="text" id="custo" name="custo">
        <label for="descontado">Descontado:</label>
        <input type="text" id="descontado" name="descontado">
        <button type="submit">Cadastrar Erro</button>
    </form>
@endsection


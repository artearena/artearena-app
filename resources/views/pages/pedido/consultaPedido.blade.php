@extends('layout.main')
@section('title')
    Etapa do pedido
@endsection
@section('style')
<style>
    .container {
        width: 500px;
        margin: 0 auto;
    }

    .resultado {
        margin-top: 20px;
        border: 1px solid #ccc;
        padding: 10px;
    }
</style>
@endsection
@section('content')
    <div class="container">
    <h1>Consulta de etapa do pedido</h1>

    <form action="/consulta-etapa-pedido">
        <label for="numero_pedido">Número do pedido:</label>
        <input type="text" id="numero_pedido" name="numero_pedido" required>

        <button type="submit">Consultar</button>
        <button type="reset">Limpar</button>
    </form>

    <div class="resultado">
        @if(isset($etapa))
            <p>Etapa: {{ $etapa }}</p>
        @else
            <p>Etapa não definida</p>
        @endif
    </div>
    </div>
@endsection

@extends('layout.main')

@section('title')
    Etapa do pedido
@endsection

@section('style')
<style>
    .resultado {
        display: none; /* Oculta a parte de resultado inicialmente */
    }
</style>
@endsection

@section('content')
    <div class="container">
        <h1 class="mt-4">Consulta de etapa do pedido</h1>

        <form action="/consulta-etapa-pedido" class="mt-4">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="numero_pedido">Número do pedido:</label>
                    <input type="text" class="form-control" id="numero_pedido" name="numero_pedido" style="width: 400px;" required>
                </div>
                <div class="form-group col-md-6 d-flex align-items-end justify-content-end">
                    <button type="submit" class="btn btn-primary">Consultar</button>
                </div>
            </div>
        </form>

        <div class="resultado mt-4">
            @if(isset($etapa))
                <p>Etapa: {{ $etapa }}</p>
            @else
                <p>Etapa não definida</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Mostra a parte de resultado quando há um resultado definido
    @if(isset($etapa))
        document.querySelector('.resultado').style.display = 'block';
    @endif
</script>
@endpush

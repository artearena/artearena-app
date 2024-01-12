@extends('layout.main')
@section('title')
    Relatório Tiny
@endsection
@section('style')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            font-size: .9em;
        }

        tfoot td {
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
@section('content')
    <div class="container">
        <h1>Relatório tiny</h1>
        <form method="get" action="{{ route('tiny.relatorio') }}">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dataInicial" class="form-label">Data Inicial</label>
                    <input type="date" class="form-control" id="dataInicial" name="dataInicial" value="{{ date('Y-m-01') }}">
                </div>
                <div class="col-md-4">
                    <label for="dataFinal" class="form-label">Data Final</label>
                    <input type="date" class="form-control" id="dataFinal" name="dataFinal" value="{{ date('Y-m-t') }}">
                </div>
                <div class="col-md-4">
                    <label for="situacao" class="form-label">Situação</label>
                    <select class="form-control select2" id="situacao" name="situacao[]" multiple>
                        <!-- Opções para Situação -->
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        <table class="mt-3">
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>Soma Total em Reais</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados as $item)
                    <tr>
                        <td>{{ $item->nome_vendedor }}</td>
                        <td>R$ {{ number_format($item->soma_total_reais, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Nenhum dado encontrado</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>R$ {{ number_format($somaTotalPorVendedor->sum('soma_total_reais'), 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // Inicializar o Select2
            $('.select2').select2();

            // Adicionar opções ao Select2 para Situação
            var situacaoOptions = [
                { id: 'Aprovado', text: 'Aprovado' },
                { id: 'Entregue', text: 'Entregue' },
                // Adicione mais opções conforme necessário
            ];

            $('#situacao').select2({
                data: situacaoOptions,
                placeholder: 'Selecione as situações',
            });
        });
    </script>
@endsection

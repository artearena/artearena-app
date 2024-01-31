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
@endsection
@section('content')
    <div class="container">
        <h1>Relatório tiny</h1>
        <form method="get" action="{{ route('tiny.relatorio') }}">
            <div class="row mb-3">
            <div class="col-md-4">
                <label for="dataInicial" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="dataInicial" name="dataInicial" value="{{ old('dataInicial', $dataInicial ?? date('Y-m-01')) }}">
            </div>
            <div class="col-md-4">
                <label for="dataFinal" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="dataFinal" name="dataFinal" value="{{ old('dataFinal', $dataFinal ?? date('Y-m-t')) }}">
            </div>

            <div class="col-md-4">
                <label for="situacao" class="form-label">Situação</label>
                <select class="form-control select2" id="situacao" name="situacao[]" multiple>
                    @foreach($situacoes as $situacao)
                        @if($situacao !== 'Cancelado')
                            <option value="{{ $situacao }}" selected>
                                {{ $situacao }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        <table class="mt-3">
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>Valor do Frete</th>
                    <th>Valor Total</th>
                    <th>Valor Descontando o Frete</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados as $item)
                    <tr>
                        <td>{{ $item->nome_vendedor ?: 'Sem vendedor' }}</td>
                        <td>R$ {{ number_format($item->soma_total_frete, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->soma_total, 2, ',', '.') }}</td>
                        <td>{{ $item->soma_total_reais }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Nenhum dado encontrado</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td>R$ {{ number_format($dados->sum('soma_total'), 2, ',', '.') }}</td>
                    <td><strong>R$ {{ number_format($dados->sum('soma_total') - $dados->sum('soma_total_frete'), 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>


    </div>
    @include('pages.tiny.grafico')
@endsection
@section('extraScript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(window).on('load', function () {
        // Inicializar o Select2
        $('.select2').select2();

        // Adicionar opções ao Select2 para Situação
        var situacaoOptions = [
            { id: 'Aprovado', text: 'Aprovado' },
            { id: 'Entregue', text: 'Entregue' },
            { id: 'Cancelado', text: 'Cancelado' },
            { id: 'Não entregue', text: 'Não entregue' },
            { id: 'Dados incompletos', text: 'Dados incompletos' },
            { id: 'Enviado', text: 'Enviado' },
            { id: 'Pronto para envio', text: 'Pronto para envio' },
        ];

        $('#situacao').select2({
            data: situacaoOptions,
            placeholder: 'Selecione as situações',
        });

        // Ordenar a tabela pelo valor total após a renderização completa da página
        $('#dataTable').ready(function () {
            var rows = $('#dataTable tbody tr').get();

            rows.sort(function (a, b) {
                var aValue = parseFloat($(a).find('td:eq(2)').text().replace('R$ ', '').replace('.', '').replace(',', '.'));
                var bValue = parseFloat($(b).find('td:eq(2)').text().replace('R$ ', '').replace('.', '').replace(',', '.'));

                return aValue - bValue;
            });

            $.each(rows, function (index, row) {
                $('#dataTable').children('tbody').append(row);
            });
        });
    });
</script>
@endsection

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
        th, td {
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
    </style>
@endsection
@section('content')
    <div class="container">
        <h1>Relatório tiny</h1>
        <table>
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>Total Pedido</th>
                    <th>Total Frete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados as $item)
                    @if($item->total_pedido != 0 || $item->total_frete != 0)
                        <tr>
                            @php
                                $vendedor = $vendedores->firstWhere('id_vendedor', $item->id_vendedor);
                            @endphp
                            <td>{{ $vendedor ? $vendedor->nome_usuario : 'Sem Vendedor' }}</td>
                            <td>R$ {{ number_format($item->total_pedido, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->total_frete, 2, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>R$ {{ number_format($dados->sum('total_pedido'), 2, ',', '.') }}</strong></td>
                    <td><strong>R$ {{ number_format($dados->sum('total_frete'), 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
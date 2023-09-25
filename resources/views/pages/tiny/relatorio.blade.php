@extends('layout.main')
@section('title')
    Relatório Trello
@endsection
@section('style')
    <style>
        /* Estilos personalizados para a tela de relatórios */
    </style>
@endsection
@section('body')
    <div class="container">
        <h1>Relatório Trello</h1>
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
                <tr>
                    <td>{{ $item->id_vendedor }}</td>
                    <td>R$ {{ number_format($item->total_pedido, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->total_frete, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>    
    </div>
@endsection
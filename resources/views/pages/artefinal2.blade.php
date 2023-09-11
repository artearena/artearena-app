@extends('layout.main')

@section('title')
Consulta de Pedidos
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
<table id="myTable">
    <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Data 1</td>
            <td>Data 2</td>
            <!-- Add more rows and data as needed -->
        </tr>
    </tbody>
</table>
@endsection

@section('extraScript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script> let table = new DataTable('#myTable'); </script>

    @endsection

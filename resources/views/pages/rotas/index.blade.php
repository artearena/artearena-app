@extends('layout.main')
@section('title')
    Rotas do sistema
@endsection
@section('content')
    <div class="container">
        <h1>Gerenciamento de acesso as rotas</h1>
    </div>

    <div class="container">
        <ul>
            @foreach($telas as $tela)
                <li>{{ $tela->nome_tela }}</li>
            @endforeach
        </ul>
    </div>
@endsection
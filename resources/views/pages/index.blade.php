@extends('layout.main')
@section('title')
Inicio
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bandeiras</h5>
                    <p class="card-text">Descrição da funcionalidade "Bandeiras"</p>
                    <a href="{{ route('bandeira') }}" class="btn btn-outline-success">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gerar Orçamentos</h5>
                    <p class="card-text">Descrição de Gerar Orçamentos</p>
                    <a href="{{ route('frete') }}" class="btn btn-outline-warning">Acessar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Arte Final</h5>
                    <p class="card-text">Descrição de arte final</p>
                    <a href="{{ route('pedido') }}" class="btn btn-outline-info">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Impressão</h5>
                    <p class="card-text">Descrição de impressão</p>
                    <a href="{{ route('impressao') }}" class="btn btn-outline-primary">Acessar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Controle de Confecções</h5>
                    <p class="card-text">Descrição de controle de confecção</p>
                    <a href="{{ route('confeccao') }}" class="btn btn-outline-dark">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Controle de Reposições</h5>
                    <p class="card-text">Descrição de controle de confecção</p>
                    <a href="{{ route('reposicao') }}" class="btn btn-outline-danger">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

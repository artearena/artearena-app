@extends('layout.main')
@section('title')
Inicio
@endsection

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h5>Comercial</h5>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">CRM Octa</h5>
                    <p class="card-text">Descrição de CRM Octa</p>
                    <a href="{{ route('octa.crm') }}" class="btn btn-outline-success">Acessar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gerar Orçamento</h5>
                    <p class="card-text">Descrição de Gerar Orçamento</p>
                    <a href="{{ route('frete') }}" class="btn btn-outline-info">Acessar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Calculadora de bandeira</h5>
                    <p class="card-text">Descrição de Bandeira</p>
                    <a href="{{ route('bandeira') }}" class="btn btn-outline-warning">Acessar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tiny Relatório</h5>
                    <p class="card-text">Descrição de Tiny Relatório</p>
                    <a href="{{ route('tiny.relatorio') }}" class="btn btn-outline-warning">Acessar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Encurtar Link</h5>
                    <p class="card-text">Descrição de Encurtar Link</p>
                    <button id="btn-encurtar-link" class="btn btn-outline-primary">Encurtar Link</button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gerar Link Temporário</h5>
                    <p class="card-text">Gerar link para o cliente se cadastrar</p>
                    <a href="#" class="btn btn-outline-danger" onclick="gerarLinkTemporario()">Gerar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h5>Design</h5>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Arte Final</h5>
                    <p class="card-text">Descrição de Arte Final</p>
                    <a href="{{ route('pedido') }}" class="btn btn-outline-success">Acessar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mini Trello</h5>
                    <p class="card-text">Descrição de Mini Trello</p>
                    <a href="{{ route('trello.index') }}" class="btn btn-outline-info">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h5>Produção</h5>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Impressão</h5>
                    <p class="card-text">Descrição de Impressão</p>
                    <a href="{{ route('impressao') }}" class="btn btn-outline-primary">Acessar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Confecção</h5>
                    <p class="card-text">Descrição de Confecção</p>
                    <a href="{{ route('confeccao') }}" class="btn btn-outline-dark">Acessar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reposição</h5>
                    <p class="card-text">Descrição de Reposição</p>
                    <a href="{{ route('reposicao') }}" class="btn btn-outline-danger">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-encurtar-link" tabindex="-1" role="dialog" aria-labelledby="modal-encurtar-link-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-encurtar-link-label">Encurtar Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="url-input">URL:</label>
                    <input type="text" class="form-control" id="url-input" placeholder="Digite a URL">
                    <label for="url-encurtada-input">URL Encurtada:</label>
                    <input type="text" class="form-control" id="url-encurtada-input" placeholder="URL Encurtada">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-encurtar">Encurtar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Cerrar">Fechar</button>            </div>
            </div>
    </div>
</div>

<script>

</script>
<script>
    $(document).ready(function() {
        // Abrir o modal ao clicar no botão "Encurtar Link"
        $('#btn-encurtar-link').on('click', function() {
            $('#modal-encurtar-link').modal('show');
        });

        // Encurtar o link ao clicar no botão "Encurtar" dentro do modal
        $('#btn-encurtar').on('click', function() {
            var url = $('#url-input').val();
            // Aqui você pode adicionar a lógica para encurtar o link da URL digitada
            // Fechar o modal após encurtar o link
            /* $('#modal-encurtar-link').modal('hide'); */
        });
        $(document).ready(function() {
            // Encurtar o link ao clicar no botão "Encurtar"
            $('#btn-encurtar').on('click', function() {
                var url = $('#url-input').val();
                // Fazer a requisição GET para sua API
                $.get('https://artearena.kinghost.net/encurtar-link', { link: url })
                .done(function(response) {
                    var urlEncurtada = response.urlEncurtada;
                    // Preencher o campo de URL encurtada com o valor retornado pela API
                    $('#url-encurtada-input').val(urlEncurtada);
                    console.log('URL encurtada:', urlEncurtada);
                })
                .fail(function(error) {
                    console.log('Erro ao consultar a API:', error);
                });
            });
        });
    });
</script>

@endsection

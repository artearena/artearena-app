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
                    <a href="{{ route('orcamento') }}" class="btn btn-outline-info">Acessar</a>
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
                    <h5 class="card-title">Pedido Interno</h5>
                    <p class="card-text">Página de gestão dos pedidos internos</p>
                    <a href="{{ route('pedidoInterno')}}" class="btn btn-outline-danger">Acessar</a>
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
                    <h5 class="card-title">Calculadora de Data Prevista</h5>
                    <p class="card-text">Descrição da Calculadora de Data Prevista</p>
                    <button id="btn-abrir-modal-calculadora" class="btn btn-outline-primary">Abrir Calculadora</button>
                </div>
            </div>
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
                <button type="button" class="btn btn-secondary" id="btn-fechar" data-dismiss="modal" aria-label="Fechar">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Calculadora de Data Prevista -->
<div class="modal fade" id="modal-calculadora-data-prevista" tabindex="-1" role="dialog" aria-labelledby="modal-calculadora-data-prevista-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-calculadora-data-prevista-label">Calculadora de Data Prevista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulário para a calculadora de data prevista -->
                <form>
                    <div class="form-group">
                        <label for="data-venda">Data da Venda:</label>
                        <input type="date" class="form-control" id="data-venda">
                    </div>
                    <div class="form-group">
                        <label for="dias-confeccao">Dias de Confecção:</label>
                        <input type="number" class="form-control" id="dias-confeccao">
                    </div>
                    <div class="form-group">
                        <label for="dias-entrega">Dias de Entrega:</label>
                        <input type="number" class="form-control" id="dias-entrega">
                    </div>
                    <div class="form-group">
                        <label for="data-prevista">Data Prevista:</label>
                        <input type="date" class="form-control" id="data-prevista" disabled>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-calcular-data-prevista">Calcular</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


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
                $.get('https://artearena.kinghost.net/encurtar-linknine', { link: url })
                .done(function(response) {
                    var urlEncurtada = response.urlEncurtada;
                    console.log(response);
                    // Preencher o campo de URL encurtada com o valor retornado pela API
                    $('#url-encurtada-input').val(response);
                    console.log('URL encurtada:', response);
                })
                .fail(function(error) {
                    console.log('Erro ao consultar a API:', error);
                });
            });
        });
    });
</script>
<script>
     // Abrir o modal quando o botão "Encurtar Link" for clicado
     document.getElementById('btn-encurtar-link').addEventListener('click', function() {
        $('#modal-encurtar-link').modal('show');
    });

    // Fechar o modal quando o botão de fechar ou o botão "Fechar" no modal for clicado
    const closeButtons = document.querySelectorAll('[data-dismiss="modal"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            $('#modal-encurtar-link').modal('hide');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Abrir o modal da calculadora de data prevista
        $('#btn-abrir-modal-calculadora').on('click', function() {
            $('#modal-calculadora-data-prevista').modal('show');
        });

        $('#btn-calcular-data-prevista').on('click', function() {
            // Obter os valores dos inputs
            var dataVenda = $('#data-venda').val();
            var diasConfeccao = parseInt($('#dias-confeccao').val());
            var diasEntrega = parseInt($('#dias-entrega').val());

            // Converter a data da venda para o formato esperado "yyyy-MM-dd"
            var partesData = dataVenda.split('/');
            var dataFormatada = partesData[2] + '-' + partesData[1] + '-' + partesData[0];

            // Criar um objeto Date com a data formatada
            var data = new Date(dataFormatada);

            // Adicionar um dia para começar a contar a partir do dia seguinte à venda
            data.setDate(data.getDate() + 1);

            // Adicionar os dias de confecção
            for (var i = 0; i < diasConfeccao; i++) {
                // Adiciona um dia à data
                data.setDate(data.getDate() + 1);

                // Se a data for sábado, adicione mais um dia para pular o sábado
                if (data.getDay() === 6) {
                    data.setDate(data.getDate() + 1);
                }
            }

            // Adicionar os dias de entrega
            for (var i = 0; i < diasEntrega; i++) {
                // Adiciona um dia à data
                data.setDate(data.getDate() + 1);

                // Se a data for sábado, adicione mais um dia para pular o sábado
                if (data.getDay() === 6) {
                    data.setDate(data.getDate() + 1);
                }
            }

            // Formatar a data prevista no formato "dd/MM/yyyy"
            var dia = data.getDate().toString().padStart(2, '0');
            var mes = (data.getMonth() + 1).toString().padStart(2, '0');
            var ano = data.getFullYear();
            var dataPrevistaFormatada = dia + '/' + mes + '/' + ano;

            // Preencher o campo de data prevista com a data calculada
            $('#data-prevista').val(dataPrevistaFormatada);
        });


    });
</script>
@endsection

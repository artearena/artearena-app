@extends('layout.main')
@section('title')
  Gerar Orçamento
@endsection
@section('style')
<style>
  .close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 0;
    margin: 0;
    font-size: 21px;
    font-weight: bold;
    line-height: 1;
    text-align: center;
    text-decoration: none;
    color: #000;
    background-color: transparent;
    border: 0;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
    .form-group {
        margin-bottom: 10px;
    }
    #cep-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    }
    #transp-title {
        display: flex;
        justify-content: center;
      }
    .form-group{
        width: 100%;
        height: auto;
    }
    #calcularFrete {
    width: 30%;
    height: auto;
    margin-top: 10px;
    }
    .cards-container {
        display: flex;
        flex-wrap: wrap;
    }

    .card {
        width: calc(25% - 20px);
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .card.selected {
        border-color: blue;
    }
    .modal-dialog {
      margin: 5% auto;
      min-width: 190vh;
    }
    .card img {
        max-width: 20%;
        height: auto;
        margin-bottom: 1em;
    }
    .container {
           max-width: 100%;
           display: flex;
           justify-content: space-between;
    }

    .details-container h4 {
        margin-bottom: 10px;
    }

    #botaoCopiar {
        float: right;
        margin-top: 5px;
        display: none;
    }

    #avisoCopiado {
        float: right;
        margin-top: 10px;
    }

    .col-md-6 {
        display: flex;
        flex-direction: column;
    }
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
        text-align: center;
    }
    td {
        font-size: .9em;
    }
    tfoot td {
        font-weight: bold;
    }
    tbody tr:nth-child(even) {
        background-color: #f5f5f5;
    }
    tbody tr:hover {
        background-color: #ebebeb;
    }
    #campoTexto{
        min-height: 300px;
    }
    .radio-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .radio-container label {
        margin-bottom: 0;
    }
    P {
      margin-bottom: 0;
    }
    .blue-text {
      color: #4169e1;
    }
    .center-icon {
      display: block;
      margin: 0 auto;
      min-width: none;
      min-height:
    }
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 1005; /* Defina o tamanho desejado para a div */
      height: 1005; /* Defina o tamanho desejado para a div */
      margin: 0 auto; /* Centraliza a div horizontalmente */
    }
    #descricaoCardTrello{
      min-height: 350px;
    }
    .table-responsive::-webkit-scrollbar {
      width: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
      background-color: #f1f1f1;
    }

    .table-responsive::-webkit-scrollbar-thumb {
      background-color: #888;
      border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
      background-color: #555;
    }
    .descricao-orcamento {
      min-width: 400px;
    }

    .modal-content {
      width: 100%;
      height: 100%;
      padding: 20px;
    }

    .modal-body {
      height: 400px;
    }

    .modal-title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
    }

    textarea {
      height: 150px;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      color: #fff;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 5px;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
      color: #fff;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 5px;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
    }

    .close {
      font-size: 28px;
      font-weight: bold;
      color: #000;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

@endsection

@section('content')
<div class="container">

        <div class="row">
        <h1>Gerar Orçamentos</h1>
        <hr>
            <div class="col-md-6">
                <form id="opt-octa-form" method="POST" action="">
                    <div class="form-group">
                      <div class="radio-container">
                          <div class="custom-control custom-radio">
                              <input type="radio" id="gerarRascunho" name="tipoDocumento" class="custom-control-input" onclick="desmarcarOrcamento()">
                              <label class="custom-control-label" for="gerarRascunho">Gerar Rascunho</label>
                          </div>
                          <div class="custom-control custom-radio">
                              <input type="radio" id="gerarOrcamento" name="tipoDocumento" class="custom-control-input" onclick="desmarcarRascunho()" checked>
                              <label class="custom-control-label" for="gerarOrcamento">Gerar Orçamento</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="container">
                            <div class="form-group">
                                <label for="id">ID Cliente:</label>
                                <div class="input-group">
                                    <input type="text" id="id" class="form-control"></input>
                                    <div class="input-group-append">
                                        <button id="buscar_orcamento" class="btn btn-primary" type="button">Buscar Orçamentos</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="produto-form" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <div class="container">
                            <div class="form-group">
                                <label for="produto">Produto:</label>
                                <select class="form-control select2" id="produto" name="produto">
                                    <option value="">Selecione um produto</option>
                                    <option value="personalizado">Produto Personalizado</option>
                                    @foreach ($produtos->sortBy('NOME')->sortBy(function($produto) {
                                    return strpos($produto->NOME, 'Bandeira Personalizada') !== false ? 0 : 1;
                                    }) as $produto)
                                    @if ($produto->NOME !== 'Bandeira Personalizada')
                                    <option value="{{ $produto->id }}">{{ $produto->NOME }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th hidden>ID</th>
                            <th>Produto</th>
                            <th>R$</th>
                            <th>Kg</th>
                            <th>Qtd</th>
                            <th>Confecção</th>
                            <th>Ilhose</th>
                            <th>Mastro</th>
                            <th>Alt.</th>
                            <th>Comp.</th>
                            <th>Larg.</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="produtoTableBody"></tbody>
                      </table>
                    </div>
                </form>
                <form id="cep-form" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="cep">CEP:</label>
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP">
                    </div>
                    <div class="form-group">
                        <label for="endereco">Endereço:</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" readonly="" style="background-color: #f2f2f2;">
                    </div>
                </form>
                <div class="col-md-12">
                    <div id="transp-title">
                        <h3>Transportadoras:</h3>
                    </div>
                    <div class="cards-container" id="cardsContainer"></div>
                </div>
                <button type="button" class="btn btn-primary" id="calcularFrete">Calcular</button>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Detalhes do orçamento:</h4>
                        <div class="details-container">
                            <textarea class="form-control" id="campoTexto" rows="5"></textarea>
                            <button type="button" class="btn btn-primary" id="botaoOrcamento">Salvar/Enviar Orçamento</button>                
                            <button type="button" class="btn btn-secondary" id="botaoLimparCampos">Novo Orçamento</button>
                            <button type="button" class="btn btn-primary" id="botaoCopiar">Copiar</button>
                            <p class="text-success" id="avisoCopiado" style="display: none;">Copiado com sucesso!</p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="details-container2">
                            <h4>Detalhes do card</h4>
                            <div class="form-group">
                                <label for="tituloCardTrello">Título:</label>
                                <input type="text" class="form-control" id="tituloCardTrello">
                            </div>
                            <div class="form-group">
                                <label for="descricaoCardTrello">Descrição:</label>
                                <textarea class="form-control" id="descricaoCardTrello" rows="5"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary" id="botaoCardTrello">Gerar Card</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPedidos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <!-- Cabeçalho do modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Criar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Corpo do modal -->
      <div class="modal-body">
        <div class="form-group">
          <label for="idPedido">ID:</label>
          <input type="text" class="form-control" id="idPedido">
        </div>
        <div class="form-group">
          <label for="clientePedido">Cliente:</label>
          <input type="text" class="form-control" id="clientePedido">
        </div>
        <div class="form-group">
          <label for="produtosPedido">Produtos:</label>
          <textarea class="form-control" id="produtosPedido"></textarea>
        </div>
      </div>
      
      <!-- Rodapé do modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
      
    </div>
  </div>
</div>

@endsection
@section('extraScript')

<script src="../js/orcamento.js"></script>

@endsection

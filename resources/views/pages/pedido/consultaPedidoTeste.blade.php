@extends('layout.main')

@section('title')
    Etapa do pedido
@endsection

@section('style')
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        /* Estilos CSS aqui */

        .resultado {
            display: none; /* Oculta a parte de resultado inicialmente */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: pop;
            src: url(https://fonts.gstatic.com/s/poppins/v15/pxiByp8kv8JHgFVrLDz8Z1xlFd2JQEk.woff2);
        }

        .main {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: pop;
            flex-direction: column;
        }

        .status-exemplo {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
            /* Adicione mais estilos conforme necessário */
        }

        #exemplosStatusContainer {
            display: none; /* Oculta inicialmente, mostrado via JavaScript */
            flex-wrap: wrap; /* Permite que os itens se ajustem em várias linhas conforme necessário */
            gap: 10px; /* Espaço entre os itens */
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="container mt-4" id="consultarPedidoContainer">
            <h1>Consulta de Pedidos</h1>
            <div class="form-group">
                <label for="cpf_cnpj">CPF/CNPJ:</label>
                <input type="text" class="form-control" id="cpf_cnpj" placeholder="Digite o CPF/CNPJ">
            </div>
            <button id="consultarPedidosBtn" class="btn btn-primary">Consultar Pedidos</button>
        </div>

        <!-- Modal para exibir a lista de pedidos -->
        <div class="modal fade" id="listaPedidosModal" tabindex="-1" aria-labelledby="listaPedidosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="listaPedidosModalLabel">Lista de Pedidos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Data do Pedido</th>
                                    <th>Valor</th>
                                    <th>Situação</th>
                                    <th>Código de Rastreio</th>
                                    <th>Link do Rastreio</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="listaPedidosTableBody"></tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4" id="detalhesPedidoContainer" style="display: none;">
            <!-- Barra de status aqui -->
            <div id="statusBar" class="status-bar d-flex justify-content-around mb-3">
                <!-- Exemplos de status serão inseridos aqui via JavaScript -->
            </div>
            <button id="voltarBtn" class="btn btn-secondary mb-3">Voltar</button>
            <h2>Detalhes do Pedido</h2>
            <table class="table">
                <tbody id="detalhesPedidoTableBody"></tbody>
            </table>
        </div>
    </div>
    <!-- Modal Nota Fiscal -->
    <div id="modalNF" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nota Fiscal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID Nota Fiscal:</th>
                                <td id="idNotaFiscal"></td>
                            </tr>
                            <tr>
                                <th>Tipo Nota:</th>
                                <td id="tipoNota"></td>
                            </tr>
                            <tr>
                                <th>Natureza da Operação:</th>
                                <td id="naturezaOperacao"></td>
                            </tr>
                            <tr>
                                <th>Regime Tributário:</th>
                                <td id="regimeTributario"></td>
                            </tr>
                            <tr>
                                <th>Finalidade:</th>
                                <td id="finalidade"></td>
                            </tr>
                            <tr>
                                <th>Série:</th>
                                <td id="serie"></td>
                            </tr>
                            <tr>
                                <th>Número:</th>
                                <td id="numero"></td>
                            </tr>
                            <tr>
                                <th>Número E-commerce:</th>
                                <td id="numeroEcommerce"></td>
                            </tr>
                            <tr>
                                <th>Data de Emissão:</th>
                                <td id="dataEmissao"></td>
                            </tr>
                            <tr>
                                <th>Data de Saída:</th>
                                <td id="dataSaida"></td>
                            </tr>
                            <tr>
                                <th>Hora de Saída:</th>
                                <td id="horaSaida"></td>
                            </tr>
                            <tr>
                                <th>Nome do Cliente:</th>
                                <td id="nomeCliente"></td>
                            </tr>
                            <tr>
                                <th>Tipo Pessoa:</th>
                                <td id="tipoPessoa"></td>
                            </tr>
                            <tr>
                                <th>CPF/CNPJ:</th>
                                <td id="cpfCnpj"></td>
                            </tr>
                            <tr>
                                <th>Inscrição Estadual:</th>
                                <td id="ie"></td>
                            </tr>
                            <tr>
                                <th>Endereço:</th>
                                <td id="endereco"></td>
                            </tr>
                            <tr>
                                <th>Número:</th>
                                <td id="numeroEndereco"></td>
                            </tr>
                            <tr>
                                <th>Complemento:</th>
                                <td id="complemento"></td>
                            </tr>
                            <tr>
                                <th>Bairro:</th>
                                <td id="bairro"></td>
                            </tr>
                            <tr>
                                <th>CEP:</th>
                                <td id="cep"></td>
                            </tr>
                            <tr>
                                <th>Cidade:</th>
                                <td id="cidade"></td>
                            </tr>
                            <tr>
                                <th>UF:</th>
                                <td id="uf"></td>
                            </tr>
                            <tr>
                                <th>Telefone:</th>
                                <td id="telefone"></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td id="email"></td>
                            </tr>
                            <tr>
                                <th>Endereço de Entrega:</th>
                                <td id="enderecoEntrega"></td>
                            </tr>
                            <tr>
                                <th>Tipo Pessoa:</th>
                                <td id="tipoPessoaEntrega"></td>
                            </tr>
                            <tr>
                                <th>CPF/CNPJ:</th>
                                <td id="cpfCnpjEntrega"></td>
                            </tr>
                            <tr>
                                <th>Inscrição Estadual:</th>
                                <td id="ieEntrega"></td>
                            </tr>
                            <tr>
                                <th>Endereço:</th>
                                <td id="enderecoEntrega"></td>
                            </tr>
                            <tr>
                                <th>Número:</th>
                                <td id="numeroEnderecoEntrega"></td>
                            </tr>
                            <tr>
                                <th>Complemento:</th>
                                <td id="complementoEntrega"></td>
                            </tr>
                            <tr>
                                <th>Bairro:</th>
                                <td id="bairroEntrega"></td>
                            </tr>
                            <tr>
                                <th>CEP:</th>
                                <td id="cepEntrega"></td>
                            </tr>
                            <tr>
                                <th>Cidade:</th>
                                <td id="cidadeEntrega"></td>
                            </tr>
                            <tr>
                                <th>UF:</th>
                                <td id="ufEntrega"></td>
                            </tr>
                            <tr>
                                <th>Telefone:</th>
                                <td id="telefoneEntrega"></td>
                            </tr>
                            <tr>
                                <th>Nome do Destinatário:</th>
                                <td id="nomeDestinatario"></td>
                            </tr>
                            <tr>
                                <th>Itens:</th>
                                <td>
                                    <ul id="itens"></ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Base ICMS:</th>
                                <td id="baseIcms"></td>
                            </tr>
                            <tr>
                                <th>Valor ICMS:</th>
                                <td id="valorIcms"></td>
                            </tr>
                            <tr>
                                <th>Base ICMS ST:</th>
                                <td id="baseIcmsSt"></td>
                            </tr>
                            <tr>
                                <th>Valor ICMS ST:</th>
                                <td id="valorIcmsSt"></td>
                            </tr>
                            <tr>
                                <th>Valor dos Serviços:</th>
                                <td id="valorServicos"></td>
                            </tr>
                            <tr>
                                <th>Valor dos Produtos:</th>
                                <td id="valorProdutos"></td>
                            </tr>
                            <tr>
                                <th>Valor do Frete:</th>
                                <td id="valorFrete"></td>
                            </tr>
                            <tr>
                                <th>Valor do Seguro:</th>
                                <td id="valorSeguro"></td>
                            </tr>
                            <tr>
                                <th>Valor de Outras Despesas Acessórias:</th>
                                <td id="valorOutras"></td>
                            </tr>
                            <tr>
                                <th>Valor do IPI:</th>
                                <td id="valorIpi"></td>
                            </tr>
                            <tr>
                                <th>Valor do ISSQN:</th>
                                <td id="valorIssqn"></td>
                            </tr>
                            <tr>
                                <th>Valor Total da Nota:</th>
                                <td id="valorNota"></td>
                            </tr>
                            <tr>
                                <th>Valor do Desconto:</th>
                                <td id="valorDesconto"></td>
                            </tr>
                            <tr>
                                <th>Valor Faturado:</th>
                                <td id="valorFaturado"></td>
                            </tr>
                            <tr>
                                <th>Frete por Conta:</th>
                                <td id="fretePorConta"></td>
                            </tr>
                            <tr>
                                <th>Transportador:</th>
                                <td id="transportador"></td>
                            </tr>
                            <tr>
                                <th>Placa:</th>
                                <td id="placa"></td>
                            </tr>
                            <tr>
                                <th>UF Placa:</th>
                                <td id="ufPlaca"></td>
                            </tr>
                            <tr>
                                <th>Quantidade de Volumes:</th>
                                <td id="quantidadeVolumes"></td>
                            </tr>
                            <tr>
                                <th>Espécie dos Volumes:</th>
                                <td id="especieVolumes"></td>
                            </tr>
                            <tr>
                                <th>Marca dos Volumes:</th>
                                <td id="marcaVolumes"></td>
                            </tr>
                            <tr>
                                <th>Número dos Volumes:</th>
                                <td id="numeroVolumes"></td>
                            </tr>
                            <tr>
                                <th>Peso Bruto:</th>
                                <td id="pesoBruto"></td>
                            </tr>
                            <tr>
                                <th>Peso Líquido:</th>
                                <td id="pesoLiquido"></td>
                            </tr>
                            <tr>
                                <th>Forma de Envio:</th>
                                <td id="formaEnvio"></td>
                            </tr>
                            <tr>
                                <th>Forma de Frete:</th>
                                <td id="formaFrete"></td>
                            </tr>
                            <tr>
                                <th>Código de Rastreamento:</th>
                                <td id="codigoRastreamento"></td>
                            </tr>
                            <tr>
                                <th>URL de Rastreamento:</th>
                                <td id="urlRastreamento"></td>
                            </tr>
                            <tr>
                                <th>Condição de Pagamento:</th>
                                <td id="condicaoPagamento"></td>
                            </tr>
                            <tr>
                                <th>Forma de Pagamento:</th>
                                <td id="formaPagamento"></td>
                            </tr>
                            <tr>
                                <th>Meio de Pagamento:</th>
                                <td id="meioPagamento"></td>
                            </tr>
                            <tr>
                                <th>Parcelas:</th>
                                <td>
                                    <ul id="parcelas"></ul>
                                </td>
                            </tr>
                            <tr>
                                <th>ID da Venda:</th>
                                <td id="idVenda"></td>
                            </tr>
                            <tr>
                                <th>ID do Vendedor:</th>
                                <td id="idVendedor"></td>
                            </tr>
                            <tr>
                                <th>Nome do Vendedor:</th>
                                <td id="nomeVendedor"></td>
                            </tr>
                            <tr>
                                <th>Situação:</th>
                                <td id="situacao"></td>
                            </tr>
                            <tr>
                                <th>Descrição da Situação:</th>
                                <td id="descricaoSituacao"></td>
                            </tr>
                            <tr>
                                <th>Observações:</th>
                                <td id="obs"></td>
                            </tr>
                            <tr>
                                <th>Chave de Acesso:</th>
                                <td id="chaveAcesso"></td>
                            </tr>
                            <tr>
                                <th>Marcadores:</th>
                                <td>
                                    <ul id="marcadores"></ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Detalhes do Pedido -->
    <div id="modalDetalhesPedido" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detalhes do Pedido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="corpoDetalhesPedido">
            <!-- Os detalhes do pedido serão adicionados aqui dinamicamente -->
        </div>
        </div>
    </div>
    </div>
@endsection

@section('extraScript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('consultarPedidosBtn').addEventListener('click', function() {
                const cpf_cnpj = document.getElementById('cpf_cnpj').value; // Obtém o valor do CPF/CNPJ digitado pelo usuário

                // Faça a requisição usando fetch para a rota do backend
                fetch('https://artearena.kinghost.net/consultar_pedido_cpf_cnpj', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ cpf_cnpj: cpf_cnpj })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao consultar pedidos');
                    }
                    return response.json();
                })
                .then(data => {
                    // Limpe a tabela de pedidos antes de exibir os resultados
                    const tableBody = document.getElementById('listaPedidosTableBody');
                    tableBody.innerHTML = '';

                    // Itere sobre os pedidos retornados e adicione-os à tabela
                    data.retorno.pedidos.forEach(pedido => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${pedido.pedido.id}</td>
                            <td>${pedido.pedido.data_pedido}</td>
                            <td>R$ ${pedido.pedido.valor}</td>
                            <td>${pedido.pedido.situacao}</td>
                            <td>${pedido.pedido.codigo_rastreamento}</td>
                            <td><a href="${pedido.pedido.url_rastreamento}" target="_blank">Rastrear</a></td>
                            <td><button class="selecionarPedidoBtn btn btn-primary" data-id="${pedido.pedido.id}">Mais detalhes</button></td>
                        `;
                        tableBody.appendChild(row);
                    });

                    // Exiba o modal com a lista de pedidos
                    $('#listaPedidosModal').modal('show');
                })
                .catch(error => {
                    // Manipule erros, se houver
                    console.error('Erro ao consultar pedidos:', error);
                });
            });

            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('selecionarPedidoBtn')) {
                    const idPedido = event.target.getAttribute('data-id');

                    // Faz a requisição para obter os detalhes do pedido pelo ID
                    fetch(`https://artearena.kinghost.net/consultar-pedido-by-id?numeroPedido=${idPedido}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erro ao consultar detalhes do pedido');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Esconder o modal de lista de pedidos e preparar a exibição dos detalhes
                            $('#listaPedidosModal').modal('hide');
                            const detalhesContainer = document.getElementById('detalhesPedidoContainer');
                            detalhesContainer.style.display = 'block';
                            const consultarContainer = document.getElementById('consultarPedidoContainer');
                            consultarContainer.style.display = 'none';

                            // Limpar a tabela de detalhes do pedido
                            const detalhesTableBody = document.getElementById('detalhesPedidoTableBody');
                            detalhesTableBody.innerHTML = '';

                            // Quadro de Status da Nota Fiscal
                            const statusNotaFiscal = document.createElement('span');
                            statusNotaFiscal.classList.add('badge');
                            if (data.retorno.pedido.id_nota_fiscal !== "0") {
                                statusNotaFiscal.classList.add('badge-success');
                                statusNotaFiscal.innerText = 'Nota Fiscal Emitida';
                            } else {
                                statusNotaFiscal.classList.add('badge-danger');
                                statusNotaFiscal.innerText = 'Nota Fiscal Não Emitida';
                            }
                            statusNotaFiscal.style.marginRight = '10px'; // Adiciona um espaço à direita

                            // Botão Consultar NF
                            const btnConsultarNF = document.createElement('button');
                            btnConsultarNF.innerText = 'Consultar NF';
                            btnConsultarNF.classList.add('btn', 'btn-info', 'float-right', 'ml-2');
                            btnConsultarNF.setAttribute('data-toggle', 'modal');
                            btnConsultarNF.setAttribute('data-target', '#modalNF');
                            btnConsultarNF.addEventListener('click', () => {
                                // Evento acionado quando o modal é totalmente exibido
                                $('#modalNF').on('shown.bs.modal', function () {
                                    // Exibir os dados da nota fiscal no modal
                                    document.getElementById('idNotaFiscal').innerText = `ID Nota Fiscal: ${data.retorno.pedido.id_nota_fiscal}`;
                                    // Realizar a requisição para obter os detalhes da nota fiscal e exibir no modal
                                    fetch(`https://artearena.kinghost.net/obter-nota-fiscal/${data.retorno.pedido.id_nota_fiscal}`)
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Erro ao consultar nota fiscal');
                                            }
                                            return response.json();
                                        })
                                        .then(notaFiscalData => {
                                            // Adicionar os detalhes da nota fiscal ao modal
                                            document.getElementById('idNotaFiscal').innerText = `ID Nota Fiscal: ${notaFiscalData.retorno.nota_fiscal.id}`;
                                            document.getElementById('tipoNota').innerText = `Tipo Nota: ${notaFiscalData.retorno.nota_fiscal.tipo_nota}`;
                                            document.getElementById('naturezaOperacao').innerText = `Natureza da Operação: ${notaFiscalData.retorno.nota_fiscal.natureza_operacao}`;
                                            document.getElementById('regimeTributario').innerText = `Regime Tributário: ${notaFiscalData.retorno.nota_fiscal.regime_tributario}`;
                                            document.getElementById('finalidade').innerText = `Finalidade: ${notaFiscalData.retorno.nota_fiscal.finalidade}`;
                                            document.getElementById('serie').innerText = `Série: ${notaFiscalData.retorno.nota_fiscal.serie}`;
                                            document.getElementById('numero').innerText = `Número: ${notaFiscalData.retorno.nota_fiscal.numero}`;
                                            document.getElementById('numeroEcommerce').innerText = `Número E-commerce: ${notaFiscalData.retorno.nota_fiscal.numero_ecommerce}`;
                                            document.getElementById('dataEmissao').innerText = `Data de Emissão: ${notaFiscalData.retorno.nota_fiscal.data_emissao}`;
                                            document.getElementById('dataSaida').innerText = `Data de Saída: ${notaFiscalData.retorno.nota_fiscal.data_saida}`;
                                            document.getElementById('horaSaida').innerText = `Hora de Saída: ${notaFiscalData.retorno.nota_fiscal.hora_saida}`;
                                            document.getElementById('nomeCliente').innerText = `Nome do Cliente: ${notaFiscalData.retorno.nota_fiscal.cliente.nome}`;
                                            document.getElementById('tipoPessoa').innerText = `Tipo Pessoa: ${notaFiscalData.retorno.nota_fiscal.cliente.tipo_pessoa}`;
                                            document.getElementById('cpfCnpj').innerText = `CPF/CNPJ: ${notaFiscalData.retorno.nota_fiscal.cliente.cpf_cnpj}`;
                                            document.getElementById('ie').innerText = `Inscrição Estadual: ${notaFiscalData.retorno.nota_fiscal.cliente.ie}`;
                                            document.getElementById('endereco').innerText = `Endereço: ${notaFiscalData.retorno.nota_fiscal.cliente.endereco}`;
                                            document.getElementById('numeroEndereco').innerText = `Número: ${notaFiscalData.retorno.nota_fiscal.cliente.numero}`;
                                            document.getElementById('complemento').innerText = `Complemento: ${notaFiscalData.retorno.nota_fiscal.cliente.complemento}`;
                                            document.getElementById('bairro').innerText = `Bairro: ${notaFiscalData.retorno.nota_fiscal.cliente.bairro}`;
                                            document.getElementById('cep').innerText = `CEP: ${notaFiscalData.retorno.nota_fiscal.cliente.cep}`;
                                            document.getElementById('cidade').innerText = `Cidade: ${notaFiscalData.retorno.nota_fiscal.cliente.cidade}`;
                                            document.getElementById('uf').innerText = `UF: ${notaFiscalData.retorno.nota_fiscal.cliente.uf}`;
                                            document.getElementById('telefone').innerText = `Telefone: ${notaFiscalData.retorno.nota_fiscal.cliente.fone}`;
                                            document.getElementById('email').innerText = `Email: ${notaFiscalData.retorno.nota_fiscal.cliente.email}`;
                                            document.getElementById('enderecoEntrega').innerText = `Endereço de Entrega: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.endereco}`;
                                            document.getElementById('tipoPessoaEntrega').innerText = `Tipo Pessoa: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.tipo_pessoa}`;
                                            document.getElementById('cpfCnpjEntrega').innerText = `CPF/CNPJ: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.cpf_cnpj}`;
                                            document.getElementById('ieEntrega').innerText = `Inscrição Estadual: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.ie}`;
                                            document.getElementById('enderecoEntrega').innerText = `Endereço: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.endereco}`;
                                            document.getElementById('numeroEnderecoEntrega').innerText = `Número: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.numero}`;
                                            document.getElementById('complementoEntrega').innerText = `Complemento: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.complemento}`;
                                            document.getElementById('bairroEntrega').innerText = `Bairro: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.bairro}`;
                                            document.getElementById('cepEntrega').innerText = `CEP: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.cep}`;
                                            document.getElementById('cidadeEntrega').innerText = `Cidade: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.cidade}`;
                                            document.getElementById('ufEntrega').innerText = `UF: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.uf}`;
                                            document.getElementById('telefoneEntrega').innerText = `Telefone: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.fone}`;
                                            document.getElementById('nomeDestinatario').innerText = `Nome do Destinatário: ${notaFiscalData.retorno.nota_fiscal.endereco_entrega.nome_destinatario}`;
                                            
                                            // Itens
                                            const itensList = document.getElementById('itens');
                                            notaFiscalData.retorno.nota_fiscal.itens.forEach(item => {
                                                const li = document.createElement('li');
                                                li.textContent = `${item.item.descricao} - ${item.item.quantidade} ${item.item.unidade} - ${item.item.valor_total}`;
                                                itensList.appendChild(li);
                                            });
                                            
                                            document.getElementById('baseIcms').innerText = `Base ICMS: ${notaFiscalData.retorno.nota_fiscal.base_icms}`;
                                            document.getElementById('valorIcms').innerText = `Valor ICMS: ${notaFiscalData.retorno.nota_fiscal.valor_icms}`;
                                            document.getElementById('baseIcmsSt').innerText = `Base ICMS ST: ${notaFiscalData.retorno.nota_fiscal.base_icms_st}`;
                                            document.getElementById('valorIcmsSt').innerText = `Valor ICMS ST: ${notaFiscalData.retorno.nota_fiscal.valor_icms_st}`;
                                            document.getElementById('valorServicos').innerText = `Valor dos Serviços: ${notaFiscalData.retorno.nota_fiscal.valor_servicos}`;
                                            document.getElementById('valorProdutos').innerText = `Valor dos Produtos: ${notaFiscalData.retorno.nota_fiscal.valor_produtos}`;
                                            document.getElementById('valorFrete').innerText = `Valor do Frete: ${notaFiscalData.retorno.nota_fiscal.valor_frete}`;
                                            document.getElementById('valorSeguro').innerText = `Valor do Seguro: ${notaFiscalData.retorno.nota_fiscal.valor_seguro}`;
                                            document.getElementById('valorOutras').innerText = `Outras Despesas: ${notaFiscalData.retorno.nota_fiscal.valor_outras}`;
                                            document.getElementById('valorIpi').innerText = `Valor do IPI: ${notaFiscalData.retorno.nota_fiscal.valor_ipi}`;
                                            document.getElementById('valorIssqn').innerText = `Valor do ISSQN: ${notaFiscalData.retorno.nota_fiscal.valor_issqn}`;
                                            document.getElementById('valorNota').innerText = `Valor Total da Nota: ${notaFiscalData.retorno.nota_fiscal.valor_nota}`;
                                            document.getElementById('valorDesconto').innerText = `Valor do Desconto: ${notaFiscalData.retorno.nota_fiscal.valor_desconto}`;
                                            document.getElementById('valorFaturado').innerText = `Valor Faturado: ${notaFiscalData.retorno.nota_fiscal.valor_faturado}`;
                                            document.getElementById('fretePorConta').innerText = `Frete por Conta: ${notaFiscalData.retorno.nota_fiscal.frete_por_conta}`;
                                            document.getElementById('transportador').innerText = `Transportador: ${notaFiscalData.retorno.nota_fiscal.transportador.nome}`;
                                            document.getElementById('placa').innerText = `Placa: ${notaFiscalData.retorno.nota_fiscal.placa}`;
                                            document.getElementById('ufPlaca').innerText = `UF Placa: ${notaFiscalData.retorno.nota_fiscal.uf_placa}`;
                                            document.getElementById('quantidadeVolumes').innerText = `Quantidade de Volumes: ${notaFiscalData.retorno.nota_fiscal.quantidade_volumes}`;
                                            document.getElementById('especieVolumes').innerText = `Espécie dos Volumes: ${notaFiscalData.retorno.nota_fiscal.especie_volumes}`;
                                            document.getElementById('marcaVolumes').innerText = `Marca dos Volumes: ${notaFiscalData.retorno.nota_fiscal.marca_volumes}`;
                                            document.getElementById('numeroVolumes').innerText = `Número dos Volumes: ${notaFiscalData.retorno.nota_fiscal.numero_volumes}`;
                                            document.getElementById('pesoBruto').innerText = `Peso Bruto: ${notaFiscalData.retorno.nota_fiscal.peso_bruto}`;
                                            document.getElementById('pesoLiquido').innerText = `Peso Líquido: ${notaFiscalData.retorno.nota_fiscal.peso_liquido}`;
                                            document.getElementById('formaEnvio').innerText = `Forma de Envio: ${notaFiscalData.retorno.nota_fiscal.forma_envio.descricao}`;
                                            document.getElementById('formaFrete').innerText = `Forma de Frete: ${notaFiscalData.retorno.nota_fiscal.forma_frete.descricao}`;
                                            document.getElementById('codigoRastreamento').innerText = `Código de Rastreamento: ${notaFiscalData.retorno.nota_fiscal.codigo_rastreamento}`;
                                            document.getElementById('urlRastreamento').innerText = `URL de Rastreamento: ${notaFiscalData.retorno.nota_fiscal.url_rastreamento}`;
                                            document.getElementById('condicaoPagamento').innerText = `Condição de Pagamento: ${notaFiscalData.retorno.nota_fiscal.condicao_pagamento}`;
                                            document.getElementById('formaPagamento').innerText = `Forma de Pagamento: ${notaFiscalData.retorno.nota_fiscal.forma_pagamento}`;
                                            document.getElementById('meioPagamento').innerText = `Meio de Pagamento: ${notaFiscalData.retorno.nota_fiscal.meio_pagamento}`;

                                            // Parcelas
                                            const parcelasList = document.getElementById('parcelas');
                                            notaFiscalData.retorno.nota_fiscal.parcelas.forEach(parcela => {
                                                const li = document.createElement('li');
                                                li.textContent = `${parcela.parcela.data} - ${parcela.parcela.valor} - ${parcela.parcela.forma_pagamento} - ${parcela.parcela.meio_pagamento}`;
                                                parcelasList.appendChild(li);
                                            });

                                            document.getElementById('idVenda').innerText = `ID da Venda: ${notaFiscalData.retorno.nota_fiscal.id_venda}`;
                                            document.getElementById('idVendedor').innerText = `ID do Vendedor: ${notaFiscalData.retorno.nota_fiscal.id_vendedor}`;
                                            document.getElementById('nomeVendedor').innerText = `Nome do Vendedor: ${notaFiscalData.retorno.nota_fiscal.nome_vendedor}`;
                                            document.getElementById('situacao').innerText = `Situação: ${notaFiscalData.retorno.nota_fiscal.situacao}`;
                                            document.getElementById('descricaoSituacao').innerText = `Descrição da Situação: ${notaFiscalData.retorno.nota_fiscal.descricao_situacao}`;
                                            document.getElementById('obs').innerText = `Observações: ${notaFiscalData.retorno.nota_fiscal.obs}`;
                                            document.getElementById('chaveAcesso').innerText = `Chave de Acesso: ${notaFiscalData.retorno.nota_fiscal.chave_acesso}`;

                                            // Marcadores
                                            const marcadoresList = document.getElementById('marcadores');
                                            notaFiscalData.retorno.nota_fiscal.marcadores.forEach(marcador => {
                                                const li = document.createElement('li');
                                                li.textContent = marcador;
                                                marcadoresList.appendChild(li);
                                            });
                                        })

                                        .catch(error => {
                                            console.error('Erro ao consultar nota fiscal:', error);
                                        });
                                });
                            });

                            // Botão Detalhes do Pedido
                            const btnDetalhesPedido = document.createElement('button');
                            btnDetalhesPedido.innerText = 'Detalhes do Pedido';
                            btnDetalhesPedido.classList.add('btn', 'btn-secondary', 'float-right');
                            btnDetalhesPedido.setAttribute('data-toggle', 'modal');
                            btnDetalhesPedido.setAttribute('data-target', '#modalDetalhesPedido');
                            btnDetalhesPedido.addEventListener('click', () => {
                                const corpoDetalhesPedido = document.getElementById('corpoDetalhesPedido');
                                corpoDetalhesPedido.innerHTML = '';
                                
                                // Adicionar detalhes do pedido ao modal
                                for (const key in data.retorno.pedido) {
                                    if (data.retorno.pedido.hasOwnProperty(key)) {
                                        const p = document.createElement('p');
                                        p.textContent = `${key}: ${data.retorno.pedido[key]}`;
                                        corpoDetalhesPedido.appendChild(p);
                                    }
                                }
                            });

                            // Criar uma linha e célula na tabela para os botões e o quadro de status
                            const row = document.createElement('tr');
                            const cell = document.createElement('td');
                            cell.colSpan = 2; // Ajuste conforme o número de colunas da sua tabela
                            cell.appendChild(statusNotaFiscal); // Adiciona o quadro de status antes dos botões
                            cell.appendChild(btnConsultarNF);
                            cell.appendChild(btnDetalhesPedido);
                            row.appendChild(cell);
                            detalhesTableBody.appendChild(row);
                        })
                        .catch(error => {
                            console.error('Erro ao consultar detalhes do pedido:', error);
                        });
                }
            });


            function createStatusBar(statusList) {
                const statusBar = document.getElementById('statusBar');
                statusBar.innerHTML = ''; // Limpa a barra de status antes de adicionar novos status

                // Exemplo: Adicionando status de forma dinâmica
                statusList.forEach(s => {
                    const statusElement = document.createElement('div');
                    statusElement.classList.add('status-exemplo'); // Adiciona a classe CSS para os exemplos de status
                    statusElement.textContent = s;
                    statusBar.appendChild(statusElement);
                });
            }


            // Manipula o evento de clique no botão "Voltar"
            document.getElementById('voltarBtn').addEventListener('click', function() {
                // Esconder a tabela de detalhes do pedido
                const detalhesContainer = document.getElementById('detalhesPedidoContainer');
                detalhesContainer.style.display = 'none';
                // Exibir a tabela de detalhes do pedido
                const consultarContainer = document.getElementById('consultarPedidoContainer');
                consultarContainer.style.display = 'block';

                // Exibir novamente o modal de lista de pedidos
                $('#listaPedidosModal').modal('show');
            });
        });
    </script>
@endsection

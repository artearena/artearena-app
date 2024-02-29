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

    .head {
        text-align: center;
    }

    .head_1 {
        font-size: 30px;
        font-weight: 600;
        color: #333;
    }

    .head_1 span {
        color: #ff4732;
    }

    .head_2 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-top: 3px;
    }

    ul {
        display: flex;
        margin-top: 80px;
        position: relative; /* Adiciona esta linha */
    }

    ul li {
        list-style: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative; /* Adiciona esta linha */
    }

    ul li .icon {
        font-size: 35px;
        color: #ff4732;
        margin: 0 60px;
    }

    ul li .text {
        font-size: 14px;
        font-weight: 600;
        color: #ff4732;
    }

    /* Progress Div Css  */

    ul li .progress {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: rgba(68, 68, 68, 0.781);
        margin: 14px 0;
        display: grid;
        place-items: center;
        color: #fff;
        position: relative;
        cursor: pointer;
    }

    .progress::after {
        content: " ";
        position: absolute;
        width: 125px;
        height: 5px;
        background-color: rgba(68, 68, 68, 0.781);
        right: 30px;
    }
    .one::after,
    .two::after,
    .three::after,
    .four::after,
    .five::after { /* Ajuste para todos os elementos */
        width: 0;
        height: 0;
    }

    ul li .progress .uil {
        display: none;
    }

    ul li .progress p {
        font-size: 13px;
    }

    /* Active Css  */

    ul li .active {
        background-color: #ff4732;
        display: grid;
        place-items: center;
    }

    li .active::after {
        background-color: #ff4732;
    }

    ul li .active p {
        display: none;
    }

    ul li .active .uil {
        font-size: 20px;
        display: flex;
    }

    /* Responsive Css  */

    @media (max-width: 980px) {
        ul {
            flex-direction: column;
        }

        ul li {
            flex-direction: row;
        }

        ul li .progress {
            margin: 0 30px;
        }

        .progress::after {
            width: 5px;
            height: 55px;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: -1;
        }

        .one::after,
        .two::after,
        .three::after,
        .four::after,
        .five::after { /* Ajuste para todos os elementos */
            height: 0;
        }

        ul li .icon {
            margin: 15px 0;
        }
    }

    @media (max-width: 600px) {
        .head .head_1 {
            font-size: 24px;
        }

        .head .head_2 {
            font-size: 16px;
        }
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="container mt-4">
        <h1>Consulta de Pedidos</h1>
        <div class="form-group">
            <label for="cpf_cnpj">CPF/CNPJ:</label>
            <input type="text" class="form-control" id="cpf_cnpj" placeholder="Digite o CPF/CNPJ">
        </div>
            <button id="consultarPedidosBtn" class="btn btn-primary">Consultar Pedidos</button>
        </div>

        <!-- Modal para exibir a lista de pedidos -->
        <div class="modal fade" id="listaPedidosModal" tabindex="-1" aria-labelledby="listaPedidosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="listaPedidosModalLabel">Lista de Pedidos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="listaPedidosUl"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <ul>
            <li class="one">
                <i class="icon uil uil-capture"></i>
                <div class="progress" id="one">
                    <p>1</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Adicionar ao Carrinho</p>
            </li>
            <li class="two">
                <i class="icon uil uil-clipboard-notes"></i>
                <div class="progress two">
                    <p>2</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Preencher Detalhes</p>
            </li>
            <li class="three">
                <i class="icon uil uil-credit-card"></i>
                <div class="progress three">
                    <p>3</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Efetuar Pagamento</p>
            </li>
            <li class="four">
                <i class="icon uil uil-exchange"></i>
                <div class="progress four">
                    <p>4</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Pedido em Progresso</p>
            </li>
            <li class="five">
                <i class="icon uil uil-map-marker"></i>
                <div class="progress five">
                    <p>5</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Pedido Chegou</p>
            </li>
        </ul>
    </div>
@endsection

@section('extraScript')
<script> console.log('teste')</script>;
<script src="../js/etapas.js"></script>
<script>
    $(document).ready(function() {
        $("#one").click(function() {
            console.log('teste');
            $("#one").addClass("active");
            $(".two, .three, .four, .five").removeClass("active");
        });

        $(".two").click(function() {
            $(".one, .two").addClass("active");
            $(".three, .four, .five").removeClass("active");
        });

        $(".three").click(function() {
            $(".one, .two, .three").addClass("active");
            $(".four, .five").removeClass("active");
        });

        $(".four").click(function() {
            $(".one, .two, .three, .four").addClass("active");
            $(".five").removeClass("active");
        });

        $(".five").click(function() {
            $(".one, .two, .three, .four, .five").addClass("active");
        });
    });
</script>
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
                // Limpe a lista de pedidos antes de exibir os resultados
                document.getElementById('listaPedidosUl').innerHTML = '';

                // Itere sobre os pedidos retornados e adicione-os à lista
                data.retorno.pedidos.forEach(pedido => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        ID: ${pedido.pedido.id}, Data: ${pedido.pedido.data_pedido}, Valor: ${pedido.pedido.valor}, Situação: ${pedido.pedido.situacao}, Codigo de Rastreio: ${pedido.pedido.codigo_rastreamento}, Link de rastreio: ${pedido.pedido.url_rastreamento}
                        <button class="selecionarPedidoBtn btn btn-primary" data-id="${pedido.pedido.id}">Selecionar</button>
                    `;
                    document.getElementById('listaPedidosUl').appendChild(li);
                });

                // Exiba o modal com a lista de pedidos
                $('#listaPedidosModal').modal('show');
            })
            .catch(error => {
                // Manipule erros, se houver
                console.error('Erro ao consultar pedidos:', error);
            });
        });

        // Manipula o evento de clique no botão "Selecionar"
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('selecionarPedidoBtn')) {
                const idPedido = event.target.getAttribute('data-id');
                // Faça alguma ação com o ID do pedido selecionado, como redirecionar para outra página
                console.log('Pedido selecionado:', idPedido);
            }
        });
    });
</script>

    
@endsection

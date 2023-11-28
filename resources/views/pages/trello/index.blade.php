@extends('layout.main')

@section('title')
  Listagem de Cards
@endsection

@section('style')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<style>
    /* Estilos CSS para melhorar a aparência */
    /* Você pode personalizar isso conforme necessário */
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap');
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }
    /* Estilos */

    .board {
        display: flex;
        gap: 10px;
        overflow-x: auto; /* Para permitir rolagem horizontal, se necessário */
    }
    .list {
        flex: 1;
        min-width: 200px;
        background-color: #212529;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 5px;
        margin-left: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: auto;
        overflow-y: auto;
    }
    /* Estilos para a barra de rolagem vertical */
    .list::-webkit-scrollbar {
        width: 5px; /* Largura da barra de rolagem vertical */
    }
    .list::-webkit-scrollbar-track {
        background-color: #f1f1f1; /* Cor de fundo da barra de rolagem vertical */
    }
    .list::-webkit-scrollbar-thumb {
        background-color: #888; /* Cor da alça da barra de rolagem vertical */
        border-radius: 2px; /* Cantos arredondados da alça da barra de rolagem vertical */
    }
    .list::-webkit-scrollbar-thumb:hover {
        background-color: #555; /* Cor da alça da barra de rolagem vertical ao passar o mouse */
    }
    /* Estilos para a barra de rolagem horizontal */
    .board::-webkit-scrollbar {
        height: 5px; /* Altura da barra de rolagem horizontal */
    }
    .board::-webkit-scrollbar-track {
        background-color: #f1f1f1; /* Cor de fundo da barra de rolagem horizontal */
    }
    .board::-webkit-scrollbar-thumb {
        background-color: #888; /* Cor da alça da barra de rolagem horizontal */
        border-radius: 2px; /* Cantos arredondados da alça da barra de rolagem horizontal */
    }
    .board::-webkit-scrollbar-thumb:hover {
        background-color: #555; /* Cor da alça da barra de rolagem horizontal ao passar o mouse */
    }
    .list h2 {
        font-size: 14px;
        margin-bottom: 5px;
        text-align: center;
        color: white;
    }
    .card {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 10px;
        margin-bottom: 10px;
    }
    .card-item {
        flex: 1 1 200px; /* Flex reduzido */
        min-width: 200px;  
    }
    strong {
        font-weight: bold;
    }
    span {
        margin-left: 3px;
        font-size: 12px;
    }
    ol, ul {
        padding-left: 0;
    }
    #relatorio {
        background-color: #212529;
        padding: 10px; 
        margin-bottom: 20px; /* Margem inferior aumentada */
    }

    #relatorio .relatorio-card {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        text-align: center;
    }

    #relatorio h2 {
        color: white;
        text-align: center;
    }

    .section {
        display: inline-block;
        width: 200px;
        height: 200px;
        background-color: white;
        padding: 10px;
        text-align: center;
        font-size: 12px;
        font-family: "Roboto Condensed", sans-serif;

    }

    #relatorio #rcontainer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cards-container {
    display: flex;
    overflow-x: auto;
    }

    .card {
    flex: 1 1 200px; 
    border: 1px solid #ccc;
    padding: 10px;
    }

    .card:hover {
    background: #eee; /* efeito hover */
    }
    
    .resumo {
        max-height: 300px; /* altura máxima da div */
        overflow: auto; /* adicionar barra de rolagem caso o conteúdo seja maior */
    }

    .lista-info {
        margin-bottom: 10px; /* espaço entre cada lista-info */
    }
    /* Estilos personalizados para a barra de rolagem */
    .resumo::-webkit-scrollbar {
    width: 8px; /* Largura da barra de rolagem */
    }

    .resumo::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Cor de fundo da área de rolagem */
    }

    .resumo::-webkit-scrollbar-thumb {
    background-color: #888; /* Cor da barra de rolagem */
    border-radius: 4px; /* Raio de borda da barra de rolagem */
    }

    .resumo::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Cor da barra de rolagem ao passar o mouse */
    }
    .section {
        position: relative; /* Define a posição relativa para criar um contexto de posicionamento para .lista-info */
    }
    .resumo{
        max-height: 140px;
    }
    .lista-info {
        top: 0;
        left: 0;
        width: 100%; /* Define a largura como 100% para ocupar todo o espaço horizontal do section */
        max-height: 200px /* Define a altura máxima como 100% para não ultrapassar o section */
        overflow: auto; /* Adiciona uma barra de rolagem caso o conteúdo seja maior que o tamanho do elemento */
    }
    .total-por-lista{
        max-height: 140px;
        overflow: auto; /* Adiciona uma barra de rolagem caso o conteúdo seja maior que o tamanho do elemento */

    }
    .cards-por-usuario{
        max-height: 160px;
        overflow: auto; /* Adiciona uma barra de rolagem caso o conteúdo seja maior que o tamanho do elemento */

    }
</style>
@endsection

@section('content')

<div id="relatorio">

    <h2>Relatório</h2>
    <div id="rcontainer">
        <div class="section">
            Nomes
            <div class="cards-por-usuario">
            </div>
        </div>
        <div class="section">
            Total de cards
            <div class="total-por-lista">
            </div>
        </div>
        <div class="section">
            Atrasados por lista
            <div class="atrasados-por-lista">
            </div>
        </div>

        <div class="section">
            <h3>Resumo</h3>
            <div class="resumo">
                <div class="lista-info">
                <!-- conteúdo gerado dinamicamente será adicionado aqui -->
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<button id="btn-atualizar">Atualizar</button>
<hr>

<div class="container">

    <h1>Sequência de cards</h1>
    
    <div id="cards-atrasados" class="cards-container">
    </div>

    </div>

<hr>


<div id="app">
    <div class="board" id="card-list"></div>
</div>

<script>
    function criarCardElement(card) {
        var li = document.createElement('li');
        li.classList.add('card');
        var a = document.createElement('a');
        a.href = card.shortUrl;
        a.target = '_blank';
        a.style.textDecoration = 'none';
        a.style.color = 'inherit';
        var spanNome = document.createElement('span');
        spanNome.textContent = card.name;
        spanNome.style.fontWeight = 'bold';
        var spanData = document.createElement('span');
        var dataFormatada = moment(card.dataUltimaAtividade).format('DD/MM HH:mm');
        spanData.textContent = dataFormatada;
        spanData.style.fontWeight = 'bold';
        var spanMembros = document.createElement('span');
        if (card.members && card.members.length > 0) {
            var nomesMembros = card.members.map(function (membro) {
                var nomeCompleto = membro.split(' ');
                return nomeCompleto[0];
            });
            spanMembros.textContent = nomesMembros.join(', ');
        } else {
            spanMembros.textContent = 'Nenhum membro atribuído';
        }
        var agora = moment();
        var diff = agora.diff(card.dataUltimaAtividade);
        var spanHoras = document.createElement('span');
        if (diff >= 1000 * 60 * 60 * 24) {
            var dias = Math.floor(diff / (1000 * 60 * 60 * 24));
            spanHoras.innerHTML = '<strong>' + dias + ' ' + (dias > 1 ? 'dias' : 'dia') + ' atrás</strong>';
        } else if (diff >= 1000 * 60 * 60) {
            var horas = Math.floor(diff / (1000 * 60 * 60));
            spanHoras.innerHTML = '<strong>' + horas + ' ' + (horas > 1 ? 'horas' : 'hora') + ' atrás</strong>';
        } else if (diff >= 1000 * 60) {
            var minutos = Math.floor(diff / (1000 * 60));
            spanHoras.innerHTML = '<strong>' + minutos + ' ' + (minutos > 1 ? 'minutos' : 'minuto') + ' atrás</strong>';
        } else if (diff >= 1000) {
            var segundos = Math.floor(diff / 1000);
            spanHoras.innerHTML = '<strong>' + segundos + ' ' + (segundos > 1 ? 'segundos' : 'segundo') + ' atrás</strong>';
        } else {
            spanHoras.innerHTML = '<strong>Agora mesmo</strong>';
        }
        var tipoLista = card.lista;
        if (tipoLista.toLowerCase() === 'esboço fácil' && diff >= 1000 * 60 * 60) {
            spanHoras.style.color = 'red'; 
        } else if (tipoLista.toLowerCase() === 'esboço fácil' && diff < 1000 * 60 * 60) {
            spanHoras.style.color = 'green';
        }
        if (tipoLista.toLowerCase() === 'esboço médio' && diff >= 1000 * 60 * 60 * 2) {
            spanHoras.style.color = 'red';
        } else if (tipoLista.toLowerCase() === 'esboço médio' && diff < 1000 * 60 * 60 * 2) {
            spanHoras.style.color = 'green';
        }
        if (tipoLista.toLowerCase() === 'prioridade' && diff >= 1000 * 60 * 40) {
            spanHoras.style.color = 'red';
        } else if (tipoLista.toLowerCase() === 'prioridade' && diff < 1000 * 60 * 40) {
            spanHoras.style.color = 'green';
        }
        if (tipoLista.toLowerCase() === 'alteração' && diff >= 1000 * 60 * 30) {
            spanHoras.style.color = 'red'; 
        } else if (tipoLista.toLowerCase() === 'alteração' && diff < 1000 * 60 * 30) {
            spanHoras.style.color = 'green';
        }
        if (tipoLista.toLowerCase() === 'novos esboços' && diff >= 1000 * 60 * 30) {
            spanHoras.style.color = 'red';
        } else if (tipoLista.toLowerCase() === 'novos esboços' && diff < 1000 * 60 * 30) {
            spanHoras.style.color = 'green';
        }
        if (tipoLista.toLowerCase() === 'criação/complexo' && diff >= 1000 * 60 * 60 * 24 * 2) {
            spanHoras.style.color = 'red';
        } else if (tipoLista.toLowerCase() === 'criação/complexo' && diff < 1000 * 60 * 60 * 24 * 2) {
            spanHoras.style.color = 'green';  
        }
        if (tipoLista.toLowerCase() === 'em tratativa' && diff >= 1000 * 60 * 60 * 24) {
            spanHoras.style.color = 'red';
        } else if (tipoLista.toLowerCase() === 'em tratativa' && diff < 1000 * 60 * 60 * 24) {
            spanHoras.style.color = 'green';
        }
        if (tipoLista.toLowerCase() === 'vestuários fácil' && diff >= 1000 * 60 * 60 * 2) {
            spanHoras.style.color = 'red';
        } else if (tipoLista.toLowerCase() === 'vestuários fácil' && diff < 1000 * 60 * 60 * 2) {
            spanHoras.style.color = 'green';
        }
        if (tipoLista.toLowerCase() === 'vestuários médio' && diff >= 1000 * 60 * 60 * 4) {
            spanHoras.style.color = 'red';
        } else if (tipoLista.toLowerCase() === 'vestuários médio' && diff < 1000 * 60 * 60 * 4) {
            spanHoras.style.color = 'green'; 
        }
        if (tipoLista.toLowerCase() === 'em andamento' && diff >= 1000 * 60 * 25) {
            spanHoras.style.color = 'red'; 
        } else if (tipoLista.toLowerCase() === 'em andamento' && diff < 1000 * 60 * 25) {
            spanHoras.style.color = 'green';
        }
        a.appendChild(spanNome);
        a.appendChild(document.createElement('br'));
        a.appendChild(spanData);
        a.appendChild(document.createElement('br'));
        a.appendChild(spanMembros);
        a.appendChild(document.createElement('br'));
        a.appendChild(spanHoras);
        li.appendChild(a);
        return li;
    }
    function criarListaDiv(lista, quantidadeCards) {
        var div = document.createElement('div');
        div.classList.add('list');
        var h2 = document.createElement('h2');
        h2.textContent = lista + ' (' + quantidadeCards + ' cards)';
        var subUl = document.createElement('ul');
        return { div, subUl, h2 };
    }
    function formatDate(date) {
        return moment(date).format('DD/MM/YYYY HH:mm');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const btnAtualizar = document.getElementById('btn-atualizar');

        btnAtualizar.addEventListener('click', function() {
            location.reload(true);
        }); 
    });
    // Função para criar o elemento do card
    function createCardElement(card) {
        const cardLink = document.createElement('a');
        cardLink.href = card.shortUrl;
        cardLink.target = "_blank"; // Abrir em uma nova aba

        const cardEl = document.createElement('div');
        cardEl.classList.add('card');

        const nameEl = document.createElement('h3');
        nameEl.textContent = card.name;

        const dateEl = document.createElement('p');
        dateEl.textContent = formatDate(card.dataUltimaAtividade);

        cardEl.appendChild(nameEl);
        cardEl.appendChild(dateEl);

        cardLink.appendChild(cardEl);

        return cardLink;
    }
    const cardsContainer = document.getElementById('cards-atrasados');
    
    function atualizarConteudo(data) {
        var cardList = document.getElementById('card-list');
        data.forEach(function (item) {
            if (
                item.lista !== "Modelos" &&
                item.lista !== "GABRIEL" &&
                item.lista !== "ESBOÇO AGUARDANDO APROVAÇÃO" &&
                item.lista !== "ESBOÇO CONCLUIDO" &&
                item.lista !== "EM TRATATIVA" &&
                item.lista !== "LIGAR"
            ) {
                var { div, subUl, h2 } = criarListaDiv(item.lista, item.cards.length);
                item.cards.forEach(function (card) {
                    var cardElement = criarCardElement(card);
                    subUl.appendChild(cardElement);
                });
                div.appendChild(h2);
                div.appendChild(subUl);
                cardList.appendChild(div);
            }
        });
    }
    function listarNomesContagem(data) {
        const contagemMembros = contarCardsPorMembro(data);

        const cardsPorUsuario = document.querySelector('.cards-por-usuario');

        for (const membro in contagemMembros) {
            const nome = membro.split(' ')[0]; // Obter apenas o primeiro nome
            const contagem = contagemMembros[membro];

            const nomeContagem = document.createElement('div');
            nomeContagem.textContent = `${nome}: ${contagem}`;

            cardsPorUsuario.appendChild(nomeContagem);
        }
        }

        function contarCardsPorMembro(data) {
        const contagemMembros = {};
        for (const lista in data) {
            if (
            ["Modelos", "GABRIEL", "ESBOÇO AGUARDANDO APROVAÇÃO", "ESBOÇO CONCLUIDO", 'LIGAR', 'EM TRATATIVA'].includes(
                lista
            )
            console.log(lista);

            ) {
            continue;
            }
            const cards = data[lista];
            cards.forEach((card) => {
            card.members.forEach((membro) => {
                if (!contagemMembros[membro]) {
                contagemMembros[membro] = 0;
                }
                contagemMembros[membro]++;
            });
            });
        }
        return contagemMembros;
        }

        function calcularInfoPorLista(data) {
            const regrasAtraso = {
                'esboço fácil': 1000 * 60 * 60,
                'esboço médio': 1000 * 60 * 60 * 2,
                'prioridade': 1000 * 60 * 40,
                'alteração': 1000 * 60 * 30,
                'novos esboços': 1000 * 60 * 30,
                'criação/complexo': 1000 * 60 * 60 * 24 * 2,
                'em tratativa': 1000 * 60 * 60 * 24,
                'vestuários fácil': 1000 * 60 * 60 * 2,
                'vestuários médio': 1000 * 60 * 60 * 4,
                'em andamento': 1000 * 60 * 25,
            };

            const infoGeral = {
                totalCardsGeral: 0,
                cardsAtrasadosGeral: 0,
                cardsEmDiaGeral: [],
            };

            const infoPorLista = {};

            // Adicione o console.log para imprimir todas as listas incluídas
            console.log("Listas incluídas:", Object.keys(data));

            for (const lista in data) {
                // Verifique se a lista está na lista de exclusão
                if (!["Modelos", "GABRIEL", "ESBOÇO AGUARDANDO APROVAÇÃO", "ESBOÇO CONCLUIDO", 'LIGAR'].includes(lista)) {

                    const cards = data[lista];
                    let totalCards = 0;
                    let cardsAtrasados = 0;
                    const cardsEmDia = [];

                    cards.forEach(card => {
                        const tipoLista = card.lista.toLowerCase();
                        const diff = new Date() - new Date(card.dataUltimaAtividade);

                        if (regrasAtraso[tipoLista] && diff >= regrasAtraso[tipoLista]) {
                            cardsAtrasados++;
                        } else {
                            cardsEmDia.push(card);
                        }
                        totalCards++;
                        // Atualize as informações gerais
                        infoGeral.totalCardsGeral++;
                        if (diff >= regrasAtraso[tipoLista]) {
                            infoGeral.cardsAtrasadosGeral++;
                        } else {
                            infoGeral.cardsEmDiaGeral.push(card);
                        }
                    });

                    infoPorLista[lista] = {
                        totalCards,
                        cardsAtrasados,
                        cardsEmDia
                    };
                }
            }

            return {
                infoGeral,
                infoPorLista
            };
        }

    
    var ordemListas = [
        'em andamento',
        'novos esboços',
        'prioridade', 
        'esboço fácil',
        'alteração',
        'esboço médio',
        'vestuários facil',
        'vestuários medios',  
        'CRIAÇÃO/COMPLEXO' 
    ];
    function ordenarListas(a, b) {
        var indiceA = ordemListas.indexOf(a.lista.toLowerCase());
        var indiceB = ordemListas.indexOf(b.lista.toLowerCase());
        if(indiceA === -1) indiceA = Infinity;
        if(indiceB === -1) indiceB = Infinity;
        return indiceA - indiceB;
    }
    function get15CardsMaisAtrasadosExcluindoListas(data) {
        const regrasAtraso = {
            'esboço fácil': 1000 * 60 * 60,
            'esboço médio': 1000 * 60 * 60 * 2,
            'prioridade': 1000 * 60 * 40,
            'alteração': 1000 * 60 * 30,
            'novos esboços': 1000 * 60 * 30,
            'criação/complexo': 1000 * 60 * 60 * 24 * 2,
            'em tratativa': 1000 * 60 * 60 * 24,
            'vestuários fácil': 1000 * 60 * 60 * 2,
            'vestuários médio': 1000 * 60 * 60 * 4,
            'em andamento': 1000 * 60 * 25
        };

        const prioridades = {
            'prioridade': 0,
            'esboço fácil': 1,
            'alteração': 1,
            'vestuários fácil': 2,
            'esboço médio': 2,
            'vestuários médio': 3,
            'criação/complexo': 4
        };

        const listasExcluidas = ["Modelos", "GABRIEL", "ESBOÇO AGUARDANDO APROVAÇÃO", "ESBOÇO CONCLUIDO", "EM TRATATIVA", "NOVOS ESBOÇOS","CRIAÇÃO/COMPLEXO", 'LIGAR'];

        const cardsAtrasados = [];
        const listasNaoExcluidas = [];

        // Obtém todos os cards
        const allCards = Object.values(data).flat();

        allCards.forEach(card => {
            // Calcula o tempo decorrido
            const diff = new Date() - new Date(card.dataUltimaAtividade);
            // Verifica se está atrasado e não está em uma das listas excluídas
            if (diff > regrasAtraso[card.lista.toLowerCase()] && !listasExcluidas.includes(card.lista)) {
                cardsAtrasados.push(card);
                if (!listasNaoExcluidas.includes(card.lista)) {
                    listasNaoExcluidas.push(card.lista);
                }
            }
        });

        // Ordena por prioridade e depois por data
        cardsAtrasados.sort((a, b) => {
            // Calcula diff dentro da função
            const diffA = new Date() - new Date(a.dataUltimaAtividade);
            const diffB = new Date() - new Date(b.dataUltimaAtividade);
            let prioA = prioridades[a.lista.toLowerCase()];
            let prioB = prioridades[b.lista.toLowerCase()];
            // Regra para prioridade máxima
            if (prioA === 1 && diffA > regrasAtraso[a.lista]) prioA = 0;
            if (prioB === 1 && diffB > regrasAtraso[b.lista]) prioB = 0;
            if (prioA !== prioB) {
            return prioA - prioB;
            } else {
            return new Date(a.dataUltimaAtividade) - new Date(b.dataUltimaAtividade);
            }
        });
        // Ordena por prioridade e depois por data
        cardsAtrasados.sort((a, b) => {

        // Calcula diff dentro da função
        const diffA = new Date() - new Date(a.dataUltimaAtividade);
        const diffB = new Date() - new Date(b.dataUltimaAtividade);

        let prioA = prioridades[a.lista.toLowerCase()];
        let prioB = prioridades[b.lista.toLowerCase()];

        // Regra para prioridade máxima
        if(prioA === 1 && diffA > regrasAtraso[a.lista]) prioA = 0;

        if(prioB === 1 && diffB > regrasAtraso[b.lista]) prioB = 0;

        if(prioA !== prioB) {
            return prioA - prioB;
        } else {
            return new Date(a.dataUltimaAtividade) - new Date(b.dataUltimaAtividade); 
        }

        });
        console.log(cardsAtrasados.slice(0, 10));
        // Retorna os 15 primeiros
        return cardsAtrasados.slice(0, 10);
        
    }

    function ordenarCards(a, b) {
        return new Date(a.dataUltimaAtividade) - new Date(b.dataUltimaAtividade);
    }
    fetch('https://artearena.kinghost.net/contagem-cartoes')
        .then(response => response.json())
        .then(data => {
            if (typeof data === 'object' && data !== null) {
                var arrays = [];
                for (var prop in data) {
                    if (data.hasOwnProperty(prop) && Array.isArray(data[prop])) {
                        arrays.push({ lista: prop, cards: data[prop] });
                    }
                }
                console.log(data);
                // Chame a função calcularInfoPorLista para obter as informações
                const { infoGeral, infoPorLista } = calcularInfoPorLista(data);
                const listasExcluidas = ["Modelos", "GABRIEL", "ESBOÇO AGUARDANDO APROVAÇÃO", "ESBOÇO CONCLUIDO", 'LIGAR'];

                // Obtém os cards atrasados
                const lateCards = get15CardsMaisAtrasadosExcluindoListas(data);

                // Container dos cards
                const cardsContainer = document.getElementById('cards-atrasados');
                cardsContainer.classList.add('board');

                // Renderiza os cards
                lateCards.forEach(card => {

                const cardEl = createCardElement(card);

                cardEl.classList.add('card-item');

                cardsContainer.appendChild(cardEl);

                });

                const resumoDiv = document.querySelector('.resumo');

                for (const lista in infoPorLista) {
                    const infoDaLista = infoPorLista[lista];

                    const listaInfoElement = document.createElement('div');
                    listaInfoElement.classList.add('lista-info');

                    const listaElement = document.createElement('p');
                    listaElement.textContent = `Lista: ${lista}`;

                    const totalCardsElement = document.createElement('p');
                    totalCardsElement.textContent = `Número Total de Cards: ${infoDaLista.totalCards}`;

                    const cardsAtrasadosElement = document.createElement('p');
                    cardsAtrasadosElement.textContent = `Número de Cards Atrasados: ${infoDaLista.cardsAtrasados}`;

                    const cardsEmDiaElement = document.createElement('p');
                    cardsEmDiaElement.textContent = `Número de Cards em Dia: ${infoDaLista.cardsEmDia.length}`;

                    listaInfoElement.appendChild(listaElement);
                    listaInfoElement.appendChild(totalCardsElement);
                    listaInfoElement.appendChild(cardsAtrasadosElement);
                    listaInfoElement.appendChild(cardsEmDiaElement);

                    resumoDiv.appendChild(listaInfoElement);
                }
                listarNomesContagem(data);  
                // Crie os elementos para as informações gerais
                const totalCardsGeralElement = document.createElement('div');
                totalCardsGeralElement.textContent = `Número Total de Cards Geral: ${infoGeral.totalCardsGeral}`;

                const cardsAtrasadosGeralElement = document.createElement('div');
                cardsAtrasadosGeralElement.textContent = `Número de Cards Atrasados Geral: ${infoGeral.cardsAtrasadosGeral}`;

                const cardsEmDiaGeral = infoGeral.cardsEmDiaGeral.length;
                // Crie o elemento para o número de cards em dia geral
                const cardsEmDiaGeralElement = document.createElement('div');
                cardsEmDiaGeralElement.textContent = `Número de Cards em Dia Geral: ${cardsEmDiaGeral}`;

                // Anexe os elementos à div "total-por-lista"
                const totalPorListaDiv = document.querySelector('.total-por-lista');
                totalPorListaDiv.appendChild(totalCardsGeralElement);
                totalPorListaDiv.appendChild(cardsAtrasadosGeralElement);
                totalPorListaDiv.appendChild(cardsEmDiaGeralElement);
                // Exiba as informações gerais
               arrays.sort(ordenarListas);
                arrays.forEach(lista => {
                    lista.cards.sort(ordenarCards);
                });
                atualizarConteudo(arrays);
            } else {
                console.error('Os dados não são um objeto ou estão vazios:', data);
            }
        })
        .catch(error => console.error('Erro na requisição:', error))
</script>
@endsection
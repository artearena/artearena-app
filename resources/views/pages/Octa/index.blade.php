@extends('layout.main')

@section('title')
        Listagem de Cards

@endsection

@section('content')

<div id="app">
    <ul>
        @foreach($data as $lista => $cards)
        <li>
            <h2>{{ $lista }}</h2>
            <ul>
                @foreach($cards as $card)
                <li>
                    <strong>Nome:</strong> {{ $card['name'] }}<br>
                    <strong>Data da Última Atividade:</strong> {{ $card['dataUltimaAtividade'] }}
                </li>
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
</div>
<script>
    // Função para criar um elemento li para um card
    function criarCardElement(card) {
        var li = document.createElement('li');
        /* var strongNome = document.createElement('strong');
        strongNome.textContent = 'Nome:'; */
        var spanNome = document.createElement('span');
        spanNome.textContent = card.name;

/*         var strongData = document.createElement('strong');
        strongData.textContent = 'Data da Última Atividade:'; */
        var spanData = document.createElement('span');
        spanData.textContent = card.dataUltimaAtividade;

        li.appendChild(strongNome);
        li.appendChild(spanNome);
        li.appendChild(document.createElement('br'));
        li.appendChild(strongData);
        li.appendChild(spanData);

        return li;
    }

    // Função para atualizar o conteúdo da página com os dados retornados
    function atualizarConteudo(data) {
        var cardList = document.getElementById('card-list');

        data.forEach(function(item) {
            var li = document.createElement('li');
            var h2 = document.createElement('h2');
            h2.textContent = item.lista;

            var subUl = document.createElement('ul');

            item.cards.forEach(function(card) {
                subUl.appendChild(criarCardElement(card));
            });

            li.appendChild(h2);
            li.appendChild(subUl);
            cardList.appendChild(li);
        });
    }

    // Fazer a requisição AJAX
    fetch('https://artearena.kinghost.net/contagem-cartoes')
        .then(response => response.json())
        .then(data => {
            // Chame a função para atualizar o conteúdo da página com os dados retornados
            atualizarConteudo(data);
        })
        .catch(error => console.error('Erro na requisição:', error));
</script>

@endsection

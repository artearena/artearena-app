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
    // Se você deseja fazer uma requisição AJAX para sua API, você pode fazê-lo aqui e, em seguida, atualizar o conteúdo da página com os dados retornados.
    fetch('https://artearena.kinghost.net/contagem-cartoes')
        .then(response => response.json())
        .then(data => {
            // Atualize o conteúdo da página com os dados retornados
            // Por exemplo, você pode criar as listas dinamicamente aqui
        })
        .catch(error => console.error('Erro na requisição:', error));
</script>
@endsection

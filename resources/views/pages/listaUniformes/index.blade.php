@extends('layout.main')
@section('title', 'Lista de informações dos produtos')
@section('content')
    <div class="container">
        <h1>Lista de informações dos produtos</h1>
        <div id="divsContainer">
            @foreach ($pedido->produtos as $produto)
                <div class="divProduto">
                    <h2>{{ $produto->nome }}</h2>
                    <form id="cadastroForm{{ $produto->nome }}">
                        @foreach ($produto->campos as $campo)
                            <div class="form-group">
                                <label for="{{ $campo->nome }}">{{ $campo->label }}:</label>
                                <input type="text" class="form-control" id="{{ $campo->nome }}" name="{{ $campo->nome }}">
                            </div>
                        @endforeach
                    </form>
                </div>
            @endforeach
        </div>
        <button type="button" onclick="adicionarDivUniforme()" class="btn btn-primary">Adicionar Uniforme</button>
        <button type="button" onclick="adicionarDivChineloDedo()" class="btn btn-primary">Adicionar Chinelo de Dedo</button>
        <button type="button" onclick="adicionarDivChineloSlide()" class="btn btn-primary">Adicionar Chinelo Slide</button>
    </div>
    <script>
        function adicionarDivUniforme() {
            var divProduto = document.createElement('div');
            divProduto.className = 'divProduto';
            divProduto.innerHTML = document.getElementsByClassName('divProduto')[0].innerHTML;
            document.getElementById('divsContainer').appendChild(divProduto);
        }
        function adicionarDivChineloDedo() {
            var divProduto = document.createElement('div');
            divProduto.className = 'divProduto';
            divProduto.innerHTML = document.getElementsByClassName('divProduto')[1].innerHTML;
            document.getElementById('divsContainer').appendChild(divProduto);
        }
        function adicionarDivChineloSlide() {
            var divProduto = document.createElement('div');
            divProduto.className = 'divProduto';
            divProduto.innerHTML = document.getElementsByClassName('divProduto')[2].innerHTML;
            document.getElementById('divsContainer').appendChild(divProduto);
        }
    </script>
@endsection
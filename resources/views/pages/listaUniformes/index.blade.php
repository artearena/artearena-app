@extends('layout.main')
@section('title', 'Lista de informações dos produtos')
@section('content')
    <div class="container">
        <h1>Lista de informações dos produtos</h1>
        <div id="divsContainer">
            <div class="divProduto" id="divProdutoTemplate">
                <h2></h2>
                <form>
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="text" class="form-control" name="quantidade" value="">
                    </div>
                    <div class="form-group">
                        <label for="tamanho">Tamanho:</label>
                        <input type="text" class="form-control" name="tamanho" value="">
                    </div>
                    <div class="form-group d-none" id="divCor">
                        <label for="cor">Cor:</label>
                        <input type="text" class="form-control" name="cor" value="">
                    </div>
                </form>
            </div>
        </div>
        <button type="button" onclick="adicionarProduto()" class="btn btn-primary">Adicionar Produto</button>
        <button type="button" onclick="confirmarListaUniforme()" class="btn btn-primary">Confirmar</button>
    </div>

    <script>
        function adicionarProduto() {
            var divProdutoTemplate = document.getElementById('divProdutoTemplate');
            var divProduto = divProdutoTemplate.cloneNode(true);
            divProduto.id = '';
            divProduto.classList.remove('d-none');
            document.getElementById('divsContainer').appendChild(divProduto);
        }

        function confirmarListaUniforme() {
            var divProdutos = document.getElementsByClassName('divProduto');
            var produtos = [];

            for (var i = 0; i < divProdutos.length; i++) {
                var divProduto = divProdutos[i];
                var produto = {
                    nome: divProduto.querySelector('h2').textContent,
                    quantidade: divProduto.querySelector('input[name="quantidade"]').value,
                    tamanho: divProduto.querySelector('input[name="tamanho"]').value,
                    cor: divProduto.querySelector('input[name="cor"]').value
                };
                produtos.push(produto);
            }

            // Exemplo de exibição dos produtos no console
            console.log(produtos);

            // Aqui você pode enviar os dados dos produtos para o servidor ou realizar outras ações necessárias
        }
    </script>
@endsection
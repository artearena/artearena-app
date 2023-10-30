@extends('layout.main')
@section('title', 'Lista de informações dos produtos')
@section('content')
    <div class="container">
        <h1>Lista de informações dos produtos</h1>
        <div id="divsContainer">
            <div class="divProduto">
                <form id="cadastroForm">
                    <div class="form-group">
                        <label for="pacote">Pacote:</label>
                        <select class="form-control" id="pacote" name="pacote">
                            <option value="start">Start</option>
                            <option value="prata">Prata</option>
                            <option value="ouro">Ouro</option>
                            <option value="diamante">Diamante</option>
                            <option value="premium">Premium</option>
                            <option value="profissional">Profissional</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Uniforme:</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="camisa" name="uniforme" value="camisa">
                            <label class="form-check-label" for="camisa">Camisa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="calcao" name="uniforme" value="calcao">
                            <label class="form-check-label" for="calcao">Calção</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="meiao" name="uniforme" value="meiao">
                            <label class="form-check-label" for="meiao">Meião</label>
                        </div>
                    </div>
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Quantidade</th>
                                <th>Tamanho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="nome" value=""></td>
                                <td><input type="text" class="form-control" name="quantidade" value=""></td>
                                <td><input type="text" class="form-control" name="tamanho" value=""></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <button type="button" onclick="adicionarDivProduto()" class="btn btn-primary">Adicionar Produto</button>
    </div>
    <script>
        function adicionarDivProduto() {
            console.log(adicionado);
            var divProduto = document.createElement('div');
            divProduto.className = 'divProduto';
            divProduto.innerHTML = document.getElementsByClassName('divProduto')[0].innerHTML;
            document.getElementById('divsContainer').appendChild(divProduto);
        }
    </script>
@endsection
@extends('layout.main')
@section('title', 'Lista de informações dos produtos')
@section('content')
    <div class="container">
        <h1>Lista de informações dos produtos</h1>
        <div id="divsContainer">
            <div class="divProduto">
                <h2>Uniformes</h2>
                <form id="cadastroFormUniforme">
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
            <div class="divProduto">
                <h2>Chinelos de Dedo</h2>
                <form id="cadastroFormChineloDedo">
                    <div class="form-group">
                        <label for="marcaChineloDedo">Marca:</label>
                        <input type="text" class="form-control" id="marcaChineloDedo" name="marcaChineloDedo">
                    </div>
                    <div class="form-group">
                        <label for="corChineloDedo">Cor:</label>
                        <input type="text" class="form-control" id="corChineloDedo" name="corChineloDedo">
                    </div>
                    <div class="form-group">
                        <label for="tamanhoChineloDedo">Tamanho:</label>
                        <input type="text" class="form-control" id="tamanhoChineloDedo" name="tamanhoChineloDedo">
                    </div>
                </form>
            </div>
            <div class="divProduto">
                <h2>Chinelos Slides</h2>
                <form id="cadastroFormChineloSlide">
                    <div class="form-group">
                        <label for="marcaChineloSlide">Marca:</label>
                        <input type="text" class="form-control" id="marcaChineloSlide" name="marcaChineloSlide">
                    </div>
                    <div class="form-group">
                        <label for="corChineloSlide">Cor:</label>
                        <input type="text" class="form-control" id="corChineloSlide" name="corChineloSlide">
                    </div>
                    <div class="form-group">
                        <label for="tamanhoChineloSlide">Tamanho:</label>
                        <input type="text" class="form-control" id="tamanhoChineloSlide" name="tamanhoChineloSlide">
                    </div>
                </form>
            </div>
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
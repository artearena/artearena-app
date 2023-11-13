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
                    <button type="button" onclick="adicionarLinhaUniforme()" class="btn btn-primary">Adicionar Linha</button>
                </form>
            </div>
            <div class="divProduto">
                <h2>Chinelos de Dedo</h2>
                <form id="cadastroFormChineloDedo">
                    <div class="form-group">
                        <label for="corChineloDedo">Cor:</label>
                        <input type="text" class="form-control" id="corChineloDedo" name="corChineloDedo">
                    </div>
                    <div class="form-group">
                        <label for="tamanhoChineloDedo">Tamanho:</label>
                        <input type="text" class="form-control" id="tamanhoChineloDedo" name="tamanhoChineloDedo">
                    </div>
                    <button type="button" onclick="adicionarLinhaChineloDedo()" class="btn btn-primary">Adicionar Linha</button>
                </form>
            </div>
            <div class="divProduto">
                <h2>Chinelos Slides</h2>
                <form id="cadastroFormChineloSlide">
                    <div class="form-group">
                        <label for="corChineloSlide">Cor:</label>
                        <input type="text" class="form-control" id="corChineloSlide" name="corChineloSlide">
                    </div>
                    <div class="form-group">
                        <label for="tamanhoChineloSlide">Tamanho:</label>
                        <input type="text" class="form-control" id="tamanhoChineloSlide" name="tamanhoChineloSlide">
                    </div>
                    <button type="button" onclick="adicionarLinhaChineloSlide()" class="btn btn-primary">Adicionar Linha</button>
                </form>
            </div>
        </div>
        <button type="button" onclick="confirmarListaUniforme()" class="btn btn-primary">Confirmar</button>
    </div>
    <script>
        function adicionarLinhaUniforme() {
            var tabela = document.querySelector('#cadastroFormUniforme table');
            var tbody = tabela.querySelector('tbody');
            var tr = document.createElement('tr');
            var tdNome = document.createElement('td');
            var tdQuantidade = document.createElement('td');
            var tdTamanho = document.createElement('td');
            var inputNome = document.createElement('input');
            inputNome.type = 'text';
            inputNome.className = 'form-control';
            inputNome.name = 'nome[]';
            var inputQuantidade = document.createElement('input');
            inputQuantidade.type = 'text';
            inputQuantidade.className = 'form-control';
            inputQuantidade.name = 'quantidade[]';
            var inputTamanho = document.createElement('input');
            inputTamanho.type = 'text';
            inputTamanho.className = 'form-control';
            inputTamanho.name = 'tamanho[]';
            tdNome.appendChild(inputNome);
            tdQuantidade.appendChild(inputQuantidade);
            tdTamanho.appendChild(inputTamanho);
            tr.appendChild(tdNome);
            tr.appendChild(tdQuantidade);
            tr.appendChild(tdTamanho);
            tbody.appendChild(tr);
        }

        function adicionarLinhaChineloDedo() {
            var tabela = document.querySelector('#cadastroFormChineloDedo table');
            var tbody = tabela.querySelector('tbody');
            var tr = document.createElement('tr');
            var tdCor = document.createElement('td');
            var tdTamanho = document.createElement('td');
            var inputCor = document.createElement('input');
            inputCor.type = 'text';
            inputCor.className = 'form-control';
            inputCor.name = 'corChineloDedo[]';
            var inputTamanho = document.createElement('input');
            inputTamanho.type = 'text';
            inputTamanho.className = 'form-control';
            inputTamanho.name = 'tamanhoChineloDedo[]';
            tdCor.appendChild(inputCor);
            tdTamanho.appendChild(inputTamanho);
            tr.appendChild(tdCor);
            tr.appendChild(tdTamanho);
            tbody.appendChild(tr);
        }

        function adicionarLinhaChineloSlide() {
            var tabela = document.querySelector('#cadastroFormChineloSlide table');
            var tbody = tabela.querySelector('tbody');
            var tr = document.createElement('tr');
            var tdCor = document.createElement('td');
            var tdTamanho = document.createElement('td');
            var inputCor = document.createElement('input');
            inputCor.type = 'text';
            inputCor.className = 'form-control';
            inputCor.name = 'corChineloSlide[]';
            var inputTamanho = document.createElement('input');
            inputTamanho.type = 'text';
            inputTamanho.className = 'form-control';
            inputTamanho.name = 'tamanhoChineloSlide[]';
            tdCor.appendChild(inputCor);
            tdTamanho.appendChild(inputTamanho);
            tr.appendChild(tdCor);
            tr.appendChild(tdTamanho);
            tbody.appendChild(tr);
        }

        function confirmarListaUniforme() {
            // Lógica para confirmar a lista de uniformes
        }
    </script>
@endsection

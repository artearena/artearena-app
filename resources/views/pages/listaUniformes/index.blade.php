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
        <button type="button" onclick="confirmarListaUniforme()" class="btn btn-primary">Confirmar</button>

  <!--       <button type="button" onclick="adicionarDivUniforme()" class="btn btn-primary">Adicionar Uniforme</button>
        <button type="button" onclick="adicionarDivChineloDedo()" class="btn btn-primary">Adicionar Chinelo de Dedo</button>
        <button type="button" onclick="adicionarDivChineloSlide()" class="btn btn-primary">Adicionar Chinelo Slide</button>
     -->
        </div>
        <script>
            function adicionarDivUniforme(produtos) {
                var divProduto = document.createElement('div');
                divProduto.className = 'divProduto';
                divProduto.innerHTML = document.getElementsByClassName('divProduto')[0].innerHTML;

                var divContainer = document.getElementById('divsContainer');
                for (var i = 0; i < produtos.length; i++) {
                    var cloneDivProduto = divProduto.cloneNode(true);
                    cloneDivProduto.querySelector('h2').textContent = produtos[i].nome;
                    cloneDivProduto.querySelectorAll('.form-group input')[0].value = produtos[i].quantidade;
                    cloneDivProduto.querySelectorAll('.form-group input')[1].value = produtos[i].tamanho;
                    divContainer.appendChild(cloneDivProduto);
                }
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

            // Verifica o nome do produto e adiciona a div correspondente
            function adicionarDivProduto(nome) {
                var nomeLowerCase = nome.toLowerCase();
                if (nomeLowerCase.includes('uniforme') || nomeLowerCase.includes('camisa') || nomeLowerCase.includes('camiseta') || nomeLowerCase.includes('short')) {
                    adicionarDivUniforme();
                } else if (nomeLowerCase.includes('chinelo dedo')) {
                    adicionarDivChineloDedo();
                } else if (nomeLowerCase.includes('chinelo slide')) {
                    adicionarDivChineloSlide();
                }
            }
        </script>
        <script>
    var produtos = [
        { nome: 'Camiseta x', quantidade: 2, tamanho: 'M' },
        { nome: 'Camiseta y', quantidade: 3, tamanho: 'G' },
        { nome: 'Chinelo Dedo z', quantidade: 1, tamanho: '40' },
        { nome: 'Uniforme 2', quantidade: 1, tamanho: 'S' },
        { nome: 'Short 1', quantidade: 2, tamanho: 'L' }
    ];

    adicionarDivUniforme(produtos);
    adicionarDivChineloDedo();
    adicionarDivChineloSlide();
</script>
@endsection
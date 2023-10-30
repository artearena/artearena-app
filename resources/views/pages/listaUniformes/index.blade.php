@extends('layout.main')
@section('title', 'Lista de informações dos produtos')
@section('content')
    <div class="container">
        <h1>Lista de Uniformes</h1>
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
            <table id="registrosTable" class="table mt-4">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Tamanho</th>
                    </tr>
                </thead>
                <tbody id="registrosTableBody">
                </tbody>
            </table>
        </form>
    </div>
    <script>
        var registros = [];
        function adicionarRegistro() {
            var uniforme = document.getElementById('uniforme').value;
            var quantidade = document.getElementById('quantidade').value;
            var tamanho = document.getElementById('tamanho').value;
            var registro = {
                uniforme: uniforme,
                quantidade: quantidade,
                tamanho: tamanho
            };
            registros.push(registro);
            atualizarTabela();
            limparCampos();
        }
        function atualizarTabela() {
            var tabela = document.getElementById('registrosTableBody');
            tabela.innerHTML = '';
            for (var i = 0; i < registros.length; i++) {
                var registro = registros[i];
                var tr = document.createElement('tr');
                var tdUniforme = document.createElement('td');
                tdUniforme.innerHTML = '<input type="text" class="form-control" value="' + registro.uniforme + '">';
                tr.appendChild(tdUniforme);
                var tdQuantidade = document.createElement('td');
                tdQuantidade.innerHTML = '<input type="text" class="form-control" value="' + registro.quantidade + '">';
                tr.appendChild(tdQuantidade);
                var tdTamanho = document.createElement('td');
                tdTamanho.innerHTML = '<input type="text" class="form-control" value="' + registro.tamanho + '">';
                tr.appendChild(tdTamanho);
                tabela.appendChild(tr);
            }
        }
        function limparCampos() {
            document.getElementById('uniforme').value = '';
            document.getElementById('quantidade').value = '';
            document.getElementById('tamanho').value = '';
        }
    </script>
@endsection
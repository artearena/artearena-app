@extends('layout.main')
@section('title', 'Cadastro pessoal')
@section('content')
    <div class="container">
        <h1>Cadastro pessoal</h1>
        <form id="cadastroForm">
            <table id="registrosTable" class="table mt-4">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody id="registrosTableBody">
                </tbody>
            </table>
            <div class="form-group">
                <label for="produto">Produto:</label>
                <input type="text" class="form-control" id="produto" name="produto">
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="text" class="form-control" id="quantidade" name="quantidade">
            </div>
            <button type="button" onclick="adicionarRegistro()" class="btn btn-primary">Adicionar Registro</button>
        </form>
    </div>
    <script>
        var registros = [];

        function adicionarRegistro() {
            var produto = document.getElementById('produto').value;
            var quantidade = document.getElementById('quantidade').value;

            var registro = {
                produto: produto,
                quantidade: quantidade
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

                var tdProduto = document.createElement('td');
                tdProduto.innerHTML = '<input type="text" class="form-control" value="' + registro.produto + '">';
                tr.appendChild(tdProduto);

                var tdQuantidade = document.createElement('td');
                tdQuantidade.innerHTML = '<input type="text" class="form-control" value="' + registro.quantidade + '">';
                tr.appendChild(tdQuantidade);

                tabela.appendChild(tr);
            }
        }

        function limparCampos() {
            document.getElementById('produto').value = '';
            document.getElementById('quantidade').value = '';
        }
    </script>
@endsection
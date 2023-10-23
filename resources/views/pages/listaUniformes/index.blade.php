@extends('layout.main')
@section('title', 'Cadastro pessoal')
@section('content')
    <div class="container">
        <h1>Cadastro pessoal</h1>
        <form id="cadastroForm">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select class="form-control" id="sexo" name="sexo">
                    <option value="feminino">Feminino</option>
                    <option value="masculino">Masculino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" class="form-control" id="numero" name="numero">
            </div>
            <div class="form-group">
                <label for="tamanho">Tamanho:</label>
                <input type="text" class="form-control" id="tamanho" name="tamanho">
            </div>
            <button type="button" onclick="adicionarRegistro()" class="btn btn-primary">Adicionar Registro</button>
        </form>

        <table id="registrosTable" class="table mt-4">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Número</th>
                    <th>Tamanho</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="registrosTableBody">
            </tbody>
        </table>
    </div>

    <script>
        var registros = [];

        function adicionarRegistro() {
            var nome = document.getElementById('nome').value;
            var sexo = document.getElementById('sexo').value;
            var numero = document.getElementById('numero').value;
            var tamanho = document.getElementById('tamanho').value;

            var registro = {
                nome: nome,
                sexo: sexo,
                numero: numero,
                tamanho: tamanho
            };

            registros.push(registro);

            atualizarTabela();
            limparCampos();
        }

        function editarRegistro(index) {
            var registro = registros[index];

            document.getElementById('nome').value = registro.nome;
            document.getElementById('sexo').value = registro.sexo;
            document.getElementById('numero').value = registro.numero;
            document.getElementById('tamanho').value = registro.tamanho;

            registros.splice(index, 1);
            atualizarTabela();
        }

        function removerRegistro(index) {
            registros.splice(index, 1);
            atualizarTabela();
        }

        function atualizarTabela() {
            var tabela = document.getElementById('registrosTableBody');
            tabela.innerHTML = '';

            for (var i = 0; i < registros.length; i++) {
                var registro = registros[i];

                var tr = document.createElement('tr');

                var tdNome = document.createElement('td');
                tdNome.innerHTML = registro.nome;
                tr.appendChild(tdNome);

                var tdSexo = document.createElement('td');
                tdSexo.innerHTML = registro.sexo;
                tr.appendChild(tdSexo);

                var tdNumero = document.createElement('td');
                tdNumero.innerHTML = registro.numero;
                tr.appendChild(tdNumero);

                var tdTamanho = document.createElement('td');
                tdTamanho.innerHTML = registro.tamanho;
                tr.appendChild(tdTamanho);

                var tdAcoes = document.createElement('td');
                var btnEditar = document.createElement('button');
                btnEditar.innerHTML = 'Editar';
                btnEditar.onclick = function() {
                    editarRegistro(i);
                };
                tdAcoes.appendChild(btnEditar);

                var btnRemover = document.createElement('button');
                btnRemover.innerHTML = 'Remover';
                btnRemover.onclick = function() {
                    removerRegistro(i);
                };
                tdAcoes.appendChild(btnRemover);

                tr.appendChild(tdAcoes);

                tabela.appendChild(tr);
            }
        }

        function limparCampos() {
            document.getElementById('nome').value = '';
            document.getElementById('sexo').value = '';
            document.getElementById('numero').value = '';
            document.getElementById('tamanho').value = '';
        }
    </script>
@endsection
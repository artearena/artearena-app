@extends('layout.main')
@section('title')
Consulta de Pedidos
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-10">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <h1>Consulta de Pedidos</h1>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Data</th>
                                <th>Tipo 1</th>
                                <th>Tipo 2</th>
                                <th>Material</th>
                                <th>Medida Linear</th>
                                <th>Observações</th>
                                <th>Status</th>
                                <th>Designer</th>
                                <th>Tipo de Pedido</th>
                                <th>Checagem Final</th>
                                <th>Tiny</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Conexão com o banco de dados
                            $servername = "mysql.sqlhelper.com.br";
                            $username = "sqlhelper";
                            $password = "140477nagy";
                            $dbname = "sqlhelper";

                            // Criar conexão
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Verificar conexão
                            if ($conn->connect_error) {
                                die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                            }

                            // Consulta para recuperar os dados do pedido
                            $sql = "SELECT * FROM tabela_pedido";
                            $result = $conn->query($sql);

                            // Consulta para recuperar os dados dos designers
                            $sql_designer = "SELECT nome FROM table_usuarios WHERE funcao = 2";
                            $result_designer = $conn->query($sql_designer);

                            // Array para armazenar os designers
                            $designers = [];

                            // Recuperar os dados dos designers
                            if ($result_designer->num_rows > 0) {
                                while ($row_designer = $result_designer->fetch_assoc()) {
                                    $designers[] = $row_designer["nome"];
                                }
                            }

                            // Exibir os dados do pedido na tabela
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["idPedido"] . "</td>";
                                    echo "<td>" . date("d/m/Y", strtotime($row["dataPedido"])) . "</td>";
                                    echo "<td><input type='text' class='form-control' value='" . $row["tipo1"] . "' onchange='this.value = event.target.value;' /></td>";
                                    echo "<td><input type='text' class='form-control' value='" . $row["tipo2"] . "' onchange='this.value = event.target.value;' /></td>";
                                    echo "<td><input type='text' class='form-control' value='" . $row["material"] . "' onchange='this.value = event.target.value;' /></td>";
                                    echo "<td><input type='text' class='form-control' value='" . $row["medidaLinear"] . "' onchange='this.value = event.target.value;' /></td>";
                                    echo "<td><input type='text' class='form-control' value='" . $row["observacoes"] . "' onchange='this.value = event.target.value;' /></td>";
                                    echo "<td>
                                            <select class='form-control' onchange='this.value = event.target.value;'>
                                                <option value='Concluído' " . ($row["status"] == "Concluído" ? "selected" : "") . ">Concluído</option>
                                                <option value='Pendente' " . ($row["status"] == "Pendente" ? "selected" : "") . ">Pendente</option>
                                            </select>
                                        </td>";
                                    echo "<td>
                                            <select class='form-control' onchange='this.value = event.target.value;'>";
                                    foreach ($designers as $designer) {
                                        echo "<option value='$designer' " . ($row["designer"] == $designer ? "selected" : "") . ">$designer</option>";
                                    }
                                    echo "</select>
                                        </td>";
                                    echo "<td>
                                            <select class='form-control' onchange='this.value = event.target.value;'>
                                                <option value='Fácil' " . ($row["tipoPedido"] == "Fácil" ? "selected" : "") . ">Fácil</option>
                                                <option value='Médio' " . ($row["tipoPedido"] == "Médio" ? "selected" : "") . ">Médio</option>
                                                <option value='Difícil' " . ($row["tipoPedido"] == "Difícil" ? "selected" : "") . ">Difícil</option>
                                            </select>
                                        </td>";
                                    echo "<td>
                                            <select class='form-control' onchange='this.value = event.target.value;'>
                                                <option value='OK' " . ($row["checagemFinal"] == "OK" ? "selected" : "") . ">OK</option>
                                                <option value='Erro' " . ($row["checagemFinal"] == "Erro" ? "selected" : "") . ">Erro</option>
                                                <option value='Ajustado' " . ($row["checagemFinal"] == "Ajustado" ? "selected" : "") . ">Ajustado</option>
                                                <option value='Pendente' " . ($row["checagemFinal"] == "Pendente" ? "selected" : "") . ">Pendente</option>
                                            </select>
                                        </td>";
                                    echo "<td>" . $row["tiny"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='13'>Nenhum registro encontrado.</td></tr>";
                            }

                            // Fechar conexão com o banco de dados
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary" onclick="showData()">Mostrar Dados</button>
        </div>
    </div>
</div>
@endsection



@section('extraScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
<script>
function showData() {
    var table = document.querySelector('table');
    var rows = table.querySelectorAll('tbody tr');

    rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');

        var data = '';
        cells.forEach(function(cell, index) {
            if (cell.querySelector('input')) {
                data += cell.querySelector('input').value;
            } else if (cell.querySelector('select')) {
                data += cell.querySelector('select').value;
            } else {
                data += cell.textContent;
            }

            if (index < cells.length - 1) {
                data += ' | ';
            }
        });

        console.log(data);
    });
}
</script>

@endsection

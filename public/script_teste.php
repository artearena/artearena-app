<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;

// Configuração
$url = "https://api.tiny.com.br/api2/produtos.pesquisa.php";
$token = "bc3cdea243d8687963fa642580057531456d34fa";

// Importar produtos da API da Tiny
$produtos_totais = [];
for ($pagina = 1; $pagina <= 37; $pagina++) {
    $params = [
        "token" => $token,
        "formato" => "json",
        "pesquisa" => "",
        "pagina" => $pagina
    ];

    $client = new Client();
    $response = $client->request('GET', $url, ['query' => $params]);
    $data = json_decode($response->getBody(), true);
    $produtos_pagina = $data['retorno']['produtos'];
    $produtos_totais = array_merge($produtos_totais, $produtos_pagina);
}

// Conectar ao banco de dados MySQL
$servername = "mysql.arte.app.br";
$username = "arte02";
$password = "140477nagy";
$dbname = "arte02";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o produto já existe
function produto_existe($conn, $produto_id)
{
    $sql_select = "SELECT id FROM produtos WHERE id = ?";
    $stmt = $conn->prepare($sql_select);
    $stmt->bind_param("s", $produto_id);
    $stmt->execute();
    $stmt->store_result();
    $resultado = $stmt->num_rows > 0;
    $stmt->close();
    return $resultado;
}

// Importar produtos no banco de dados
$registros_inseridos = 0;
$excecoes = [
    "AGULHA",
    "Arruela ferro",
    // ...
];

foreach ($produtos_totais as $produto) {
    $produto_info = $produto['produto'];

    // Verificar se o produto já existe
    if (!produto_existe($conn, $produto_info['id'])) {
        // Verificar se o produto é uma exceção
        if (in_array($produto_info['nome'], $excecoes)) {
            // Não inserir
            $excecoes[] = $produto_info['nome'];
        } else {
            // Inserir
            $sql_insert = "INSERT INTO produtos (id, data_criacao, nome, codigo, preco, preco_promocional, unidade, gtin, tipoVariacao, localizacao, preco_custo, preco_custo_medio, situacao) ";
            $sql_insert .= "VALUES ('" . $produto_info['id'] . "', STR_TO_DATE('" . $produto_info['data_criacao'] . "', '%d/%m/%Y %H:%i:%s'), ";
            $sql_insert .= "'" . $produto_info['nome'] . "', '" . $produto_info['codigo'] . "', " . $produto_info['preco'] . ", " . $produto_info['preco_promocional'] . ", ";
            $sql_insert .= "'" . $produto_info['unidade'] . "', '" . $produto_info['gtin'] . "', '" . $produto_info['tipoVariacao'] . "', '" . $produto_info['localizacao'] . "', ";
            $sql_insert .= $produto_info['preco_custo'] . ", " . $produto_info['preco_custo_medio'] . ", '" . $produto_info['situacao'] . "')";

            if ($conn->query($sql_insert) === true) {
                $registros_inseridos++;
            } else {
                $excecoes[] = $conn->error;
            }
        }

        // Exibir o progresso
        echo $registros_inseridos . " registros inseridos...\n";
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
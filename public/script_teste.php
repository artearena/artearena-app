<?php
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

    $url_completa = $url . '?' . http_build_query($params);
    $response = file_get_contents($url_completa);
    $data = json_decode($response, true);
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
$excecoes= [ 
    "AGULHA", 
    "Arruela ferro", 
    "Borda Mastro", 
    "Caixa de papelão (139,21)", 
    "Caneta Esferográfica Azul", 
    "Caneta Esferográfica Preta", 
    "Cola Chinelo", 
    "Cola Instantânea Bond 793 100g", 
    "Cola tecido", 
    "CORDÃO SACOCHILA", 
    "CORDÃO SHORT", 
    "Elástico para roupas 4cm", 
    "Elástico para roupas 5cm", 
    "Espuma densidade 45 - 1,4 x 0,95 - Cinza", 
    "Fio - Branco", 
    "Fio - Preto", 
    "Fita Adesiva 12mm", 
    "Fita Adesiva 45mm", 
    "Fita Adesiva Sublimação - 5 mm x 33 m", 
    "Fita Crepe 18mm", 
    "Folha A4 Sulfite", 
    "Franja 5mm Amarelo", 
    "Franja 5mm Branco", 
    "Franja 5mm Dourado", 
    "Franja 5mm Preto", 
    "Franja 5mm Vermelho", 
    "Haste Bandeira de mesa de Madeira - Dupla", 
    "Haste Bandeira de mesa de Madeira - Individual", 
    "Haste Bandeira de mesa de Madeira - Tripla", 
    "Haste bandeira de mesa de Plástico - Preto", 
    "Ilhós metálico", 
    "Kraft", 
    "Linha - Branco", 
    "Linha - Invisível", 
    "Mosquetão", 
    "Novobag (faixa de capitão)", 
    "Nylon", 
    "Papel Sublimático (Digiprint)", 
    "Papel Sublimático (PLOTAG 300mts)", 
    "Saco de lixo 100L", 
    "Saco de Notas", 
    "Saco Plástico 26x36", 
    "Saco Plástico 32x40", 
    "Saco Plástico 40x50", 
    "Saco Plástico 50x60", 
    "SUBLIMACAO INK JET PAPIJET AMARELO 1 Kg", 
    "SUBLIMACAO INK JET PAPIJET CYAN 1 Kg", 
    "SUBLIMACAO INK JET PAPIJET MAGENTA 1 Kg", 
    "SUBLIMACAO INK JET PAPIJET PRETO 1 kg", 
    "Suporte Bandeira Mesa (Madeira)", 
    "Tecido - Bember", 
    "Tecido - Malha PP", 
    "Tecido Atoalhado", 
    "Tecido Cetim", 
    "Tecido Chimpa", 
    "Tecido Dryfit Colmeia", 
    "Tecido Helanca", 
    "Tecido Oxford", 
    "Tecido Tactel 2 cabos", 
    "Tecido Tactel 4 cabos", 
    "TESOURA", 
    "TINTA IMPRESSORA (ADM) AMARELO", 
    "TINTA IMPRESSORA (ADM) CIANO", 
    "TINTA IMPRESSORA (ADM) MAGENTA", 
    "TINTA IMPRESSORA (ADM) PRETO", 
    "Veda Rosca", 
    "Vedante", 
    "Velcro", 
    "Ziper - Branco", 
    "Zíper - Preto", 
    "Açúcar", 
    "Álcool em Gel", 
    "Café", 
    "Detergente (500 ml)", 
    "Esponja", 
    "Papel Higiênico", 
    "Papel Toalha", 
    "Protetor Auricular", 
    "Sabão em Pó", 
    "Sabonete Líquido", 
    "Veja (Produto de limpeza)" 
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
            $sql_insert .= "VALUES (?, STR_TO_DATE(?, '%d/%m/%Y %H:%i:%s'), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param(
                "ssssddssssdds",
                $produto_info['id'],
                $produto_info['data_criacao'],
                $produto_info['nome'],
                $produto_info['codigo'],
                $produto_info['preco'],
                $produto_info['preco_promocional'],
                $produto_info['unidade'],
                $produto_info['gtin'],
                $produto_info['tipoVariacao'],
                $produto_info['localizacao'],
                $produto_info['preco_custo'],
                $produto_info['preco_custo_medio'],
                $produto_info['situacao']
            );

            if ($stmt->execute()) {
                $registros_inseridos++;
            } else {
                $excecoes[] = $stmt->error;
            }

            $stmt->close();
        }

        // Exibir o progresso
        echo $registros_inseridos . " registros inseridos...\n";
    }
}
foreach ($ids_produtos as $id) {
    obterDadosProduto($conn, $token, $id);
    echo $registros_inseridos . " registro " . $id . "atualizado...\n";
}
// Função para obter os dados do produto e atualizar no banco de dados
function obterDadosProduto($conn, $token, $id) {
    $url = "https://api.tiny.com.br/api2/produto.obter.php";
    $formato = "json";
    
    $params = [
        "token" => $token,
        "id" => $id,
        "formato" => $formato
    ];
    
    $url_completa = $url . '?' . http_build_query($params);
    $response = file_get_contents($url_completa);
    $data = json_decode($response, true);
    
    if ($data['retorno']['status'] == "OK") {
        $produto = $data['retorno']['produto'];
        
        $sql_update = "UPDATE produtos SET altura = ?, largura = ?, comprimento = ?, ncm = ?, anexo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("dddsds", $produto['alturaEmbalagem'], $produto['larguraEmbalagem'], $produto['comprimentoEmbalagem'], $produto['ncm'], $produto['anexos'][0]['anexo'], $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

?>

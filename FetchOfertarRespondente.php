<?php
include_once "Fachada.php";
$dao = $factory->getRespondenteDao();

$limit = $_POST['limit'];
$page = $_POST['page'];
$query = $_POST['query'];
$offset = 1;

if ($_POST['page'] > 1) {
    $offset = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
} else {
    $offset = 0;
}

$respondentes = $dao->buscaPorNomePaginado($query, $limit, $offset);
$total_data = $dao->contaComNome($query);

if (!$respondentes || empty($respondentes)) {
    header('Content-Type: application/json');
    echo json_encode([
        'html3' => '<br><br>Não há registros disponíveis para essa pesquisa',
        'html4' => ''
    ]);
    exit;
}

$output .= " 
    <table class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
        <tr class=\"table-head\">
            <th>Id</th>
            <th>Nome</th>
        </tr>
    ";

foreach ($respondentes as $resp) {
    $output .= "
        <tr onclick=\"marcarLinhaResp(this)\">
            <td>{$resp->getId()}</td>
            <td>{$resp->getNome()}</td>
        ";
    $output .= "</tr>";
}

$output .= "</table>";

// Inicia o buffer de saída
ob_start();

// Inclui o layout da paginação
include_once "LayoutPaginacao2.php";

// Atribui a saída em string numa variável
$output3 = ob_get_clean();

// Constrói array com saída dos dois arquivos PHP
$response = array(
    'html3' => $output,
    'html4' => $output3
);

// Define content-type e envia JSON codificado para ser recebido pelo AJAX
header('Content-Type: application/json');
echo json_encode($response);
?>
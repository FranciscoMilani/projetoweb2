<?php
include_once "Fachada.php";
$dao = $factory->getQuestionarioDao();

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

$questionarios = $dao->buscaPorNomePaginado($query, $limit, $offset);
$total_data = $dao->contaComNome($query);

if (!$questionarios || empty($questionarios)) {
    header('Content-Type: application/json');
    echo json_encode([
        'html1' => '<br><br>Não há registros disponíveis para essa pesquisa',
        'html2' => ''
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

foreach ($questionarios as $quest) {
    $output .= "
        <tr>
            <td>{$quest->getId()}</td>
            <td>{$quest->getNome()}</td>
        ";
    $output .= "</tr>";
}

$output .= "</table>";

// Inicia o buffer de saída
ob_start();

// Inclui o layout da paginação
include_once "LayoutPaginacao.php";

// Atribui a saída em string numa variável
$output2 = ob_get_clean();

// Constrói array com saída dos dois arquivos PHP
$response = array(
    'html1' => $output,
    'html2' => $output2
);

// Define content-type e envia JSON codificado para ser recebido pelo AJAX
header('Content-Type: application/json');
echo json_encode($response);
?>
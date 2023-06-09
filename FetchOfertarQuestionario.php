<?php
include_once "Fachada.php";
session_start();

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

$questionarios = $dao->buscaDoElaboradorPorNomePaginado($query, $_SESSION["id_elaborador"], $limit, $offset);
$total_data = $dao->contaDoElaboradorComNome($query, $_SESSION["id_elaborador"]);

if (!$questionarios || empty($questionarios)) {
    header('Content-Type: application/json');
    echo json_encode([
        'html1' => '<br><br>Nenhum registro foi encontrado',
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
        <tr onclick=\"marcarLinhaQuest(this)\">
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
$output3 = ob_get_clean();

// Constrói array com saída dos dois arquivos PHP
$response = array(
    'html1' => $output,
    'html2' => $output3
);

// Define content-type e envia JSON codificado para ser recebido pelo AJAX
header('Content-Type: application/json');
echo json_encode($response);
?>
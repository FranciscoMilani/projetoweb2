<?php 
session_start();
include_once "Fachada.php";
$dao = $factory->getQuestaoDao();

$limit = $_POST['limit'];
$page = $_POST['page'];
$query = $_POST['query'];
$offset = 1;

if($_POST['page'] > 1)
{
    $offset = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
} else {
    $offset = 0;
}

$questoes = $dao->buscaPorDescricaoPaginado($query, $limit, $offset);
$total_data = $dao->contaComDescricao($query);

if (!$questoes || empty($questoes)){
    header('Content-Type: application/json');
    echo json_encode(['html1' => '<br><br>Nenhum registro foi encontrado',
                      'html2' => '']);
    exit;
}

$output .= "
<table id=\"\" class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
    <tr class=\"table-head\">
        <th>Id</th>
        <th>Descrição</th>
        <th>Tipo</th>
    </tr>";

foreach ($questoes as $questao) {
    $output .= "
                <tr>
                    <td>{$questao->getId()}</td>
                    <td>{$questao->getDescricao()}</td>
                    <td>{$questao->getTipo()}</td>
                </tr>
                ";
}
$output .= "
</table>
";

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
<?php 
session_start();
include_once "Fachada.php";
$dao = $factory->getQuestionarioDao();
$daoElab = $factory->getElaboradorDao();

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

$questionarios = $dao->buscaDoElaboradorPorNomePaginado($query, $_SESSION['id_elaborador'], $limit, $offset);
$total_data = $dao->contaDoElaboradorComNome($query,  $_SESSION['id_elaborador']);

if (!$questionarios || empty($questionarios)){
    header('Content-Type: application/json');
    echo json_encode(['html1' => '<br><br>Não há registros disponíveis para essa pesquisa',
                      'html2' => '']);
    exit;
}

$output .= "
<table id=\"\" class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
    <tr class=\"table-head\">
        <th>Id</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Data Criação</th>
        <th>Nota Aprovação</th>
        <th>Elaborado Por</th>
        <th></th>
    </tr>";

foreach ($questionarios as $quest) {
    $elab = $daoElab->buscaPorId($quest->getElaborador());

    $date = new DateTime($quest->getDataCriacao());
    $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));

    $output .= "
                <tr onclick=\"window.location='VisualizarQuestionario.php?qId={$quest->getId()}'\">
                    <td>{$quest->getId()}</td>
                    <td>{$quest->getNome()}</td>
                    <td>{$quest->getDescricao()}</td>
                    <td>{$formattedDate}</td>
                    <td>{$quest->getNotaAprovacao()}</td>
                    <td>{$elab->getNome()}</td>
                    <td>
                        <a href='ModificaQuestionario.php?id={$quest->getId()}' class='btn btn-info w-100'>
                            <span class='bi bi-clipboard-check-fill p-2'></span>  
                        </a>
                        <a href='ExcluiQuestionario.php?id={$quest->getId()}' class='btn btn-danger w-100 my-1'
                        onclick=\"return confirm('Tem certeza que quer excluir?')\">
                            <span class='bi bi-trash3-fill'></span>
                        </a>
                    </td>
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
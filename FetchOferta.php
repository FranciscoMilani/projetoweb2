<?php 
include_once "Fachada.php";
session_start();

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

$idUsuario = $_SESSION["id_usuario"];
$daoQuestionario = $factory->getQuestionarioDao();
$daoElaborador = $factory->getElaboradorDao();
$daoOferta = $factory->getOfertaDao();
$daoSubmissao = $factory->getSubmissaoDao();

$ofertas = $daoOferta->buscaPorNomePaginado($query, $idUsuario, $limit, $offset);
$total_data = $daoOferta->contaComNome($query, $idUsuario);

if (!$ofertas || empty($ofertas)){
    header('Content-Type: application/json');
    echo json_encode(['html1' => '<br><br>Não há registros disponíveis para essa pesquisa',
                      'html2' => '']);
    exit;
}

if ($ofertas) {
    $output .= "
    <div class=\"table-responsive\">
        <table class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Criado Por</th>
                <th></th>
                <th></th>
            </tr>
    ";

    foreach ($ofertas as $oferta) {
        $quest = $daoQuestionario->buscaPorId($oferta->getQuestionario());
        $elab = $daoElaborador->buscaPorId($quest->getElaborador());
        $date = new DateTime($oferta->getData());
        $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));

        $output .= "
        <tr>
            <td>{$quest->getNome()}</td>
            <td>{$quest->getDescricao()}</td>
            <td>{$formattedDate}</td>
            <td>{$elab->getNome()}</td>
        ";

        // verifica se já foi respondido e troca botão
        $submissao = $daoSubmissao->buscaPorOfertaRespondenteId($oferta->getId(), $idUsuario);

        if (!isset($submissao)){
            
            // botão para Responder
            $output .= "
            <td>
                <a href='RespondeQuestionario.php?ofertaId={$oferta->getId()}&questId={$oferta->getQuestionario()}' class='btn btn-info'>
                    <span class='glyphicon glyphicon-edit'></span> Responder
                </a>
            </td>
            ";

            // botão para ver resposta
            $output .= "
            <td>
                <span class='glyphicon glyphicon-edit btn btn-secondary disabled'>Visualizar</span>
            </td>
            ";

        } else {

            // aviso de já respondido
            $output .= "
            <td>
                <button class='glyphicon glyphicon-edit btn btn-secondary' disabled>Respondido</button>
            </td>
            ";

            // botão para ver resposta
            $output .= "
            <td>
                <a href='VisualizarResultados.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}' class='btn position-relative btn-info'>
                    <span class=\"glyphicon glyphicon-edit\"></span> Visualizar
                </a>
            </td>
            ";
            
        }

        $output .= "
        </tr>
        ";
    }
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
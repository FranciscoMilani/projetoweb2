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
    echo json_encode(['html1' => '<br><br>Nenhum registro foi encontrado',
                      'html2' => '']);
    exit;
}

if ($ofertas) {
    $output .= "
    <div class=\"table-responsive\">
        <table class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
            <thead>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Criado Por</th>
                <th></th>
            </thead>
    ";

    foreach ($ofertas as $oferta) {
        $quest = $daoQuestionario->buscaPorId($oferta->getQuestionario());
        $elab = $daoElaborador->buscaPorId($quest->getElaborador());
        $date = new DateTime($oferta->getData());
        $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));

        // verifica se já foi respondido e troca botão
        $submissao = $daoSubmissao->buscaPorOfertaRespondenteId($oferta->getId(), $idUsuario);

        if (!isset($submissao)){
            $output .= "
            <tr class=\"destacavel\">
                <td onclick=\"location.href='RespondeQuestionario.php?ofertaId={$oferta->getId()}&questId={$oferta->getQuestionario()}'\">{$quest->getNome()}</td>
                <td onclick=\"location.href='RespondeQuestionario.php?ofertaId={$oferta->getId()}&questId={$oferta->getQuestionario()}'\">{$quest->getDescricao()}</td>
                <td onclick=\"location.href='RespondeQuestionario.php?ofertaId={$oferta->getId()}&questId={$oferta->getQuestionario()}'\">{$formattedDate}</td>
                <td onclick=\"location.href='RespondeQuestionario.php?ofertaId={$oferta->getId()}&questId={$oferta->getQuestionario()}'\">{$elab->getNome()}</td>
            ";

            // botão para responder
            $output .= "
            <td class=\"bg-secondary text-white bi bi-clipboard-fill\">
                    <span class=\"text-white d-block\">Responder</span>
            </td>
            ";

        } else {

            $output .= "
            <tr class=\"destacavel\">
                <td onclick=\"location.href='VisualizarResultados.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}'\">{$quest->getNome()}</td>
                <td onclick=\"location.href='VisualizarResultados.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}'\">{$quest->getDescricao()}</td>
                <td onclick=\"location.href='VisualizarResultados.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}'\">{$formattedDate}</td>
                <td onclick=\"location.href='VisualizarResultados.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}'\">{$elab->getNome()}</td>
            ";

            // aviso de já respondido
            $output .= "
            <td class=\"bg-light bi bi-search\">
                <span class=\"d-block\">Visualizar</span>
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
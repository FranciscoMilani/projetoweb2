<?php 
    session_start();
    include_once "Fachada.php";
    $daoQuestionario = $factory->getQuestionarioDao();

    $limit = $_POST['limit'];
    $page = $_POST['page'];
    $query = $_POST['query'];
    $respId = $_POST['respId'];
    $offset = 1;

    if($_POST['page'] > 1)
    {
        $offset = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $offset = 0;    
    }

    $ofertaDao = $factory->getOfertaDao();
    $ofertas = $ofertaDao->ofertasPorUsuario($respId); // ofertas por respondente
    $daoElab = $factory->getElaboradorDao();
    $daoSubmissao = $factory->getSubmissaoDao();

    $ofertasSubm = $ofertaDao->buscaOfertasSubmetidasPorRespondenteEElaborador($query, $respId, $_SESSION['id_elaborador'], $limit, $offset);
    $total_data = $ofertaDao->contaResultadosPorRespondenteEElaboradorComNome($query, $_SESSION['id_elaborador'], $respId);
    
    if (!$ofertasSubm || empty($ofertasSubm)) {
        header('Content-Type: application/json');
        echo json_encode(['html3' => '<br><br>Nenhum registro foi encontrado',
                          'html4' => '']);
        exit;
    }

    $output .= " 
    <table class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
        <thead class=\"table-head\">
            <th>Nome</th>
            <th>Descrição</th>
            <th>Data Submissão</th>
        </thead>
    ";

    foreach ($ofertasSubm as $oferta) {
        $submissao = $daoSubmissao->buscaPorOfertaRespondenteId($oferta->getId(), $respId);
        $quest = $daoQuestionario->buscaPorId($oferta->getQuestionario());
        $elab = $daoElab->buscaPorId($quest->getElaborador());
        $date = new DateTime($oferta->getData());
        $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));

        $output .= "
            <tr class=\"destacavel\">
                <td onclick=\"location.href='AvaliarSubmissao.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}'\">{$quest->getNome()}</td>
                <td onclick=\"location.href='AvaliarSubmissao.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}'\">{$quest->getDescricao()}</td>
                <td onclick=\"location.href='AvaliarSubmissao.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}'\">{$formattedDate}</td>
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
        'html3' => $output,
        'html4' => $output2
    );
        
    // Define content-type e envia JSON codificado para ser recebido pelo AJAX
    header('Content-Type: application/json');
    echo json_encode($response);
?>
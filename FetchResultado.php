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
    $ofertasSubm = $ofertaDao-> buscaOfertasSubmetidasPorRespondenteEElaborador($respId, $_SESSION['id_elaborador']);
    $daoElab = $factory->getElaboradorDao();
    $daoSubmissao = $factory->getSubmissaoDao();

    $questionarios = $daoQuestionario->buscaDoElaboradorPorNomePaginado($query, $_SESSION['id_elaborador'], $limit, $offset);
    $total_data = $daoQuestionario->contaDoElaboradorComNome($query, $_SESSION['id_elaborador']);

    if (!$questionarios || empty($questionarios)){
        header('Content-Type: application/json');
        echo json_encode(['html1' => '<br><br>Não há registros disponíveis para essa pesquisa',
                          'html2' => '']);
        exit;
    }

    $output .= " 
    <table class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
        <thead class=\"table-head\">
            <th>Nome</th>
            <th>Descrição</th>
            <th>Data</th>
            <th>Criado Por</th>
            <th></th>
        </thead>
    ";

    foreach ($ofertasSubm as $oferta) {
        // ignora oferta se ainda não foi respondida
        $submissao = $daoSubmissao->buscaPorOfertaRespondenteId($oferta->getId(), $respId);
        if (!isset($submissao)){
            continue;
        }

        $quest = $daoQuestionario->buscaPorId($oferta->getQuestionario());
        $elab = $daoElab->buscaPorId($quest->getElaborador());
        $date = new DateTime($oferta->getData());
        $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));

        $output .= "
        <tr>
            <td>{$quest->getNome()}</td>
            <td>{$quest->getDescricao()}</td>
            <td>{$formattedDate}</td>
            <td>{$elab->getNome()}</td>

            <td>
                <a href='AvaliarSubmissao.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}' class='btn btn-info'>
                    <span class='glyphicon glyphicon-edit'></span> Avaliar
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
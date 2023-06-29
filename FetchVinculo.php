<?php 
    include_once "Fachada.php";
    $qId = intval($_GET['qId']);
    $dao = $factory->getQuestaoDao();
    $daoQuestionario = $factory->getQuestionarioDao();
    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();
    $questoesQuest = $daoQuestionarioQuestao->buscaQuestoesPorQuestionarioId($qId);

    // pega só questões que não estão vinculadas
    $qstsExcept = $daoQuestionarioQuestao->buscaQuestoesExcetoPorQuestionarioId($qId);


    $idQstsExcept = []; 
    foreach ($qstsExcept as $qsts){
        $idQstsExcept[$qsts->getId()] = $qsts->getId();
    }

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

    $questoes = $dao->buscaPorDescricaoTipoPaginado($query, true, true, true, $limit, $offset);
    $total_data = $dao->contaComDescricao($query);

    if (!$questoes || empty($questoes)){
        header('Content-Type: application/json');
        echo json_encode(['html1' => '<br><br>Não há registros disponíveis para essa pesquisa',
                          'html2' => '']);
        exit;
    }

    $output .= " 
    <script src=\"public/js/vinculo.js\" data-tipo_tabela=\"Vinculo\"></script>
    <table class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
        <thead class=\"table-head\">
            <th>#</th>
            <th>Descrição</th>
            <th>Tipo</th>
            <th>Pontos</th>
            <th>Ordem</th>
            <th>Vínculo</th>
        </thead>
    ";

    foreach ($questoes as $questao){  
        $output .= "           
        <tr class=\"table-row\">
            <td>{$questao->getId()}</td>
            <td>{$questao->getDescricao()}</td>
            <td>{$questao->getTipo()}</td>
            ";


        // está vinculada
        if (!in_array($questao->getId(), $idQstsExcept)){
            $qQuestao = $daoQuestionarioQuestao->buscaPorIds($qId, $questao->getId());
            $output .= "
                <td><input type=\"number\" class=\"form-control ponto-input\" value=\"{$qQuestao->getPontos()}\" disabled></td>
                <td><input type=\"number\" class=\"form-control ordem-input\" value=\"{$qQuestao->getOrdem()}\" disabled></td>
                <td>
                    <button class=\"botao-remove-vinculo btn btn-danger bg-danger-subtle text-black fs-4 bi bi-trash\"></button>
                    <button class=\"botao-vinculo btn btn-success bg-success-subtle text-black fs-4 bi bi-link-45deg\" disabled hidden></button>
                </td>
                
            ";
        } else {
            $output .= "
                <td><input type=\"number\" class=\"form-control ponto-input\"></td>
                <td><input type=\"number\" class=\"form-control ordem-input\"></td>
                <td>
                    <button class=\"botao-vinculo btn btn-success bg-success-subtle text-black fs-4 bi bi-link-45deg\"></button>
                    <button class=\"botao-remove-vinculo btn btn-danger bg-danger-subtle text-black fs-4 bi bi-trash\" disabled hidden></button>
                </td>
                
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
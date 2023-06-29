<?php 
    header('Content-type: application/json');

    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';

    $idQuestao = $_POST['questaoId'];
    $idQuestionario = $_POST['questionarioId'];
    $pontos = $_POST['pontos'];
    $ordem = $_POST['ordem'];

    if ($ordem < 1){
        $response_array['status'] = 'ordem_menor_que_um';
        echo json_encode($response_array);
        exit;
    }

    // valida
    foreach ($_POST as $var){
    if (!isset($var) || empty($var)) {
            $response_array['status'] = 'erro';
            echo json_encode($response_array);
            exit;
        }
    }

    $dao = $factory->getQuestionarioQuestaoDao();
    $ordemArr = $dao->buscaOrdemArray($idQuestionario, $idQuestao);
    $qq = new QuestionarioQuestao($pontos, $ordem, $idQuestionario, $idQuestao);

    if (in_array($ordem, $ordemArr)){
        $response_array['status'] = 'ordem_repetida';
        echo json_encode($response_array);
        exit;
    }

    if ($dao->buscaPorIds($idQuestionario, $idQuestao) != null){
        $response_array['status'] = 'ja_existe';
        echo json_encode($response_array);
        exit;
    } else {
        $dao->insere($qq);
        $response_array['status'] = 'sucesso';
        echo json_encode($response_array);
    }

?>
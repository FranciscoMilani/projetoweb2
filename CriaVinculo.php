<?php 
    header('Content-type: application/json');

    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';

    $idQuestao = $_POST['questaoId'];
    $idQuestionario = $_POST['questionarioId'];
    $pontos = $_POST['pontos'];
    $ordem = $_POST['ordem'];

    // valida
    foreach ($_POST as $var){
    if (!isset($var) || empty($var)) {
            $response_array['status'] = 'erro';
            echo json_encode($response_array);
            exit;
        }
    }

    $dao = $factory->getQuestionarioQuestaoDao();
    $qq = new QuestionarioQuestao($pontos, $ordem, $idQuestionario, $idQuestao);
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
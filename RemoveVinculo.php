<?php 
    header('Content-type: application/json');

    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';

    $idQuestao = $_POST['questaoId'];
    $idQuestionario = $_POST['questionarioId'];

    // valida
    foreach ($_POST as $var){
    if (!isset($var) || empty($var)) {
            $response_array['status'] = 'erro';
            echo json_encode($response_array);
            exit;
        }
    }

    $dao = $factory->getQuestionarioQuestaoDao();

    try{
        $dao->removePorIds($idQuestionario, $idQuestao);
        $response_array['status'] = 'sucesso';
        echo json_encode($response_array);
        exit;
    } catch (Exception $e){
        $response_array['status'] = 'erro';
        echo json_encode($response_array);
        exit;
    }
?>
<?php 
    include_once "Fachada.php";

    $subId = $_GET['submissaoId'];
    $respostaDao = $factory->getRespostaDao();

    foreach ($_POST['respostas'] as $key => $val){
        $nota = round(floatval($val['nota']), 2);
        $obs = $val['comentario'];

        $tempRes = new Resposta($key, null, $nota, $obs, null, null);
        $respostaDao->alteraObservacaoENota($tempRes);
    }

    header('Location: ControleRespondentes.php');
?>
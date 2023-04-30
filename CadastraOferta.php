<?php
include_once "fachada.php";

foreach ($_POST as $variavel){
    if (!isset($variavel) || empty($variavel)) {
        // algo não foi setado
        header('Location: OfertarQuestionario.php');
        exit;
    }
}

$questionarioId = @$_POST["questionario"];
$listRespondentes = @$_POST["respondentesid"];

$dao = $factory->getOfertaDao();
$data = date('Y-m-d', strtotime('now'));
foreach($listRespondentes as $respId){
    $dao->insere(new Oferta(null, $data, intval($questionarioId), intval($respId)));
    header('Location: OfertarQuestionario.php');
}

?>
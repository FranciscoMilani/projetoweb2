<?php
include_once "verificaElaborador.php";
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

var_dump($questionarioId);
var_dump($listRespondentes);
exit;

$daoQuestionario = $factory->getQuestionarioDao();
$daoRespondente = $factory->getRespondenteDao();


if (!$daoQuestionario->buscaPorId($questionarioId)){
    $_SESSION['mensagem'] = 'Questionário não existe';
    header('Location: OfertarQuestionario.php');
    exit;
}

if (!isset($listRespondentes)){
    $_SESSION['mensagem'] = 'Nenhum respondente selecionado';
    header('Location: OfertarQuestionario.php');
    exit;
}

foreach($listRespondentes as $respondenteId){
    if (!$daoRespondente->buscaPorId($respondenteId)){
        $_SESSION['mensagem'] = 'Nenhum respondente selecionado existe';
        header('Location: OfertarQuestionario.php');
        exit;
    }
}


$dao = $factory->getOfertaDao();
$data = date('Y-m-d', strtotime('now'));

foreach($listRespondentes as $respId){
    $_SESSION['mensagem'] = 'Oferta realizada';
    $dao->insere(new Oferta(null, $data, intval($questionarioId), intval($respId)));
    header('Location: OfertarQuestionario.php');
}

header('Location: OfertarQuestionario.php');
exit;

?>
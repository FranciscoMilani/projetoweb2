<?php
include_once "verificaElaborador.php";
include_once "fachada.php";

$mensagem = "";
foreach ($_POST as $variavel){
    if (!isset($variavel) || empty($variavel)) {
        // algo não foi setado
        http_response_code(400);
        echo json_encode(['mensagem' => 'Informação em falta']);
        exit;
    }
}

$questionarioId = @$_POST["questionario"];
$listRespondentes = @$_POST["respondentesid"];

$daoQuestionario = $factory->getQuestionarioDao();
$daoRespondente = $factory->getRespondenteDao();

// Validações
if (!$daoQuestionario->buscaPorId($questionarioId)){
    $_SESSION['mensagem'] = 'Questionário não existe';
    http_response_code(404);
    echo json_encode(['mensagem' => 'Questionário não existe']);
    exit;
}

if (!isset($listRespondentes)){
    $_SESSION['mensagem'] = 'Nenhum respondente selecionado';
    http_response_code(400);
    echo json_encode(['mensagem' => 'Nenhum respondente selecionado']);
    exit;
}

foreach($listRespondentes as $respondenteId){
    if (!$daoRespondente->buscaPorId($respondenteId)){
        $_SESSION['mensagem'] = 'Nenhum respondente selecionado existe';
        http_response_code(403);
        echo json_encode(['mensagem' => 'Nenhum respondente selecionado existe']);
        exit;
    }
}

$dao = $factory->getOfertaDao();
$data = date('Y-m-d', strtotime('now'));

foreach($listRespondentes as $respId){
    $_SESSION['mensagem'] = 'Oferta realizada';
    $dao->insere(new Oferta(null, $data, intval($questionarioId), intval($respId)));
}

http_response_code(200);
echo json_encode(['mensagem' => 'Questionário foi ofertado!']);
exit;

?>
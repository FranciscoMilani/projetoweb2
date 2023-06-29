<?php
include_once "verificaElaborador.php";
include_once "fachada.php";

$questId = @$_GET["id"];

$dao = $factory->getQuestionarioDao();
$daoQq = $factory->getQuestionarioQuestaoDao();
$daoOferta = $factory->getOfertaDao();

try {

    if (!$daoOferta->buscaPorQuestionarioId($questId)){
        $daoQq->removePorQuestionario($questId);
        $dao->removePorId($questId);
        header("Location: ControleQuestionarios.php");
        exit;
    } else {
        header("Location: ControleQuestionarios.php?mensagem=". urlencode("Este questionário já foi ofertado e não pode ser removido"));
        exit;
    }

} catch (\Throwable $th) {
    header("Location: ControleQuestionarios.php?mensagem=". urlencode("Erro ao excluir, este questionário possui vínculos!"));
    exit;
}
?>
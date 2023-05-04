<?php
include_once 'verificaElaborador.php';
include_once "fachada.php";

$id = @$_POST["id"];
$nome = @$_POST['nome'];
$descricao = @$_POST['descricao'];
$notaAprovacao = @$_POST['notaaprovacao'];
$dataCriacao = date("d/m/Y");
$elaboradorId = @$_POST['elaboradorId'];

$daoQ = $factory->getQuestionarioDao();
$daoE = $factory->getElaboradorDao();
$elaborador = $daoE->buscaPorId($elaboradorId);

if (!isset($elaborador)) {
    header('Location: CriacaoQuestionario.php');
    exit;
}

$questionario = new Questionario($id, $nome, $descricao, $dataCriacao, $notaAprovacao, $elaborador);
$daoQ->altera($questionario);

header('Location: VinculoQuestionarioQuestao.php?questionarioId='.$id);
exit;

?>
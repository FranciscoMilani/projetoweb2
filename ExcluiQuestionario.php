<?php
include_once "fachada.php";

$id = @$_GET["id"];

$dao = $factory->getQuestionarioDao();
$dao2 = $factory->getQuestionarioQuestaoDao();

try {
    //exclui vinculo com questoes antes de excluir o questionario
    $dao2->removePorQuestionario($id);
    $dao->removePorId($id);
    header("Location: ControleQuestionarios.php");
    exit;

} catch (\Throwable $th) {
    header("Location: ControleQuestionarios.php?mensagem=Erro ao excluir, este questionário possui vínculos!");
    exit;
}
?>
<?php
include_once "verificaAdmin.php";
include_once "fachada.php";

$id = @$_GET["id"];

$elabDao = $factory->getElaboradorDao();
$questDao = $factory->getQuestionarioDao();

try {
    if (!$questDao->buscaPorElaboradorId($id)){
        $elabDao->removePorId($id);
        header("Location: ControleElaboradores.php");
        exit;
    }
    
    header("Location: ControleElaboradores.php?mensagem=Erro ao excluir, este elaborador possui vínculos!");

} catch (\Throwable $th) {
    header("Location: ControleElaboradores.php?mensagem=Erro ao excluir, este elaborador possui vínculos!");
    exit;
}

?>
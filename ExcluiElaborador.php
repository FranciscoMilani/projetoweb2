<?php
include_once "fachada.php";

$id = @$_GET["id"];

$dao = $factory->getElaboradorDao();
$daoOferta = $factory->getOfertaDao();
$questionarioDao = $factory->getQuestionarioDao();

try {
    $ofertas = $questionarioDao->buscaOfertasPorElaboradorId($id);
    foreach ($ofertas as $o){
        $daoOferta->removePorId($o->getId());
    }

    $dao->removePorId($id);
    header("Location: ControleElaboradores.php");
    
} catch (\Throwable $th) {
    header("Location: ControleElaboradores.php?mensagem=Erro ao excluir, este elaborador possui vínculos!");
    exit;
}

?>
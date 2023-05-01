<?php
include_once "fachada.php";

$id = @$_GET["id"];

$dao = $factory->getElaboradorDao();

try {
    $dao->removePorId($id);
    header("Location: ControleElaboradores.php");
    exit;

} catch (\Throwable $th) {
    header("Location: ControleElaboradores.php?mensagem=Erro ao excluir, este elaborador possui vínculos!");
    exit;
}

?>
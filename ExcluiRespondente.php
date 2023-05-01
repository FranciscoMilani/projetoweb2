<?php
include_once "fachada.php";

$id = @$_GET["id"];
$dao = $factory->getRespondenteDao();

try {
    $dao->removePorId($id);
    header("Location: ControleRespondentes.php");
    exit;

} catch (\Throwable $th) {
    header("Location: ControleRespondentes.php?mensagem=Erro ao excluir, este respondente possui ofertas pendentes!");
    exit;
}
?>
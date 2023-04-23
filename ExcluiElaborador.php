<?php
include_once "fachada.php";

$id = @$_GET["id"];

$elaborador = new Elaborador($id, $login, $senha, $nome, $email, $instituicao, $isAdmin);
$dao = $factory->getElaboradorDao();
$dao->removePorId($id);

header("Location: ControleElaboradores.php");
exit;

?>
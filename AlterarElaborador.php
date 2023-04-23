<?php
include_once "fachada.php";

$id = @$_POST["id"];
$login = @$_POST["login"];
$senha = @$_POST["senha"];
$nome = @$_POST["nome"];
$email = @$_POST["email"];
$instituicao = @$_POST["instituicao"];
$isAdmin = false;

$elaborador = new Elaborador($id,$login, $senha, $nome, $email, $instituicao, $isAdmin);
$dao = $factory->getElaboradorDao();
$dao->altera($elaborador);

header("Location: ControleElaboradores.php");
exit;
?>
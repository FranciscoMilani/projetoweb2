<?php
include_once "fachada.php";

$id = @$_POST["id"];
$login = @$_POST["login"];
$senha = @$_POST["senha"];
$nome = @$_POST["nome"];
$email = @$_POST["email"];
$telefone = @$_POST["telefone"];

$respondente = new Respondente($id,$login, $senha, $nome, $email, $telefone);
$dao = $factory->getRespondenteDao();
$dao->altera($respondente);

header("Location: ControleRespondentes.php");
exit;
?>
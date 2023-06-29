<?php
include_once "fachada.php";
include_once "verificaElaborador.php";

$id = @$_POST["id"];
$login = @$_POST["login"];
$senha = @$_POST["senha"];
$nome = @$_POST["nome"];
$email = @$_POST["email"];
$telefone = @$_POST["telefone"];

$daoRespondente = $factory->getRespondenteDao();
$daoElaborador = $factory->getElaboradorDao();

$mesmoLogin = false;
$userObj = $daoRespondente->buscaPorId($id);
if (!empty($userObj)){
    $mesmoLogin = $login == $userObj->getLogin();
}

$loginExistenteElab = $daoElaborador->buscaPorLogin($login);
$loginExistenteResp = $daoRespondente->buscaPorLogin($login);

if ($mesmoLogin){
    $respondente = new Respondente($id, $login, $senha, $nome, $email, $telefone);
    $daoRespondente->altera($respondente);

    $_SESSION['mensagem'] = 'Cadastro atualizado!';
    header('Location: ModificaRespondente.php?id='.$id);
    exit;
}

if (($loginExistenteElab != null && $login == $loginExistenteElab->getLogin()) 
    || $loginExistenteResp != null && $login == $loginExistenteResp->getLogin()) {

    $_SESSION['mensagem'] = 'Login já existe';
    header('Location: ModificaRespondente.php?id='.$id);
    exit;
} else {
    $respondente = new Respondente($id, $login, $senha, $nome, $email, $telefone);
    $daoRespondente->altera($respondente);

    $_SESSION['mensagem'] = 'Cadastro atualizado!';
    header('Location: ModificaRespondente.php?id='.$id);
    exit;
}
?>
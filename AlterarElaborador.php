<?php
include_once "fachada.php";
include_once "verificaAdmin.php";

$id = @$_POST["id"];
$login = @$_POST["login"];
$senha = @$_POST["senha"];
$nome = @$_POST["nome"];
$email = @$_POST["email"];
$instituicao = @$_POST["instituicao"];

$daoElaborador = $factory->getElaboradorDao();
$daoRespondente = $factory->getRespondenteDao();

$mesmoLogin = false;
$isAdmin = false;
$userObj = $daoElaborador->buscaPorId($id);
if (!empty($userObj)){
    $mesmoLogin = $login == $userObj->getLogin();
    $isAdmin = $userObj->getIsAdmin();
}

$loginExistenteElab = $daoElaborador->buscaPorLogin($login);
$loginExistenteResp = $daoRespondente->buscaPorLogin($login);

if ($mesmoLogin){
    $elaborador = new Elaborador($id, $login, $senha, $nome, $email, $instituicao, $isAdmin);
    $daoElaborador->altera($elaborador);

    $_SESSION['mensagem'] = 'Cadastro atualizado!';
    header('Location: ModificaElaborador.php?id='.$id);
    exit;
}

if (($loginExistenteElab != null && $login == $loginExistenteElab->getLogin()) 
    || $loginExistenteResp != null && $login == $loginExistenteResp->getLogin()) {

    $_SESSION['mensagem'] = 'Login já existe';
    header('Location: ModificaElaborador.php?id='.$id);
    exit;
} else {
    $elaborador = new Elaborador($id, $login, $senha, $nome, $email, $instituicao, $isAdmin);
    $daoElaborador->altera($elaborador);

    $_SESSION['mensagem'] = 'Cadastro atualizado!';
    header('Location: ModificaElaborador.php?id='.$id);
    exit;
}
?>
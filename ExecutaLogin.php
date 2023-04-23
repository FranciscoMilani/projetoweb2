<?php
require 'Fachada.php';

// Inicia sessão 
session_start();

$login = isset($_POST['login']) ? trim(addslashes($_POST['login'])) : false;
$senha = isset($_POST['senha']) ? md5(trim($_POST['senha'])) : false;

if (!$login || !$senha) {
    echo ('Digite login e senha para entrar.');
    exit;
}

$dao = $factory->getRespondenteDao();
$respondente = $dao->buscaPorLogin($login);
$daoElab = $factory->getElaboradorDao();
$elaborador = $daoElab->buscaPorLogin($login);

$problemas = FALSE;
if ($respondente) {
    // Aviso: comparando senha md5 com hash md5. Se inserir direto no banco p/ testes, sem md5, nao vai logar
    if (!strcmp($senha, $respondente->getSenha())) {
        $_SESSION["id_usuario"] = $respondente->getId();
        $_SESSION["nome_usuario"] = stripslashes($respondente->getNome());
        // necessario para mostrar apenas os botoes de cada tipo de usuario na tela de menu
        $_SESSION["is_elaborador"] = FALSE;
        $_SESSION["is_admin"] = FALSE;
        header("Location: Menu.php");
        exit;
    } else {
        $problemas = TRUE;
    }
} else if ($elaborador) {
    if (!strcmp($senha, $elaborador->getSenha())) {
        $_SESSION["id_usuario"] = $elaborador->getId();
        $_SESSION["nome_usuario"] = stripslashes($elaborador->getNome());
        $_SESSION["is_elaborador"] = TRUE;
        $_SESSION["is_admin"] = $elaborador->getIsAdmin();
        
        header("Location: Menu.php");
        exit;
    } else {
        $problemas = TRUE;
    }
} else {
    $problemas = TRUE;
}

if ($problemas == TRUE) {
    header("Location: Index.php");
    exit;
}
?>
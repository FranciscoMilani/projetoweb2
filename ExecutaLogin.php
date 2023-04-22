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

$dao = $factory->getUsuarioDao();
$usuario = $dao->buscaPorLogin($login);
//instanciar mais um dao para elaborador (verificar se essa é a maneira correta de procurar um elaborador)
$daoElab = $factory->getElaboradorDao();
$elaborador = $daoElab->buscaPorLogin($login);

$problemas = FALSE;
if ($usuario) {
    // Aviso: comparando senha md5 com hash md5. Se inserir direto no banco p/ testes, sem md5, nao vai logar
    if (!strcmp($senha, $usuario->getSenha())) {
        $_SESSION["id_usuario"] = $usuario->getId();
        $_SESSION["nome_usuario"] = stripslashes($usuario->getNome());
        //$_SESSION["is_elaborador"] = FALSE;
        $_SESSION["is_admin"] = FALSE;
        header("Location: ListaOfertas.php");
        exit;
    } else {
        $problemas = TRUE;
    }
} else if ($elaborador) {
    if (!strcmp($senha, $elaborador->getSenha())) {
        $_SESSION["id_usuario"] = $elaborador->getId();
        $_SESSION["nome_usuario"] = stripslashes($elaborador->getNome());
        //$_SESSION["is_elaborador"] = TRUE;
        $_SESSION["id_elaborador"] = $elaborador->getId();
        $_SESSION["is_admin"] = $elaborador->getIsAdmin();
        
        header("Location: ListaOfertas.php");
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
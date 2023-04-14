<?php
    require 'Fachada.php';
    $login = isset($_POST['login']) ? trim(addslashes($_POST['login'])) : false;
    $senha = isset($_POST['senha']) ? md5(trim($_POST['senha'])) : false;

    if (!$login || !$senha){
        echo ('Digite login e senha para entrar.');
        exit;
    }
     
    $dao = $factory->getUsuarioDao();
    $usuario = $dao->buscaPorLogin($login);

    $problemas = FALSE;
    if($usuario) {
        // Aviso: comparando senha md5 com hash md5. Se inserir direto no banco p/ testes, sem md5, nao vai logar
        if(!strcmp($senha, $usuario->getSenha())) 
        { 
            $_SESSION["id_usuario"]= $usuario->getId(); 
            $_SESSION["nome_usuario"] = stripslashes($usuario->getNome());  
            header("Location: ListaOfertas.php"); 
            exit; 
        } else {
            $problemas = TRUE; 
        }
    } else {
        $problemas = TRUE; 
    }

    if($problemas==TRUE) {
        header("Location: Index.php"); 
        exit; 
    }
?>
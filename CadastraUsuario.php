<?php 
    include_once 'Fachada.php';

    foreach ($_POST as $variavel){
        if (!isset($variavel) || empty($variavel)) {
            // algo não foi setado
            header('Location: CadastroUsuario.php');
            exit;
        }
    }

    $login = @$_POST["login"];
    $senha = @$_POST["senha"];
    $nome = @$_POST["nome"];
    $email = @$_POST["email"];
    $telefone = @$_POST["telefone"];

    $dao = $factory->getUsuarioDao();
    $loginExistente = $dao->buscaPorLogin($login);

    if ( $loginExistente != null 
         && $login == $loginExistente->getLogin() ) {
        // login duplicado
        header('Location: CadastroUsuario.php');
        exit;
    } else {
        $dao->insere(new Usuario(null, $login, $senha, $nome, $email, $telefone));
    }

?>
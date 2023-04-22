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

    $dao = $factory->getRespondenteDao();
    $loginExistente = $dao->buscaPorLogin($login);

    if ( $loginExistente != null 
         && $login == $loginExistente->getLogin() ) {
        // login duplicado
        header('Location: CadastroUsuario.php');
        exit;
    } else {
        $dao->insere(new Respondente(null, $login, $senha, $nome, $email, $telefone));
        header('Location: Index.php');
    }

?>
<?php 
    include_once 'Fachada.php';

    foreach ($_POST as $variavel){
        if (!isset($variavel) || empty($variavel)) {
            // algo não foi setado
            header('Location: CadastroElaborador.php');
            exit;
        }
    }

    $login = @$_POST["login"];
    $senha = @$_POST["senha"];
    $nome = @$_POST["nome"];
    $email = @$_POST["email"];
    $instituicao = @$_POST["instituicao"];

    $dao = $factory->getElaboradorDao();
    $loginExistente = $dao->buscaPorLogin($login);

    if ( $loginExistente != null 
         && $login == $loginExistente->getLogin() ) {
        // login duplicado
        header('Location: CadastroElaborador.php');
        exit;
    } else {
        $dao->insere(new Elaborador(null, $login, $senha, $nome, $email, $instituicao, false));
    }

?>
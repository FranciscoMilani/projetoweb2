<?php
include_once "fachada.php";
include_once "verificaAdmin.php";

foreach ($_POST as $variavel) {
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
$isAdmin = false;

$dao = $factory->getElaboradorDao();
$loginExistente = $dao->buscaPorLogin($login);

session_start();

try { 

    if ($loginExistente != null && 
        $login == $loginExistente->getLogin()) {
    
        $_SESSION['mensagem'] = 'Login já existe';
        header('Location: CadastroElaborador.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Cadastro efetuado';
        $dao->insere(new Elaborador(null, $login, $senha, $nome, $email, $instituicao, $isAdmin));
        header('Location: CadastroElaborador.php');
        exit;
    }

} catch(Exception $e) {
    $_SESSION['mensagem'] = 'Erro ao cadastrar';
    header('Location: CadastroElaborador.php');
    exit;
}

?>
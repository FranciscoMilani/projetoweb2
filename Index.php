<?php
$titulo = "Página de Login";
include_once 'LayoutHeader.php';
?>

<div class="paginaLogin">
    <div class="form">
        <form id="formId" action="ExecutaLogin.php" method="POST" class="cadastro-form">
            <input type="text" name="login" placeholder="Login" />
            <input type="password" name="senha" placeholder="Senha" />
            <input type="submit" id="btLogin" value="Entrar">
            <p class="msgCadastrar"><a href="CadastroUsuario.php">Criar uma Conta</a></p>
        </form>
    </div>
</div>

<?php
include_once "LayoutFooter.php";
?>
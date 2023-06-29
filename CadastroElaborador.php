<?php
require "verificaAdmin.php";
$titulo = 'Cadastro de Elaboradores';
include_once 'LayoutHeader.php';

?>
<div class="paginaLogin">
    <form action="CadastraElaborador.php" method="POST" class="cadastro-form">
        <label for="nome">Nome</label>
        <input type="text" name="nome" required>
        <label for="login">Login</label>
        <input type="text" name="login" required>
        <label for="senha">Senha</label>
        <input type="password" name="senha" required>
        <label for="email">E-mail</label>
        <input type="email" name="email" placeholder="email_elaborador@email.com" required>
        <label for="telefone">Instituição</label>
        <input type="text" name="instituicao" required>
        <input type="submit" value="Enviar" id="btCadastro">
        <a type="button" onclick="location.href='ControleElaboradores.php'" value="voltar" class="classeVoltar text-center"><i class="bi bi-arrow-left fs-4"></i></a>
        <?php 
        if (isset($_SESSION['mensagem'])) {
            echo "<span class='text-center'>{$_SESSION['mensagem']}</span>";
            unset($_SESSION['mensagem']);
        }
        ?>
    </form>
</div>

<?php
include_once "LayoutFooter.php";
?>
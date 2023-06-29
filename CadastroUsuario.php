<?php
$titulo = 'Cadastro de Usuários';
include_once 'LayoutHeader.php';
?>
<div class="paginaLogin">
    <form action="CadastraUsuario.php" method="POST" class="cadastro-form">
        <label for="nome">Nome</label>
        <input type="text" name="nome" required>
        <label for="login">Login</label>
        <input type="text" name="login" required>
        <label for="senha">Senha</label>
        <input type="password" name="senha" required>
        <label for="email">E-mail</label>
        <input type="email" name="email" placeholder="seu_email@email.com" required>
        <label for="telefone">Telefone</label>
        <input type="tel" name="telefone" placeholder="(00) 12345-6789">
        <input type="submit" value="Enviar" id="btCadastro">
        <a type="button" onclick="location.href='Index.php'" value="voltar" class="classeVoltar text-center"><i class="bi bi-arrow-left fs-4"></i></a>
    </form>
</div>

<?php
include_once "LayoutFooter.php";
?>
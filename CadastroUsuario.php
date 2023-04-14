<?php 
    include_once 'LayoutHeader.php'
?>

<div>
    <h1>Cadastro</h1>
    <form action="CadastraUsuario.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>
        <label for="login">Login:</label>
        <input type="text" name="login" required>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>
        <label for="email">E-mail:</label>
        <input type="email" name="email" placeholder="seu_email@email.com" required>
        <label for="telefone">Telefone:</label>
        <input type="tel" name="telefone" placeholder="(00) 12345-6789">
        <input type="submit" value="Enviar">
    </form>

    <a href="Login.php">Voltar</a>
</div>
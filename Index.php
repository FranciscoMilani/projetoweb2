<?php 
    $titulo = "Página de Login";
    include_once 'LayoutHeader.php';
?>
    <div>
        <h1>Sistema de Questionários</h1>
    </div>
    
    <div>
        <h2>Login</h2>
        <form action="ExecutaLogin.php" method="POST">
            <label for="login">Login:</label>
            <input type="text" name="login" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>
            <input type="submit" value="Entrar">
        </form>
        <a href="CadastroUsuario.php">Cadastre-se</a>
    </div>
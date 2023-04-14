<?php 
    $titulo = "Página de Login";
    include_once 'LayoutHeader.php';
?>
    <div>
        <h1>Login</h1>
        <form action="ExecutaLogin.php" method="POST">
            <label for="login">Login:</label>
            <input type="text" name="login" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>
            <input type="submit" value="Entrar">
        </form>
    </div>
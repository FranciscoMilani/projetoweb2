<?php
$titulo = "Altera Respondente";

include_once "fachada.php";
include "verificaElaborador.php";

$id = @$_GET["id"];

$dao = $factory->getRespondenteDao();
$respondente = $dao->buscaPorId($id);

include_once "LayoutHeader.php";
?>

<section>
    <div class="paginaLogin">
        <form action="AlterarRespondente.php" method="POST" class="cadastro-form">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $respondente->getNome(); ?>" required>
            <label for="login">Login:</label>
            <input type="text" name="login" value="<?php echo $respondente->getLogin(); ?>" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" value="<?php echo $respondente->getSenha(); ?>" required>
            <label for="email">E-mail:</label>
            <input type="email" name="email" placeholder="email_elaborador@email.com" value="<?php echo $respondente->getEmail(); ?>" required>
            <label for="telefone">Telefone:</label>
            <input type="tel" name="telefone" placeholder="(00) 12345-6789" value="<?php echo $respondente->getTelefone(); ?>" required>
            <input type="submit" value="Enviar" id="btCadastro">
            <input type='hidden' name='id' value='<?php echo $respondente->getId(); ?>' />
        </form>
        <input type="button" onclick="location.href='ControleRespondentes.php'" value="Cancelar" class="classeVoltar">
    </div>
</section>

<?php
include_once "LayoutFooter.php";
?>
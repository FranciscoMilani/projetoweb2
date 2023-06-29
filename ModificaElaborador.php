<?php
$titulo = "Altera Elaborador";

include_once "fachada.php";
include "verificaAdmin.php";

$id = @$_GET["id"];

$dao = $factory->getElaboradorDao();
$elaborador = $dao->buscaPorId($id);

include_once "LayoutHeader.php";
?>

<section>
    <div class="paginaLogin">
        <form action="AlterarElaborador.php" method="POST" class="cadastro-form">
            <label for="nome">Nome</label>
            <input type="text" name="nome" value="<?php echo $elaborador->getNome(); ?>" required>
            <label for="login">Login</label>
            <input type="text" name="login" value="<?php echo $elaborador->getLogin(); ?>" required>
            <label for="senha">Senha</label>
            <input type="password" name="senha" required>
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="email_elaborador@email.com"
                value="<?php echo $elaborador->getEmail(); ?>" required>
            <label for="instituicao">Instituição</label>
            <input type="text" name="instituicao" value="<?php echo $elaborador->getInstituicao(); ?>" required>
            <input type="submit" value="Enviar" id="btCadastro">
            <input type='hidden' name='id' value='<?php echo $elaborador->getId(); ?>' />
            <a type="button" onclick="location.href='ControleElaboradores.php'" value="voltar" class="classeVoltar text-center"><i class="bi bi-arrow-left fs-4"></i></a>
            <?php 
            if (isset($_SESSION['mensagem'])) {
                echo "<span class='text-center'>{$_SESSION['mensagem']}</span>";
                unset($_SESSION['mensagem']);
            }
            ?>
        </form>
    </div>
</section>

<?php
include_once "LayoutFooter.php";
?>
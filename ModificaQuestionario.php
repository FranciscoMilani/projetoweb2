<?php
$titulo = "Editar Questionário";

include_once "fachada.php";
include_once 'verificaElaborador.php';
$id = @$_GET["id"];

$dao = $factory->getQuestionarioDao();
$questionario = $dao->buscaPorId($id);

include_once "LayoutHeader.php";

?>
<div class="form">
    <form id="formId" action="AlterarQuestionario.php" method="POST" class="cadastro-form">
        <label for="nome">Título</label>
        <input type="text" name="nome" placeholder="Título do questionário..."
            value="<?php echo $questionario->getNome(); ?>" required />

        <label for="descricao">Descrição</label>
        <textarea style="resize:none;" name="descricao" cols="30" rows="10" placeholder="Descrição do questionário..." required><?= $questionario->getDescricao() ?></textarea>

        <label for="notaaprovacao">Nota de aprovação</label>
        <input type="number" name="notaaprovacao" placeholder="0" min="0" max="10" value="<?php echo $questionario->getNotaAprovacao(); ?>" required>
        <input type='hidden' name='id' value='<?php echo $questionario->getId(); ?>' />
        <input type='hidden' name='elaboradorId' value='<?php echo $questionario->getElaborador(); ?>' />
        <input type="submit" id="btLogin" value="PROSSEGUIR">
    </form>
</div>
</body>
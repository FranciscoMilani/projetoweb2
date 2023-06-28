<?php
include_once 'verificaElaborador.php';
$titulo = "Editar Questionário";
include_once "fachada.php";

$id = @$_GET["id"];

$dao = $factory->getQuestionarioDao();
$questionario = $dao->buscaPorId($id);

include_once "LayoutHeader.php";

?>
<div class="form">
    <form id="formId" action="AlterarQuestionario.php" method="POST" class="cadastro-form">
        <label for="nome">Título</label>
        <input type="text" class="form-control" name="nome" placeholder="Título do questionário..."
            value="<?php echo $questionario->getNome(); ?>" required />

        <label for="descricao">Descrição</label>
        <textarea style="resize:none;" class="form-control" name="descricao" cols="30" rows="10" placeholder="Descrição do questionário..." required><?= $questionario->getDescricao() ?></textarea>

        <label for="notaaprovacao">Nota de aprovação</label>
        <input type="number" class="form-control" name="notaaprovacao" placeholder="0" min="0" max="10" value="<?php echo $questionario->getNotaAprovacao(); ?>" required>
        <input type='hidden' name='id' value='<?php echo $questionario->getId(); ?>' />
        <input type='hidden' name='elaboradorId' value='<?php echo $questionario->getElaborador(); ?>' />
        <input type="submit" class="btn btn-primary" id="btLogin" value="Prosseguir">
    </form>
</div>
</body>
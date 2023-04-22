<?php 
    $titulo = "Criação de Questionários";

    include_once 'verificaElaborador.php';
    include_once 'LayoutHeader.php';

?>
    <div class="form">
        <form id="formId" action="CriaQuestionario.php" method="POST" class="cadastro-form">
            <label for="nome">Título</label>
            <input type="text" name="nome" placeholder="Título do questionário..." required/>
            <label for="descricao">Descrição</label>
            <textarea style="resize:none;" name="descricao" cols="30" rows="10" placeholder="Descrição do questionário..." required></textarea>
            <label for="notaaprovacao">Nota de aprovação</label>
            <input type="number" name="notaaprovacao" placeholder="0" min="0" max="10" required>
            <input type="submit" id="btLogin" value="PROSSEGUIR">
        </form>
    </div>
</body>
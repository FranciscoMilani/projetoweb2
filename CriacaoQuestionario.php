<?php 
    $titulo = "Criação de Questionários";

    include_once 'verificaElaborador.php';
    include_once 'LayoutHeader.php';

?>
    <div class="form">
        <form id="formId" action="CriaQuestionario.php" method="POST" class="cadastro-form">
            <input type="text" name="nome" placeholder="Título do questionário" required/>
            <textarea style="resize:none;" name="descricao" cols="30" rows="10" placeholder="Descrição do questionário..." required></textarea>
            <input type="number" name="notaaprovacao" placeholder="Nota de aprovação" min="1" max="10" required>
            <input type="submit" id="btLogin" value="CRIAR">
        </form>
    </div>
</body>
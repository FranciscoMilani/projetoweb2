<?php
// validar sessão
include "verificaElaborador.php";
$titulo = 'Controle Respondentes';

include_once 'LayoutHeader.php';
include_once "fachada.php";

$dao = $factory->getQuestionarioDao();
$questionarios = $dao->buscaTodos();

$daoResp = $factory->getRespondenteDao();
$respondentes = $daoResp->buscaTodos();

?>

<div class="paginaLogin">
    <form action="CadastraElaborador.php" method="POST" class="cadastro-form">
    <label for="questionarios">Selecione um questionário:</label>

    <select name="questionarios" id="questionarios">
        <?php
            foreach($questionarios as $questionario){
                echo "<option value=\"".$questionario->getId()."\">".$questionario->getNome()."</option>";
            }
        ?>
    </select>

    <label for="respondentes">Selecione os respondentes:</label>

    <select name="respondentes" id="respondentes" multiple>
        <?php
            foreach($respondentes as $respondente){
                echo "<option value=\"".$respondente->getId()."\">".$respondente->getNome()."</option>";
            }
        ?>
    </select>
    </form>
</div>


<?php include_once 'LayoutFooter.php' ?>
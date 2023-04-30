<?php
// validar sessão
include "verificaElaborador.php";
$titulo = 'Criação de Ofertas';

include_once 'LayoutHeader.php';
include_once "fachada.php";

$dao = $factory->getQuestionarioDao();
$questionarios = $dao->buscaTodos();

$daoResp = $factory->getRespondenteDao();
$respondentes = $daoResp->buscaTodos();

?>
<form class="formOfertas" action="CadastraOferta.php" method="POST">
    <div class="wrapper">
        <div class="box1">
            <label for="questionarios">Selecione um questionário:</label>
            <select name="questionario" id="questionarios">
                <?php
                foreach ($questionarios as $questionario) {
                    echo "<option value=\"" . $questionario->getId() . "\">" . $questionario->getNome() . "</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="box2">
            <?php
            foreach ($respondentes as $resp) {
                echo "<div>";
                echo "<label>";
                echo "<input type=\"checkbox\" name=\"respondentesid[]\" value=\"" . $resp->getId() . "\">";
                echo $resp->getNome() . "</label>";
                echo "</div>";
            }

            ?>
        </div>
    </div>
    <input type="submit" value="Cadastrar" id="btCadastro">
</form>

<?php include_once 'LayoutFooter.php' ?>
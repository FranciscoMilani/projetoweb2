<?php
require "verificaElaborador.php";
$titulo = 'Criação de Ofertas';

include_once 'LayoutHeader.php';
include_once "Fachada.php";

$dao = $factory->getQuestionarioDao();
$questionarios = $dao->buscaTodos();

$daoResp = $factory->getRespondenteDao();
$respondentes = $daoResp->buscaTodos();

?>
<div class="formOfertas">
    <form action="CadastraOferta.php" method="POST">
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
                echo "<p style='margin-left: 10px'>Marque os respondentes a serem ofertados:</p>";

                foreach ($respondentes as $resp) {
                    echo "<div style='margin-left: 10px'>";
                    echo "<label>";
                    echo "<input type=\"checkbox\" name=\"respondentesid[]\" value=\"" . $resp->getId() . "\">";
                    echo $resp->getNome() . "</label>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <input type="submit" value="Ofertar" id="btCadastro">
        
        <?php 
            if (isset($_SESSION['mensagem'])) {
                echo $_SESSION['mensagem'];
                unset($_SESSION['mensagem']);
            }
        ?>
</div>
</form>

<?php include_once 'LayoutFooter.php' ?>
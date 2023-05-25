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
<form action="CadastraOferta.php" method="POST">
    <div class="containerOferta">
        <div class="divOfertas">
            <p style='margin-left: 10px'>Selecione um questionário:</p>
            <div class="align-self-center">
                <input type="text" name="pesquisa" class="camposInputPesquisa form-control" id="search_box">
            </div>
            <br/>
            <table id="tbRespondentes" class='table table-hover table-bordered table-responsive'>
                <tr>
                    <th>Questionários</th>
                </tr>

                <?php
                foreach ($questionarios as $questionario) {
                    echo "<tr>
                        <td>{$questionario->getNome()}</td>
                        </tr>";
                }
                ?>
            </table>
        </div>

        <div class="divOfertas">
            <p style='margin-left: 10px'>Marque os respondentes a serem ofertados:</p>
            <div class="align-self-center">
                <input type="text" name="pesquisa" class="camposInputPesquisa form-control" id="search_box">
            </div>
            <br/>
            <table id="tbRespondentes" class='table table-hover table-bordered table-responsive'>
                <tr>
                    <th>Respondentes</th>
                </tr>
                <?php
                foreach ($respondentes as $resp) {
                    echo "<tr>
                        <td>{$resp->getNome()}</td>
                        </tr>";
                }
                ?>
            </table>

            <?php
            if (isset($_SESSION['mensagem'])) {
                echo $_SESSION['mensagem'];
                unset($_SESSION['mensagem']);
            }
            ?>
        </div>
    </div>
    <br />
    <input type="submit" value="Ofertar" id="btOfertar">
</form>

<?php include_once 'LayoutFooter.php' ?>
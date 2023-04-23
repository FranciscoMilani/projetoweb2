<?php 
    $titulo = "Criação de Questões";

    include_once 'Fachada.php';
    include_once 'verificaElaborador.php';
    include_once 'LayoutHeader.php';

    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();

?>
    <script src="js/site.js"></script>

    <div class="form">
        <form id="formId" action="CriaQuestao.php" method="POST" class="cadastro-form">

            <fieldset>
                <textarea style="resize:none;" name="descricao" cols="30" rows="10" placeholder="Descrição da questão..." required></textarea>
            </fieldset>

            <fieldset>
                <input type="radio" name="tipoquestao" value="discursiva" onchange="selectEsconde('discursiva')" checked>
                <label for="discursiva">Discursiva</label>
                <input type="radio" name="tipoquestao" value="selecionavel" onchange="selectEsconde('selecionavel')">
                <label for="Selecionavel">Selecionavel</label>
            </fieldset>

            <!-- SELECIONAVEL (OBJETIVA OU MULTIPLA ESCOLHA) -->
            <fieldset id="selecionavel">
                <div>
                    <table>
                        <tr>
                            <td><input type="hidden" id="checkbox_hidden" name="alternativa1" value="0"></td>
                            <td><input type="checkbox" id="q1a1" name="alternativa1" value="1"></td>
                            <td><input type="text" id="q1a1text" name="alternativaTexto[]"></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" id="checkbox_hidden" name="alternativa2" value="0"></td>
                            <td><input type="checkbox" id="q1a2" name="alternativa2" value="1"></td>
                            <td><input type="text" id="q1a2text" name="alternativaTexto[]"></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" id="checkbox_hidden" name="alternativa3" value="0"></td>
                            <td><input type="checkbox" id="q1a3" name="alternativa3" value="1"></td>
                            <td><input type="text" id="q1a3text" name="alternativaTexto[]"></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" id="checkbox_hidden" name="alternativa4" value="0"></td>
                            <td><input type="checkbox" id="q1a4" name="alternativa4" value="1"></td>
                            <td><input type="text" id="q1a4text" name="alternativaTexto[]"></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" id="checkbox_hidden" name="alternativa5" value="0"></td>
                            <td><input type="checkbox" id="q1a4" name="alternativa5" value="1"></td>
                            <td><input type="text" id="q1a4text" name="alternativaTexto[]"></td>
                        </tr>
                    </table>
                </div>
            </fieldset>

            <?php 
                $alts = $daoAlternativa->buscaTodos();
                foreach($alts as $alt) {
                    echo '<option value="'.$alt->getId().'">'.$alt->getDescricao().'</option>';
                }
            ?>

            <input type="submit" name="submit" id="btLogin" value="PROSSEGUIR">
        </form>
    </div>
</body>
<?php 
    $titulo = "Criação de Questões";

    include_once 'Fachada.php';
    include_once 'verificaElaborador.php';
    include_once 'LayoutHeader.php';

    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();

?>
    <script src="js/site.js"></script>

    <div class="form paginaLogin">
        <form id="formId" action="CriaQuestao.php" method="POST" class="cadastro-questao-form">

            <textarea class="form-control" style="resize:none;" name="descricao" cols="30" rows="10" placeholder="Descrição da questão..." required></textarea>
            <fieldset class="container py-3">
                <label for="discursiva">Discursiva</label>
                <input type="radio" class="radio-questao" name="tipoquestao" value="discursiva" checked>
                <br>    
                <label for="Selecionavel">Selecionavel</label>
                <input type="radio" class="radio-questao" name="tipoquestao" value="selecionavel">
            </fieldset>

            
            <!-- SELECIONAVEL (OBJETIVA OU MULTIPLA ESCOLHA) -->
            <fieldset id="selecionavel">
                <hr>
                <select class="form-select my-3 w-25" aria-label="Default select example">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option selected value="5">5</option>
                </select>

                <div>

                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input type="hidden" id="checkbox_hidden" name="alternativa1" value="0">
                            <input type="checkbox" class="form-check-input mt-0" id="q1a1" name="alternativa1" value="1">
                        </div>
                        <input class="form-control" type="text" id="q1a1text" name="alternativaTexto[]">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input type="hidden" id="checkbox_hidden" name="alternativa2" value="0">
                            <input type="checkbox" class="form-check-input mt-0" id="q1a2" name="alternativa2" value="1">
                        </div>
                        <input class="form-control" type="text" id="q1a2text" name="alternativaTexto[]">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input type="hidden" id="checkbox_hidden" name="alternativa3" value="0">
                            <input type="checkbox" class="form-check-input mt-0" id="q1a3" name="alternativa3" value="1">
                        </div>
                        <input class="form-control" type="text" id="q1a3text" name="alternativaTexto[]">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input type="hidden" id="checkbox_hidden" name="alternativa4" value="0">
                            <input type="checkbox" class="form-check-input mt-0" id="q1a4" name="alternativa4" value="1">
                        </div>
                        <input class="form-control" type="text" id="q1a4text" name="alternativaTexto[]">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input type="hidden" id="checkbox_hidden" name="alternativa5" value="0">
                            <input type="checkbox" class="form-check-input mt-0" id="q1a5" name="alternativa5" value="1">
                        </div>
                        <input class="form-control" type="text" id="q1a5text" name="alternativaTexto[]">
                    </div>

<!--                     

                    <table class="table table-borderless align-middle">
                        <tr>
                            <input type="hidden" id="checkbox_hidden" name="alternativa1" value="0">
                            <td><input type="checkbox" id="q1a2" name="alternativa1" value="1"></td>
                            <td><input class="form-control" type="text" id="q1a1text" name="alternativaTexto[]"></td>
                        </tr>
                        <tr>
                            <input type="hidden" id="checkbox_hidden" name="alternativa2" value="0">
                            <td><input type="checkbox" id="q1a2" name="alternativa2" value="1"></td>
                            <td><input class="form-control" type="text" id="q1a2text" name="alternativaTexto[]"></td>
                        </tr>
                        <tr>
                            <input type="hidden" id="checkbox_hidden" name="alternativa3" value="0">
                            <td><input type="checkbox" id="q1a3" name="alternativa3" value="1"></td>
                            <td><input class="form-control" type="text" id="q1a3text" name="alternativaTexto[]"></td>
                        </tr>
                        <tr>
                            <input type="hidden" id="checkbox_hidden" name="alternativa4" value="0">
                            <td><input type="checkbox" id="q1a4" name="alternativa4" value="1"></td>
                            <td><input class="form-control" type="text" id="q1a4text" name="alternativaTexto[]"></td>
                        </tr>
                        <tr>
                            <input type="hidden" id="checkbox_hidden" name="alternativa5" value="0">
                            <td><input type="checkbox" id="q1a4" name="alternativa5" value="1"></td>
                            <td><input class="form-control" type="text" id="q1a4text" name="alternativaTexto[]"></td>
                        </tr>
                    </table> -->
                </div>
            </fieldset>
            
            <input type="submit" class="btn" name="submit" id="btLogin" value="PROSSEGUIR">
            <!-- <select name="select_option">
                //<?php 
                //    $alts = $daoAlternativa->buscaTodos();
                //    foreach($alts as $alt) {
                //        echo '<option value="'.$alt->getId().'">'.$alt->getDescricao().'</option>';
                //    }
                //?>
            </select> -->

        </form>
    </div>
</body>
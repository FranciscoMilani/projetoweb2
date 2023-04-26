<?php 
    $titulo = "Criação de Questões";

    include_once 'Fachada.php';
    include_once 'verificaElaborador.php';
    include_once 'LayoutHeader.php';

    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();

?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--<script src="sweetalert2.all.min.js"></script>-->
    <script src="js/site.js"></script>

    <div class="form paginaLogin">
        <form id="formId" action="CriaQuestao.php" method="POST" class="cadastro-questao-form">

            <textarea class="form-control" style="resize:none;" name="descricao" cols="30" rows="10" placeholder="Descrição da questão..." required></textarea>
            <fieldset class="container py-3">
                <label for="discursiva">Discursiva</label>
                <input type="radio" class="radio-questao " name="tipoquestao" value="discursiva" checked>
                <br>    
                <label for="Selecionavel">Selecionável</label>
                <input type="radio" class="radio-questao" name="tipoquestao" value="selecionavel">
            </fieldset>

            
            <!-- SELECIONAVEL (OBJETIVA OU MULTIPLA ESCOLHA) -->
            <fieldset id="selecionavel">
                <hr>
                <select class="form-select my-3 w-25" id="quantidade-alternativas" name="quantidade">
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option selected value="5">5</option>
                </select>

                <div id="selects">
                </div>
            </fieldset>
            
            <input type="submit" class="btn btn-primary" name="submit" id="btSubmit" value="Prosseguir">
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
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
    <script src="public/js/site.js"></script>

    <div class="form paginaLogin container">
        <form id="formId" action="CriaQuestao.php" method="POST" class="cadastro-questao-form" enctype="multipart/form-data">

            <textarea class="form-control" style="resize:none;" name="descricao" cols="30" rows="10" placeholder="Descrição da questão..." required></textarea>

            <div class="my-4">
                <input class="form-control form-control-sm" id="question-file" type="file">
            </div>

            <fieldset class="container row-cols-1 py-3">
                <div class="row">
                    <div class="col-2 text-start">
                        <label for="discursiva">Discursiva:</label>
                    </div>
                    <div class="col-10">
                        <input type="radio" class="radio-questao" name="tipoquestao" value="discursiva" checked>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-2 text-start">
                        <label for="selecionavel">Selecionável:</label>
                    </div>  
                    <div class="col-10">
                        <input type="radio" class="radio-questao" name="tipoquestao" value="selecionavel">                 
                    </div>  
                </div>
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

        </form>
    </div>
</body>
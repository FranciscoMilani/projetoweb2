<?php
$mensagem = @$_GET["mensagem"];
if (!empty($mensagem)) {
    echo "<script>alert('$mensagem');</script>";
}

$titulo = "Controle Questionários";
$tipoLista = "Questionario";
include_once "verificaElaborador.php";
include_once "LayoutHeader.php";
?>

<section class="container-fluid mt-5 w-100 w-sm-50 w-md-25">
    <div class="d-flex flex-column text-center justify-content-around container-listagem">
        <button class="classeBotoes" onclick="location.href='CriacaoQuestionario.php'">Novo Questionário</button>
        
        <div class="input-group flex-nowrap align-self-stretch shadow-sm rounded-2">
            <span class="input-group-text bi bi-search" id="addon-wrapping"></span>
            <input type="text" name="pesquisa" class="camposInputPesquisa form-control m-0" id="search_box">
        </div>
        <div class="table-responsive mt-3" id="dynamic_content">
            <!-- conteúdo dinâmico -->
        </div>
        <div class="d-flex flex-row justify-content-between align-items-center px-1 mt-2">  
            <a href="Menu.php" class="btn btn-primary btn-lg bi bi-arrow-left"></a>
            <div class="" id="pagination_list">
                <!-- paginação -->
            </div>    
        </div>
    </div>
</section>
<?php
echo "</section>";
include_once "LayoutFooter.php";
?>
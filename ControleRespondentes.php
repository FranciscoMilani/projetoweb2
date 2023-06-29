<?php
$mensagem = @$_GET["mensagem"];
if (!empty($mensagem)) {
    echo "<script>alert('$mensagem');</script>";
}

$titulo = "Controle de Respondentes e Submissões";
$tipoLista = "RespondenteResultado";
include "verificaElaborador.php";
include_once "LayoutHeader.php";
?>

<section class="">
    <div class="containerOferta flex-wrap">
        <div class="divOfertas rounded-2">
            <p class="text-center fs-3 fw-semibold text-secondary-emphasis" style='margin-left: 10px'>Selecione um respondente</p>
            <section class="container-fluid mt-5 w-100 w-sm-50 w-md-25">
                <div class="d-flex flex-column text-center justify-content-around container-listagem">
                    <div class="input-group flex-nowrap align-self-stretch shadow-sm rounded-2">
                        <span class="input-group-text bi bi-search" id="addon-wrapping"></span>
                        <input type="text" name="pesquisa" class="camposInputPesquisa form-control m-0" id="search_box2">
                    </div>
                    <div class="table-responsive mt-3" id="dynamic_content2">
                        <!-- conteúdo dinâmico -->
                    </div>
                    <div class="align-self-center" id="pagination_list2">
                        <!-- paginação -->
                    </div>
                </div>
        </div>
        <div class="divOfertas rounded-2">
            <p class="text-center fs-3 fw-semibold text-secondary-emphasis" id="texto-selecionar-submissao" style='margin-left: 10px'>Selecione uma submissão</p>
            <section class="container-fluid mt-5 w-100 w-sm-50 w-md-25">
                <div class="d-flex flex-column text-center justify-content-around container-listagem">
                    <div class="input-group flex-nowrap align-self-stretch shadow-sm rounded-2">
                        <span class="input-group-text bi bi-search" id="addon-wrapping"></span>
                        <input type="text" name="pesquisa" class="camposInputPesquisa form-control m-0" id="search_box">
                    </div>
                    <div class="table-responsive mt-3" id="dynamic_content">
                        <!-- conteúdo dinâmico -->
                    </div>
                    <div class="align-self-center" id="pagination_list">
                        <!-- paginação -->
                    </div>
                </div>
        </div>
    </div>
<br>
    <div class="w-100">
        <div class="d-flex justify-content-evenly align-items-center">
            <a href="Menu.php" class="btn btn-primary bi bi-arrow-left p-2" style="font-size: 25px; min-width:75px;"></a>
        </div>
    </div>
<?php
echo "</section>";
include_once "LayoutFooter.php";
?>
<?php
$mensagem = @$_GET["mensagem"];
if (!empty($mensagem)) {
    echo "<script>alert('$mensagem');</script>";
}

$titulo = 'Criação de Ofertas';
$tipoLista = "OfertaQuestionarioRespondente";

require "verificaElaborador.php";
include_once 'LayoutHeader.php';
?>

    <div class="containerOferta">
        <div class="divOfertas">
            <p style='margin-left: 10px'>Marque o questionário a ser ofertado:</p>
            <section class="container-fluid mt-5 w-100 w-sm-50 w-md-25">
                <div class="d-flex flex-column text-center justify-content-around container-listagem">
                    <div class="align-self-stretch">
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
        <div class="divOfertas">
            <p style='margin-left: 10px'>Marque os respondentes a serem ofertados:</p>
            <section class="container-fluid mt-5 w-100 w-sm-50 w-md-25">
                <div class="d-flex flex-column text-center justify-content-around container-listagem">
                    <div class="align-self-stretch">
                        <input type="text" name="pesquisa" class="camposInputPesquisa form-control m-0"
                            id="search_box2">
                    </div>
                    <div class="table-responsive mt-3" id="dynamic_content2">
                        <!-- conteúdo dinâmico -->
                    </div>
                    <div class="align-self-center" id="pagination_list2">
                        <!-- paginação -->
                    </div>
                </div>
        </div>
    </div>
    <br />
    <input type="button" value="Ofertar" id="btOfertar">

<?php include_once 'LayoutFooter.php' ?>
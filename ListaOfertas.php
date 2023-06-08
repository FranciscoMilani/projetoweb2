<?php
$mensagem = @$_GET["mensagem"];
if (!empty($mensagem)) {
    echo "<script>alert('$mensagem');</script>";
}

$titulo = "Suas Ofertas";
$tipoLista = "Oferta";
include "verificaRespondente.php";
include_once "LayoutHeader.php";
include_once "Fachada.php";
?>

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

    <div class="d-flex justify-content-center">
        <a href="Menu.php" class="btn btn-primary btn-lg m-4 mx-auto float-center">Voltar</a>
    </div>
</section>
    
<?php
echo "</section>";
include_once "LayoutFooter.php";
?>
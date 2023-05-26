<?php
$titulo = "Controle Respondentes";
$isPaginaResp = TRUE;
include "verificaElaborador.php";
include_once "LayoutHeader.php";

$mensagem = @$_GET["mensagem"];
if (!empty($mensagem)) {
    echo "<script>alert('$mensagem');</script>";
}
?>

<section class="container mt-5 w-100 w-sm-50 w-md-25">
    <div class="d-flex flex-column text-center justify-content-around">
        <button class="classeBotoes" onclick="location.href='CadastroRespondente.php'">Novo Respondente</button>

        <div class="align-self-center">
            <input type="text" name="pesquisa" class="camposInputPesquisa form-control" id="search_box">
        </div>
        <div class="table-responsive mx-2 mt-3" id="dynamic_content">
            <!-- conteúdo dinâmico -->
        </div>
        <div class="align-self-center" id="pagination_list">
            <!-- paginação -->
        </div>
    </div>
<?php
echo "</section>";
include_once "LayoutFooter.php";
?>
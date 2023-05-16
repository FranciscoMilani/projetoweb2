<?php
// validar sessão
$titulo = "Controle Elaboradores";
include "verificaAdmin.php";
include_once "LayoutHeader.php";
include_once "Fachada.php";

$mensagem = @$_GET["mensagem"];
if (!empty($mensagem)) {
    echo "<script>alert('$mensagem');</script>";
}

// procura elaboradores
$dao = $factory->getElaboradorDao();
$limit = 3;
?>

<section class="container mt-5 w-100 w-sm-50 w-md-25">
    <div class="d-flex flex-column text-center justify-content-around">
        <button class="classeBotoes" onclick="location.href='CadastroElaborador.php'">Novo Elaborador</button>

        <div class="align-self-center">
            <input type="text" name="pesquisa" class="camposInputPesquisa form-control" id="search_box">
        </div>
        <div class="table-responsive mx-2 mt-3" id="dynamic_content">
            <!-- conteúdo dinâmico -->
        </div>
        <div class="align-self-center" id="pagination_list">

        </div>
    </div>


<script>
$(document).ready(function(){
    
    load_data(<?=$limit?>, 1);

    function load_data(limit, page, query = '')
    {
        $.ajax({
            url: "FetchElaborador.php",
            method: "POST",
            data:
            {
                limit: limit,
                page: page, 
                query: query
            },
            success:function(response)
            {
                var html1 = response.html1;
                var html2 = response.html2;

                $('#dynamic_content').html(html1);
                $('#pagination_list').html(html2);
            }
        });
    }

    $(document).on('click', '.page-link', function() {
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data(<?=$limit?>, page, query);
    });


    $('#search_box').keyup(function(){
        var query = $('#search_box').val();
        load_data(<?=$limit?>, 1, query);
    });
});
</script>

<?php
echo "</section>";
include_once "LayoutFooter.php";
?>
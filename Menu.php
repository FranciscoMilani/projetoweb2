<?php
// validar sessão
include "verificaUsuarios.php";

$titulo = "Menu Principal";
include_once 'LayoutHeader.php';
?>

<nav class="container-fluid">
    <div class="row row-cols-8 align-items-center text-center justify-content-center">
        <div class="mt-5">
            <div class="cartao">
                <?php
                //verifica se é admin para ter funções diferentes
                if ($_SESSION["is_admin"]) {
                    echo "<button class=\"classeBotoes menuBotoes btn btn-primary m-3 shadow-sm rounded-4 fs-5\" onclick=\"location.href='ControleElaboradores.php'\">Controle de Elaboradores</button>";
                }

                //verifica se é elaborador para ter funções diferentes
                if ($_SESSION["is_elaborador"]) {
                    echo "<button class=\"classeBotoes menuBotoes btn btn-primary m-3 shadow-sm rounded-4 fs-5\" onclick=\"location.href='ControleRespondentes.php'\">Controle de Respondentes e Submissões</button>";
                    echo "<button class=\"classeBotoes menuBotoes btn btn-primary m-3 shadow-sm rounded-4 fs-5\" onclick=\"location.href='ControleQuestionarios.php'\">Controle de Questionários</button>";
                    echo "<button class=\"classeBotoes menuBotoes btn btn-primary m-3 shadow-sm rounded-4 fs-5\" onclick=\"location.href='ControleQuestoes.php'\">Visualiza Questões</button>";
                    echo "<button class=\"classeBotoes menuBotoes btn btn-primary m-3 shadow-sm rounded-4 fs-5\" onclick=\"location.href='OfertarQuestionario.php'\">Ofertar Questionário</button>";
                    echo "<button class=\"classeBotoes menuBotoes btn btn-primary m-3 shadow-sm rounded-4 fs-5\" onclick=\"location.href='VisualizarGraficos.php'\">Métricas</button>";
                }
                     
                //se for respondente, mostra apenas botao de ofertas
                if (!$_SESSION["is_admin"] && !$_SESSION["is_elaborador"]) {
                    echo "<button class=\"classeBotoes menuBotoes btn btn-primary m-3 shadow-sm rounded-4 fs-5\" onclick=\"location.href='ListaOfertas.php'\">Ver Ofertas</button>";
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<?php
include_once "LayoutFooter.php";
?>
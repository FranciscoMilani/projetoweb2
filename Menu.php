<?php
// validar sessão
include "verificaUsuarios.php";

$titulo = "Menu Principal";
include_once 'LayoutHeader.php';
?>

<div class="divMenu">
    <?php
    //verifica se é elaborador para ter funções diferentes
    if ($_SESSION["is_elaborador"]) {
        echo "<button class=\"classeBotoes\" onclick=\"location.href='ControleRespondentes.php'\">Controle de Respondentes</button>";
        echo "<button class=\"classeBotoes\" onclick=\"location.href='ControleQuestionarios.php'\">Criação de Questionários</button>";
        echo "<button class=\"classeBotoes\" onclick=\"location.href='CriacaoQuestao.php'\">Criação de Questões</button>";
        echo "<button class=\"classeBotoes\" onclick=\"location.href='OfertarQuestionario.php'\">Faz Oferta</button>";
    }

    //verifica se é admin para ter funções diferentes
    if ($_SESSION["is_admin"]) {
        echo "<button class=\"classeBotoes\" onclick=\"location.href='ControleElaboradores.php'\">Controle de Elaboradores</button>";
    }
    
    //se for respondente, mostra apenas botao de ofertas
    if (!$_SESSION["is_admin"] && !$_SESSION["is_elaborador"]) {
        echo "<button class=\"classeBotoes\" onclick=\"location.href='ListaOfertas.php'\">Ver Ofertas</button>";
    }
    ?>
</div>

<?php
include_once "LayoutFooter.php";
?>
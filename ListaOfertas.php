<?php
// validar sessão
include "verificaRespondente.php";
$titulo = 'Suas Ofertas';

include_once 'LayoutHeader.php';
include_once "fachada.php";

echo "<section class=\"mt-5\">";
$idUsuario = $_SESSION["id_usuario"];

$dao = $factory->getOfertaDao();
$ofertas = $dao->ofertasPorUsuario($idUsuario);

$daoQuestionario = $factory->getQuestionarioDao();
$daoElab = $factory->getElaboradorDao();
$daoSubmissao = $factory->getSubmissaoDao();


//Criacao da tabela
if ($ofertas) {
    echo "<div class=\"table-responsive\">";
    echo "<table id=\"tbRespondente\" class='table table-hover table-bordered'>";
    echo "<tr>";
    echo "<th>Nome</th>";
    echo "<th>Descrição</th>";
    echo "<th>Data</th>";
    echo "<th>Criado Por</th>";
    echo "<th></th>";
    echo "<th></th>";
    echo "</tr>";

    foreach ($ofertas as $oferta) {
        $quest = $daoQuestionario->buscaPorId($oferta->getQuestionario());
        $elab = $daoElab->buscaPorId($quest->getElaborador());
        $date = new DateTime($oferta->getData());
        $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));

        echo "<tr>";
        echo "<td>{$quest->getNome()}</td>";
        echo "<td>{$quest->getDescricao()}</td>";
        echo "<td>{$formattedDate}</td>";
        echo "<td>{$elab->getNome()}</td>";
        // verifica se já foi respondido e troca botão
        $submissao = $daoSubmissao->buscaPorOfertaRespondenteId($oferta->getId(), $idUsuario);
        if (!isset($submissao)){
            
            // botão para Responder
            echo "<td>";
            echo "<a href='RespondeQuestionario.php?ofertaId={$oferta->getId()}&questId={$oferta->getQuestionario()}' class='btn btn-info'>";
            echo "<span class='glyphicon glyphicon-edit'></span> Responder";
            echo "</a>";
            echo "</td>";
            
            // botão para ver resposta
            echo "<td>";
            echo "<span class='glyphicon glyphicon-edit btn btn-secondary disabled'>Visualizar</span>";
            echo "</td>";
        } else {

            // aviso de já respondido
            echo "<td>";
            echo "<button class='glyphicon glyphicon-edit btn btn-secondary' disabled>Respondido</button>";
            echo "</td>";

            // botão para ver resposta
            echo "<td>";
            echo "<a href='VisualizarResultados.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}' class='btn btn-info'>";
            echo "<span class='glyphicon glyphicon-edit'></span> Visualizar";
            echo "</a>";
            echo "</td>";
            
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "<p style='text-align: center; margin-top: 10%'>Você não possui nenhum questionário ofertado para responder!</p>";
}
echo "</section>";
include_once "LayoutFooter.php";
?>
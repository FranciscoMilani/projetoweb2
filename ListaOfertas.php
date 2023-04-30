<?php
// validar sessão
include "verificaUsuarios.php";
$titulo = 'Suas Ofertas';

include_once 'LayoutHeader.php';
include_once "fachada.php";

echo "<section>";
$idUsuario = $_SESSION["id_usuario"];

$dao = $factory->getOfertaDao();
$ofertas = $dao->ofertasPorUsuario($idUsuario);

$daoQuestionario = $factory->getQuestionarioDao();

//Criacao da tabela
if ($ofertas) {
    echo "<table id=\"tbRespondente\" class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>Nome</th>";
    echo "<th>Descrição</th>";
    echo "<th>Data</th>";
    echo "<th></th>";
    echo "</tr>";

    foreach ($ofertas as $oferta) {
        $quest = $daoQuestionario->buscaPorId($oferta->getQuestionario());
        $date = new DateTime($oferta->getData());
        $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));

        echo "<tr>";
        echo "<td>{$quest->getNome()}</td>";
        echo "<td>{$quest->getDescricao()}</td>";
        echo "<td>{$formattedDate}</td>";
        echo "<td>";
        // botão para Responder
        echo "<a href='RespondeQuestionario.php?id={$quest->getId()}' class='btn btn-info'>";
        echo "<span class='glyphicon glyphicon-edit'></span> Responder";
        echo "</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align: center; margin-top: 10%'>Você não possui nenhum questionário ofertado para responder!</p>";
}
echo "</section>";
include_once "LayoutFooter.php";
?>
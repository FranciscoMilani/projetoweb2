<?php
// validar sessão
include "verificaAdmin.php";
$titulo = 'Controle Questionários';

include_once 'LayoutHeader.php';
include_once "fachada.php";

echo "<section>";

// procura questionarios
$dao = $factory->getQuestionarioDao();
$questionarios = $dao->buscaTodos();

$daoElab = $factory->getElaboradorDao();

echo "<button class=\"classeBotoes\" onclick=\"location.href='CriacaoQuestionario.php'\">Novo Questionário</button>";

//cria tabela
if ($questionarios) {
    echo "<table id=\"tbQuestionario\" class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>Id</th>";
    echo "<th>Nome</th>";
    echo "<th>Descrição</th>";
    echo "<th>Data Criação</th>";
    echo "<th>Nota Aprovação</th>";
    echo "<th>Elaborado Por</th>";
    echo "<th></th>";
    echo "</tr>";

    foreach ($questionarios as $quest) {
        $elab = $daoElab->buscaPorId($quest->getId());

        $date = new DateTime($quest->getDataCriacao());
        $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));

        echo "<tr>";
        echo "<td>{$quest->getId()}</td>";
        echo "<td>{$quest->getNome()}</td>";
        echo "<td>{$quest->getDescricao()}</td>";
        echo "<td>{$formattedDate}</td>";
        echo "<td>{$quest->getNotaAprovacao()}</td>";
        echo "<td>{$elab->getNome()}</td>";
        echo "<td>";
        //PRECISA IMPLEMENTAR OS METODOS
        // botão para alterar um questionario
        echo "<a href='ModificaElaborador.php?id={$quest->getId()}' class='btn btn-info'>";
        echo "<span class='glyphicon glyphicon-edit'></span> Altera";
        echo "</a>";
        // botão para remover um questionario
        echo "<a href='ExcluiElaborador.php?id={$quest->getId()}' class='btn btn-danger'";
        echo "onclick=\"return confirm('Tem certeza que quer excluir?')\">";
        echo "<span class='glyphicon glyphicon-remove'></span> Exclui";
        echo "</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
echo "</section>";
include_once "LayoutFooter.php";
?>
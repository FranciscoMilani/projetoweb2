<?php
// validar sessão
include "verificaAdmin.php";
$titulo = 'Controle Elaboradores';

include_once 'LayoutHeader.php';
include_once "fachada.php";

echo "<section>";

// echo "<div class=\"divControleElab\">";

// procura elaboradores
$dao = $factory->getElaboradorDao();
$elaboradores = $dao->buscaTodos();

echo "<button class=\"classeBotoes\" onclick=\"location.href='CadastroElaborador.php'\">Novo Elaborador</button>";
if ($elaboradores) {
    echo "<table id=\"tbElaborador\" class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>Id</th>";
    echo "<th>Login</th>";
    echo "<th>Nome</th>";
    echo "<th>Email</th>";
    echo "<th>Instituição</th>";
    echo "<th>Admin</th>";
    echo "</tr>";

    foreach ($elaboradores as $elab) {
        echo "<tr>";
            echo "<td>{$elab->getId()}</td>";
            echo "<td>{$elab->getLogin()}</td>";
            echo "<td>{$elab->getNome()}</td>";
            echo "<td>{$elab->getEmail()}</td>";
            echo "<td>{$elab->getInstituicao()}</td>";
            if ($elab->getIsAdmin() == TRUE) {
                echo "<td>Sim</td>";
            } else {
                echo "<td>Não</td>";
            }
            echo "<td>";
                // botão para alterar um elaborador
                echo "<a href='ModificaElaborador.php?id={$elab->getId()}' class='btn btn-info'>";
                echo "<span class='glyphicon glyphicon-edit'></span> Altera";
                echo "</a>";
                // botão para remover um elaborador
                echo "<a href='ExcluiElaborador.php?id={$elab->getId()}' class='btn btn-danger'";
                echo "onclick=\"return confirm('Tem certeza que quer excluir?')\">";
                echo "<span class='glyphicon glyphicon-remove'></span> Exclui";
                echo "</a>";
            echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
// echo "</div>";
echo "</section>";
include_once "LayoutFooter.php";
?>
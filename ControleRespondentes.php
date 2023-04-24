<?php
// validar sessão
include "verificaElaborador.php";
$titulo = 'Controle Respondentes';

include_once 'LayoutHeader.php';
include_once "fachada.php";

echo "<section>";

// procura elaboradores
$pesquisaNome = null;
$pesquisaEmail = null;
$dao = $factory->getRespondenteDao();
$respondentes = $dao->buscaTodos();

echo "<button class=\"classeBotoes\" onclick=\"location.href='CadastroUsuario.php'\">Novo Respondente</button>";

//falta implementar os metodos para buscar
echo "Pesquisa por nome: ";
echo "<input type=\"text\" name=\"nome\" value=\"" . $pesquisaNome . "\">";
echo "<input type=\"button\" value=\"Pesquisar\">";
echo "<br/><br/>";
echo "Pesquisa por E-mail: ";
echo "<input type=\"text\" name=\"email\" value=\"" . $pesquisaEmail . "\">";
echo "<input type=\"button\" value=\"Pesquisar\">";

if ($respondentes) {
    echo "<table id=\"tbElaborador\" class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>Id</th>";
    echo "<th>Login</th>";
    echo "<th>Nome</th>";
    echo "<th>Email</th>";
    echo "<th>Telefone</th>";
    echo "</tr>";

    foreach ($respondentes as $resp) {
        echo "<tr>";
        echo "<td>{$resp->getId()}</td>";
        echo "<td>{$resp->getLogin()}</td>";
        echo "<td>{$resp->getNome()}</td>";
        echo "<td>{$resp->getEmail()}</td>";
        echo "<td>{$resp->getTelefone()}</td>";
        echo "<td>";
        // botão para alterar um respondente
        echo "<a href='ModificaRespondente.php?id={$resp->getId()}' class='btn btn-info'>";
        echo "<span class='glyphicon glyphicon-edit'></span> Altera";
        echo "</a>";
        // botão para remover um respondente
        echo "<a href='ExcluiRespondente.php?id={$resp->getId()}' class='btn btn-danger'";
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
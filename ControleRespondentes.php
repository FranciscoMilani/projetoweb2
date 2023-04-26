<?php
// validar sessão
include "verificaElaborador.php";
$titulo = 'Controle Respondentes';

include_once 'LayoutHeader.php';
include_once "fachada.php";

$nome = @$_POST["pesquisaNome"];
$email = @$_POST["pesquisaEmail"];


echo "<section>";

$dao = $factory->getRespondenteDao();
if (($nome == null || $nome == "") && ($email == null || $email == "")) {
    $respondentes = $dao->buscaTodos();
}
if ($nome != null || $nome != "") {
    $respondentes = $dao->buscaPorNome($nome);
}
if ($email != null || $email != "") {
    $respondentes = $dao->buscaPorEmail($email);
}

// echo "<button class=\"classeBotoes\" onclick=\"location.href='CadastroUsuario.php'\">Novo Respondente</button>";

//Campos de busca
echo "<form action=\"ControleRespondentes.php\" method=\"POST\" class=\"formCampoPesquisa\">";
echo "Pesquisa por nome: ";
echo "<input type=\"text\" name=\"pesquisaNome\" value=\"" . $nome . "\" class='camposInputPesquisa'>";
echo "<input type=\"submit\" value=\"Pesquisar\" class='btn btn-info'>";
echo "</form>";
echo "<form action=\"ControleRespondentes.php\" method=\"POST\" class=\"formCampoPesquisa\">";
echo "Pesquisa por E-mail: ";
echo "<input type=\"text\" name=\"pesquisaEmail\" value=\"" . $email . "\" class='camposInputPesquisa'>";
echo "<input type=\"submit\" value=\"Pesquisar\" class='btn btn-info'>";
echo "</form>";


//Criacao da tabela
if ($respondentes) {
    echo "<table id=\"tbRespondente\" class='table table-hover table-responsive table-bordered'>";
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
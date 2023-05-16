<?php
// validar sessão
include "verificaElaborador.php";
$titulo = 'Controle Respondentes';

include_once 'LayoutHeader.php';
include_once "fachada.php";

$nome = @$_POST["pesquisaNome"];
$email = @$_POST["pesquisaEmail"];

$mensagem = @$_GET["mensagem"];
if (!empty($mensagem)) {
    echo "<script>alert('$mensagem');</script>";
}


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
echo "Pesquisa por nome ou e-mail: ";
echo "<input type=\"text\" name=\"pesquisaNome\" value=\"" . $nome . "\" class='camposInputPesquisa'>";
echo "<input type=\"submit\" value=\"Pesquisar\" class='btn btn-info'>";
echo "</form>";


//Criacao da tabela
if ($respondentes) {
    echo "<div class=\"table-responsive\">";
    echo "<table id=\"tbRespondente\" class='table table-hover table-bordered'>";
    echo "<tr>";
    echo "<th>Id</th>";
    echo "<th>Login</th>";
    echo "<th>Nome</th>";
    echo "<th>Email</th>";
    echo "<th>Telefone</th>";
    echo "<th></th>";
    echo "<th></th>";
    echo "</tr>";

    foreach ($respondentes as $resp) {
        echo "<tr>
                <td>{$resp->getId()}</td>
                <td>{$resp->getLogin()}</td>
                <td>{$resp->getNome()}</td>
                <td>{$resp->getEmail()}</td>
                <td>{$resp->getTelefone()}</td>
                <td>
                    <a href='ModificaRespondente.php?id={$resp->getId()}' class='btn btn-info m-1'>
                        <span class='glyphicon glyphicon-edit'></span> Altera
                    </a>
                    <a href='ExcluiRespondente.php?id={$resp->getId()}' class='btn btn-danger m-1'
                    onclick=\"return confirm('Tem certeza que quer excluir?')\">
                        <span class='glyphicon glyphicon-remove'></span> Exclui
                    </a>
                </td>
                <td>
                    <a href='ControleResultados.php?id={$resp->getId()}' class='btn btn-info m-1'
                        <span class='glyphicon glyphicon-remove'></span> Respostas
                    </a>
                </td>
            </tr>";
    }
    echo "</table>";
    echo "</div>";
}
echo "</section>";
include_once "LayoutFooter.php";
?>
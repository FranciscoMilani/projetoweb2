<?php
$mensagem = @$_GET['mensagem'];
if (!empty($mensagem)) {
    echo "<script>alert('$mensagem');</script>";
}

$titulo = 'Visualiza Questões';
include_once 'verificaElaborador.php';
include_once 'LayoutHeader.php';
include_once 'Fachada.php';


echo "<section>";

// procura questoes
$dao = $factory->getQuestaoDao();
$questoes = $dao->buscaTodos();

$daoElab = $factory->getElaboradorDao();

echo "<button class=\"classeBotoes\" onclick=\"location.href='CriacaoQuestao.php'\">Nova Questão</button>";

//cria tabela
if ($questoes) {
    echo "<div class=\"table-responsive\">";
    echo "<table id=\"tbQuestionario\" class='table table-hover table-bordered'>";
    echo "<tr>";
    echo "<th>Id</th>";
    echo "<th>Descrição</th>";
    echo "<th>Tipo</th>";
    // echo "<th></th>";
    echo "</tr>";
    
    foreach ($questoes as $quest) {
        echo "<tr>";
        echo "<td>{$quest->getId()}</td>";
        echo "<td>{$quest->getDescricao()}</td>";
        echo "<td>{$quest->getTipo()}</td>";
        // echo "<td>";
        // // botão para remover uma questão
        // echo "<a href='ExcluiQuestao.php?id={$quest->getId()}' class='btn btn-danger'";
        // echo "onclick=\"return confirm('Tem certeza que quer excluir?')\">";
        // echo "<span class='glyphicon glyphicon-remove'></span> Exclui";
        // echo "</a>";
        // echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
}
echo "</section>";
include_once "LayoutFooter.php";
?>
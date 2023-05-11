<?php 
    $titulo = "Visualizar Resultados de Ofertas";
    include_once "verificaElaborador.php";
    include_once "LayoutHeader.php";
    include_once "Fachada.php";

    $respId = $_GET["id"];
    if (!isset($respId)){
        header('Location: ControleRespondentes.php');
        exit;
    }
    
    $dao = $factory->getOfertaDao();
    $ofertas = $dao->ofertasPorUsuario($respId); // ofertas por respondente
    $ofertasSubm = $dao->buscaOfertasSubmetidasPorRespondente($respId);
    
    $daoQuestionario = $factory->getQuestionarioDao();
    $daoElab = $factory->getElaboradorDao();
    $daoSubmissao = $factory->getSubmissaoDao();

    echo "<section class=\"mt-5\">";

    if ($ofertasSubm) {
        echo "<div class=\"table-responsive\">";
        echo "<table id=\"tbRespondente\" class='table table-hover table-responsive'>";
        echo "<tr>";
        echo "<th>Nome</th>";
        echo "<th>Descrição</th>";
        echo "<th>Data</th>";
        echo "<th>Criado Por</th>";
        echo "<th></th>";
        echo "</tr>";

        if (empty($ofertas)){
            echo "<span> Não há respostas disponíveis por esse respondente <span>";
            return;
        }
    
        foreach ($ofertas as $oferta) {

            // ignora oferta se ainda não foi respondida
            $submissao = $daoSubmissao->buscaPorOfertaRespondenteId($oferta->getId(), $respId);
            if (!isset($submissao)){
                continue;
            }

            $quest = $daoQuestionario->buscaPorId($oferta->getQuestionario());
            $elab = $daoElab->buscaPorId($quest->getElaborador());
            $date = new DateTime($oferta->getData());
            $formattedDate = date('d/m/Y', strtotime($date->format('Y-m-d')));
    
            echo "<tr>";
            echo "<td>{$quest->getNome()}</td>";
            echo "<td>{$quest->getDescricao()}</td>";
            echo "<td>{$formattedDate}</td>";
            echo "<td>{$elab->getNome()}</td>";

            echo "<td>";
            echo "<a href='AvaliarSubmissao.php?questionarioId={$quest->getId()}&submissaoId={$submissao->getId()}' class='btn btn-info'>";
            echo "<span class='glyphicon glyphicon-edit'></span> Avaliar";
            echo "</a>";
            echo "</td>"; 

            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p style='text-align: center; margin-top: 10%'>Não há nenhum resultado aguardando por avaliação para esse aluno</p>";
    }
    echo "</section>";
    include_once "LayoutFooter.php";
?>
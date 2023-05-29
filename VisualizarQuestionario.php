<?php 
    include_once 'verificaElaborador.php';

    $titulo = "Visualizando Questionário";
    include_once 'LayoutHeader.php';
    include_once 'Fachada.php';

    $questionarioId = $_GET['qId'];
    if (!isset($questionarioId)){
        header("Location: ControleQuestionarios.php");
        exit();
    }

    $daoQuestionario = $factory->getQuestionarioDao();
    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();
    
    $questionario = $daoQuestionario->buscaPorId($questionarioId);
    $questoes = $daoQuestionarioQuestao->buscaQuestoesPorQuestionarioId($questionarioId);

    if ($questionario->getElaborador() != $_SESSION['id_usuario']){
        header("Location: ControleQuestionarios.php");
        exit("Você não tem permissão para visualizar esse questionário.");
    }
?>

<div class="d-flex justify-content-center">
    <div class="d-flex flex-column">
        <div class="container-fluid">
            <h2 class="text-center pt-5 p-3"><?=$questionario->getNome()?></h2>
            <h3 class="text-center"><?= $questionario->getDescricao() ?></h3>
        </div>

        <div class="d-flex rounded-2 flex-column bg-body-secondary border p-2 mt-5 shadow-sm">   
            <div class="align-self-center">
                <span class="fw-semibold fs-5"><?="Nota de aprovação: {$questionario->getNotaAprovacao()}"?></span>
            </div>
        </div>
    </div>
</div>

<main>
    <section class="mt-5 questionario">
        <?php
            for ($i = 0; $i < count($questoes); $i++){
                $questao = $questoes[$i];
                $idQ = $questao->getId();
                $caminhoImagem = "public/uploads/".$questoes[$i]->getImagem();

                $alternativas = $daoAlternativa->buscaPorQuestaoId($idQ); 
                $qq = $daoQuestionarioQuestao->buscaPorQuestionarioEQuestao($questionarioId, $idQ);

                echo '<div class="container-fluid my-3 py-4 questao" id="'.$idQ.'">';
                echo    '<div class="card mx-auto" style="max-width:700px">';    
                echo    '<div class="card-header bg-body-secondary">';
                echo        '<span class="mx-1 fw-bold">('.$qq->getPontos().') pts -</span>';
                echo        '<span class="fw-bold"> Questão '.($i + 1).': </span>';
                echo        '<p class="d-inline">'.$questao->getDescricao().'</p>';

                if (file_exists($caminhoImagem)){
                echo '          <div>';
                echo '              <img img-fluid width=250 class="m-5 img-fluid rounded mx-auto d-block" src="'.$caminhoImagem.'">';
                echo '          </div>';
                }

                echo    '</div>';
                echo    '<div class="card-body bg-light">';

                if ($questao->getIsMultiplaEscolha() || $questao->getIsObjetiva()) {
                    $tipo = $questao->getIsMultiplaEscolha() ? 'checkbox' : 'radio';

                    for ($j = 0; $j < count($alternativas); $j++){
                        $checked = $alternativas[$j]->getIsCorreta() ? 'checked' : '';
                        $idA = $alternativas[$j]->getId();
                        
                        echo "
                            <div class=\"form-check justify-content-center\">
                                <label class=\"form-check-label\" for=\"$idA\">
                                    <input class=\"selecionavel form-check-input\" id=\"$idA\" type=\"$tipo\" disabled $checked>
                                    {$alternativas[$j]->getDescricao()} 
                                </label>                       
                            </div>
                             ";
                    }

                } else {
                    echo '<textarea class="discursiva form-control" cols="30" rows="1" disabled></textarea>';
                }

                echo '      </div>';
                echo '   </div>';
                echo '</div>';
            }
        ?>
        <div class="d-flex justify-content-center">
            <a href="ListaOfertas.php" id="btn-retornar" class="btn btn-primary btn-lg m-4 mx-auto float-center">Retornar</a>
        </div>
    </section>
</main>

<?php include_once 'LayoutFooter.php' ?>
<?php 
    include_once 'verificaUsuarios.php';

    // verifica se é o respondente que está logado

    $titulo = "Visualizando Respostas";
    include_once 'LayoutHeader.php';
    include_once 'Fachada.php';

    // passar id questionario e submissao
    $respondenteId = $_SESSION['id_usuario'];
    $submissaoId = $_GET['submissaoId'];
    $questionarioId = $_GET['questionarioId'];
    $questionarioId = 9; // REMOVER, temporário p/ visualização até linkar tudo!
    $submissaoId = 328; // TEMPORÁRIO, REMOVER

    // DAOs
    $daoQuestionario = $factory->getQuestionarioDao();
    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();
    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();

    $daoSubmissao = $factory->getSubmissaoDao();
    $daoResposta = $factory->getRespostaDao();
    $daoRespostaAlternativa = $factory->getRespostaAlternativaDao();

    // Questionário
    $questionario = $daoQuestionario->buscaPorId($questionarioId);

    // Todas as Respostas da Submissão
    $respostas = $daoResposta->buscaPorSubmissaoId($submissaoId);

    // Array de Todas as RespostaAlternativas das Respostas
    $respostasAlternativas = [];
    foreach ($respostas as $r) {
        $respostasAlternativas[] = $daoRespostaAlternativa->buscaPorRespostaId($r->getId());
    }

    // Todas as Questoes do Questionário
    $questoes = $daoQuestionarioQuestao->buscaQuestoesPorQuestionarioId($questionarioId);


    // // array de id das alternativas marcadas
    // foreach($respostasAlternativas as $ra){
    //     foreach($ra as $a){
    //         $idAltsMarcadas[] = $a->getAlternativa();
    //     }
    // }

    // submissao 328
    // respostasID: 945 946 947
    // Alternativas:                ME(945)  287 288 289    ||||    OBJ(946) 293      |||      DISC(947) X 
    // RespostaAlternativas:            278, 279, 280       ||||         281          |||          X


    // // QuestionarioQuestões da Submissão
    // $questionarioQuestoes = $daoResposta->buscaQuestionarioQuestoesPorSubmissaoId($submissaoId, $questionarioId);
    foreach ($questionarioQuestoes as $qq) {
        $id = $qq->getQuestao();
        $qq->setQuestao($daoQuestao->buscaPorId($qq->getQuestao()));
    }

?>

<div class="container-fluid">
    <h2 class="text-center pt-5 p-3"><?= $questionario->getNome() ?></h2>
    <h3 class="text-center"><?= $questionario->getDescricao() ?></h3>
</div>

<main>
    <section class="mt-5 questionario">
        <?php
            for ($i = 0; $i < count($questoes); $i++){
                $questao = $questoes[$i];
                $idQ = $questao->getId();

                // array de alternativas da questão
                $alternativas = $daoAlternativa->buscaPorQuestaoId($idQ); 

                // array de alternativas corretas
                $altsCorretas = $daoAlternativa->buscaCorretasPorQuestaoId($idQ);

                // array de ids corretos
                $idsCorretas = [];
                foreach($altsCorretas as $alts){
                    $idsCorretas[] = $alts->getId();
                }

                // resposta e alternativas para a atual questão
                $respostaQuestao = $daoResposta->buscaPorQuestaoESubmissaoId($idQ, $submissaoId);
                $respostaId = $respostaQuestao->getId();
                $alternativasRespondidas = $daoRespostaAlternativa->buscaAlternativasPorRespostaId($respostaId);
                $qq = $daoQuestionarioQuestao->buscaPorQuestionarioEQuestao($questionarioId, $idQ);

                // to jogando tudo no mesmo array, acho q nao é assim
                $idsAltsRespondidas = [];
                foreach ($alternativasRespondidas as $ars) {
                    $idsAltsRespondidas[] = $ars->getId();
                }

                $nota = $respostaQuestao->getNota() == null ? '?' : $respostaQuestao->getNota();

                echo '<div class="container-fluid my-3 py-4 questao" id="'.$idQ.'">';
                echo    '<div class="card mx-auto" style="max-width:700px">';    
                echo    '<div class="card-header bg-body-secondary">';
                echo        '<span class="mx-1 fw-bold ">('.$nota.' / '.$qq->getPontos().') pts -</span>';
                echo        '<span class="fw-bold"> Questão '.($i + 1).': </span>';
                echo        '<p class="d-inline">'.$questao->getDescricao().'</p>';
                echo    '</div>';
                echo    '<div class="card-body bg-light">';

                if ($questao->getIsMultiplaEscolha() || $questao->getIsObjetiva()) {
                    $tipo = $questao->getIsMultiplaEscolha() ? 'checkbox' : 'radio';

                    for ($j = 0; $j < count($alternativas); $j++){
                       // $isCorreta = $alternativas[$j]->getIsCorreta();
                       // $respostasAlternativas
                        $checked = '';
                        $styleClass = '';

                        if (in_array($alternativas[$j]->getId(), $idsAltsRespondidas)) {
                            $checked = 'checked';
                        }

                        if (in_array($alternativas[$j]->getId(), $idsAltsRespondidas) && $alternativas[$j]->getIsCorreta()){
                            $styleClass = 'rounded-2 bg-success-subtle fw-bold"';
                        }

                        if (!in_array($alternativas[$j]->getId(), $idsAltsRespondidas) && $alternativas[$j]->getIsCorreta()){
                            $styleClass = 'rounded-2 bg-success-subtle text-success-emphasis"';
                        }

                        if (in_array($alternativas[$j]->getId(), $idsAltsRespondidas) && !$alternativas[$j]->getIsCorreta()){
                            $styleClass = 'rounded-2 bg-danger-subtle fw-bold text-danger-emphasis"';
                        }

                        
                        $idA = $alternativas[$j]->getId();
                        $id = "q{$idQ}a{$idA}";

                        $inpt = '<input class="selecionavel form-check-input" type="'.$tipo.'" 
                                name="'.$idQ.'" id="'.$idA.'" value="1" disabled '.$checked.'>';

                        $all = '<label class="form-check-label '.$styleClass.'" for="'.$idA.'" checked>' 
                                . $inpt . $alternativas[$j]->getDescricao() . 
                                '</label>';
                        
                        echo '<div class="form-check justify-content-center">';
                        echo $all;
                        echo '</div>';
                    }
                }
                else {
                    echo '<textarea class="discursiva form-control" name="respostas['.$questao->getId().']['.(-1).']" 
                         id="'.$questao->getId().'" cols="30" rows="5" disabled>'.$respostaQuestao->getTexto().'</textarea>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        ?>

        <div class="d-flex justify-content-center">
            <a href="Menu.php" id="btn-retornar" class="btn btn-primary btn-lg m-4 mx-auto float-center">Retornar</a>
        </div>
    </section>
</main>

<?php include_once 'LayoutFooter.php' ?>
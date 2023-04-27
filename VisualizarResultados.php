<?php 
    $titulo = "Visualizando Respostas";
    include_once 'LayoutHeader.php';
    include_once 'verificaUsuarios.php';
    include_once 'Fachada.php';

    // passar id questionario e submissao
    $respondenteId = $_SESSION['id_usuario'];
    $submissaoId = $_GET['submissaoId'];
    $questionarioId = $_GET['questionarioId'];
    $questionarioId = 9; // REMOVER, temporário p/ visualização até linkar tudo!
    $submissaoId = 4; // TEMPORÁRIO, REMOVER

    // DAOs
    $daoQuestionario = $factory->getQuestionarioDao();
    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();
    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();
    $daoSubmissao = $factory->getSubmissaoDao();
    $daoResposta = $factory->getRespostaDao();
    $daoRespostaAlternativa = $factory->getRespostaAlternativaDao();

    $questionario = $daoQuestionario->buscaPorId($questionarioId);
    // Respostas da Submissão
    $respostas = $daoResposta->buscaPorSubmissaoId($submissaoId);
    // Questoes do Questionário da Submissão
    $questoes = $daoQuestionarioQuestao->buscaQuestoesPorQuestionarioId($questionarioId);
    
    $alternativas = array();
    $respostasAlternativas = array();
    
    foreach ($respostas as $r){
        // Resposta alternativas
        $respostasAlternativas[] = $daoRespostaAlternativa->buscaPorRespostaId($r->getId());
        //$alternativas[] = $daoRespostaAlternativa->buscaAlternativasPorRespostaId($r);
    }
    var_dump($respostas);



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
            for ($i = 0; $i < count($questionarioQuestoes); $i++){
                $questao = $questionarioQuestoes[$i]->getQuestao();
                $alternativas = $daoAlternativa->buscaPorQuestaoId($questao->getId()); 
                $idQ = $questao->getId();
                
                echo '<div class="container-fluid my-3 py-4 questao" id="'.$idQ.'">';
                echo '<div class="card mx-auto" style="max-width:700px">';    
                echo '<div class="card-header bg-body-secondary"><span class="fw-bold"> Questão '.($i + 1).': </span>'.$questao->getDescricao().'</div>';
                echo '<div class="card-body bg-light">';

                if (count($alternativas) > 0) {
                    $tipo = $questao->getIsMultiplaEscolha() ? 'checkbox' : 'radio';

                    for ($j = 0; $j < count($alternativas); $j++){
                        $idA = $alternativas[$j]->getId();
                        $id = "q{$idQ}a{$idA}";

                        $inpt = '<input class="selecionavel form-check-input" type="'.$tipo.'" 
                                name="'.$idQ.'" id="'.$idA.'" value="1" disabled checked>';

                        $all = '<label class="form-check-label" for="'.$idA.'" checked>' 
                                . $inpt . $alternativas[$j]->getDescricao() . 
                                '</label>';
                        
                        echo '<div class="form-check justify-content-center">';
                        echo $all;
                        echo '</div>';
                    }
                }
                else {
                    echo '<textarea class="discursiva form-control" name="respostas['.$questao->getId().']['.(-1).']" 
                         id="'.$questao->getId().'" cols="30" rows="5" disabled></textarea>';
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
<?php 
    // pagina p/ responder um questionario
    $titulo = "Questionário";
    include_once 'LayoutHeader.php';
    include_once 'verificaUsuarios.php';
    include_once 'Fachada.php';

    $questionarioId = $_POST['questionarioId'];
    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();
    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();

    // pegar id do questionario, usando temporario
    $questionarioQuestoes = $daoQuestionarioQuestao->buscaPorQuestionario(9);

    $questoes = array();
    foreach ($questionarioQuestoes as $qq){
        $id = $qq->getQuestao();
        //$questoes[] = $daoQuestao->buscaPorId($id);
        $qq->setQuestao($daoQuestao->buscaPorId($qq->getQuestao()));
    }
?>

<main>
    <section class="mt-5 questionario">
        <form action="EnviarQuestionario.php" method="POST" name="envio-questionario">
        <?php
            for ($i = 0; $i < count($questionarioQuestoes); $i++){
                $questao = $questionarioQuestoes[$i]->getQuestao();
                $alternativas = $daoAlternativa->buscaPorQuestaoId($questao->getId()); 
                
                echo '<div class="container-fluid my-3 py-4 questao">';
                echo '<div class="card mx-auto" style="max-width:700px">';    
                echo '<div class="card-header bg-body-secondary"><span class="fw-bold"> Questão '.($i + 1).': </span>'.$questao->getDescricao().'</div>';
                echo '<div class="card-body bg-light">';

                    
                $nome = 'q'.($i + 1).'';
                if (count($alternativas) > 0) {
                    $tipo = $questao->getIsMultiplaEscolha() ? 'checkbox' : 'radio';

                    for ($j = 0; $j < count($alternativas); $j++){
                        $id = 'q'.($i + 1).'a'.($j + 1).'';
                        // $inpt = '<input class="form-check-input" type="'.$tipo.'" name="'.$nome.'" id="'.$id.'">';
                        // $all = '<label class="form-check-label" for="'.$nome.'">' . $inpt . $alternativas[$j]->getDescricao() . '</label>';
                        $inpt = '<input class="form-check-input" type="'.$tipo.'" name="respostas['.$questao->getId().']['.$alternativas[$j]->getId().']" id="'.$id.'" value="1">';
                        $all = '<label class="form-check-label" for="'.$id.'">' . $inpt . $alternativas[$j]->getDescricao() . '</label>';
                        
                        echo '<div id="'.$questao->getId().'" class="form-check justify-content-center">';
                        echo "$all";
                        echo '</div>';
                    }
                }
                else {
                    echo '<textarea class="form-control" name="respostas['.$questao->getId().']['.(-1).']" id="'.$questao->getId().'" cols="30" rows="5"></textarea>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        ?>
        <div class="d-flex justify-content-center">
            <input type="submit" value="Enviar questionário" class="btn btn-primary btn-lg m-4 mx-auto float-center">
        </div>
        </form>
    </section>


</main>

<?php include_once 'LayoutFooter.php' ?>
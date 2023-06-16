<?php 
    $titulo = "Avaliação";
    include_once 'verificaElaborador.php';
    include_once 'LayoutHeader.php';
    include_once 'Fachada.php';

    // verificar se o elaborador pode estar vendo essa oferta

    $respondenteId = $_SESSION['id_usuario'];
    $submissaoId = $_GET['submissaoId'];
    $questionarioId = $_GET['questionarioId'];

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
    $qqs = $daoQuestionarioQuestao->buscaPorQuestionario($questionarioId);
    $notaSomada = 0;
    $notaObtida = 0;
    foreach ($qqs as $qq) {
        $notaSomada += $qq->getPontos();
    }

    foreach($respostas as $resp)
    {
        $notaObtida += $resp->getNota();
    }

    if ($questionario->getNotaAprovacao() > $notaObtida){
        $status = '<span class="d-block fs-3 fw-bold text-danger-emphasis text-center">Reprovado</span>';
    } else {
        $status = '<span class="d-block fs-3 fw-bold text-success-emphasis text-center">Aprovado</span>';
    }

    $questoes = $daoQuestionarioQuestao->buscaQuestoesPorQuestionarioId($questionarioId);
    $questoes = array_filter($questoes, function($val){
        return $val->getIsDiscursiva();
    });
    $questoes = array_values($questoes);;

    $data = $daoSubmissao->buscaPorId($submissaoId)->getData();
?>

<div class="d-flex justify-content-center">
    <div class="d-flex flex-column">
        <div class="container-fluid">
            <h2 class="text-center pt-5 p-3"><?=$questionario->getNome()?></h2>
            <h3 class="text-center"><?= $questionario->getDescricao() ?></h3>
        </div>

        <div class="d-flex rounded-2 flex-column bg-body-secondary border p-2 mt-5 shadow-sm">   
            <div class="justify-content-start">
                <p class="fw-semibold fs-5"><?="Nota: {$notaObtida} de {$notaSomada}<br>
                Nota de aprovação: {$questionario->getNotaAprovacao()}"?></p>
                <span class="">Enviado: <?=$data?></span>
                <?=$status?>
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

                // array de ids de alternativas marcadas
                $idsAltsRespondidas = [];
                foreach ($alternativasRespondidas as $ars) {
                    $idsAltsRespondidas[] = $ars->getId();
                }

                $nota = $respostaQuestao->getNota() == null ? '?' : $respostaQuestao->getNota();
                
                echo '<form action="AvaliaSubmissao.php?submissaoId='.$submissaoId.'" method="post">';
                echo '<div class="container-fluid my-3 py-4 questao" id="'.$idQ.'">';
                echo '<div class="card mx-auto" style="max-width:700px">';    
                echo '<div class="card-header bg-body-secondary">';
                echo '<span class="mx-1 fw-bold ">('.$nota.' / '.$qq->getPontos().') pts -</span>';
                echo '<span class="fw-bold"> Questão '.($i + 1).': </span>';
                echo '<p class="d-inline">'.$questao->getDescricao().'</p>';

                if (is_file($caminhoImagem) && file_exists($caminhoImagem)){
                echo '<div>';
                echo '<img img-fluid width=250 class="m-5 img-fluid rounded mx-auto d-block" src="'.$caminhoImagem.'">';
                echo '</div>';
                }

                echo '</div>';
                echo '<div class="card-body bg-light">';    
                echo '  <div class="">';
                echo '      <textarea class="discursiva form-control" 
                            id="'.$questao->getId().'" cols="30" rows="5" disabled>'.$respostaQuestao->getTexto().'</textarea>';
                echo '  </div>';
                echo '  <div class="d-flex flex-row justify-content-between pt-4">';
                echo '      <div class="">';
                echo '          <label for="respostas['.$respostaQuestao->getId().'][comentario]" class="form-label">Comentários</label>';
                echo '          <textarea class="comentario form-control" name="respostas['.$respostaQuestao->getId().'][comentario]" rows="3" cols="50"></textarea>';
                echo '      </div>';
                echo '      <div class="w-25 ms-3 d-flex flex-column">';
                echo '          <label for="respostas['.$respostaQuestao->getId().'][nota]" class="form-label">Nota</label>';
                echo '          <input type="number" class="nota form-control align-self-start" name="respostas['.$respostaQuestao->getId().'][nota]" 
                min="0" max="'.$qq->getPontos().'" step=".01" required></input>';
                echo '          <span class="text-secondary">(0 ... '.$qq->getPontos().')</span>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

            }
        ?>

        <div class="d-flex justify-content-center">
            <input type="submit" id="btn-retornar" class="btn btn-primary btn-lg m-4 mx-auto float-center" value="Enviar avaliação">
        </div>
        
        </form>

    </section>
</main>

<?php include_once 'LayoutFooter.php' ?>
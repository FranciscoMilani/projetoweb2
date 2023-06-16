<?php 
    $titulo = "Questionário";
    include_once 'LayoutHeader.php';
    include_once 'verificaRespondente.php';
    include_once 'Fachada.php';

    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();
    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();
    $daoSubmissao = $factory->getSubmissaoDao();
    
    $respondenteId = $_SESSION['id_usuario'];
    $ofertaId = $_GET['ofertaId'];
    $questionarioId = $_GET['questId'];
    $questionarioQuestoes = $daoQuestionarioQuestao->buscaPorQuestionario($questionarioId);
    
    // verifica se já foi respondido
    $subExist = $daoSubmissao->buscaPorOfertaRespondenteId($ofertaId, $respondenteId);
    if ($subExist){
        header('Location: ListaOfertas.php');
        exit;
    }

    $questoes = array();
    foreach ($questionarioQuestoes as $qq){
        $id = $qq->getQuestao();
        $qq->setQuestao($daoQuestao->buscaPorId($qq->getQuestao()));
    }
?>

<script type="text/javascript">
    var submitting = false;

    $(document).ready(function(){
        
        $('#enviar-questionario').click(function(evento){
            if (submitting){
                return false;
            }
            console.log('Submetendo questionário...');
            submitting = true;

            var discursivaArr = [];
            var selecionavelArr = [];
            
            $('.questao').each(function(){  
                var alternativas = [];
                var idQuestao;
                
                idQuestao = $(this).attr('id');
                if($(this).find('.selecionavel').length){
                    $(this).find('.selecionavel:checked').each(function(){
                        var idAlternativa = $(this).attr('id');
                        alternativas.push(idAlternativa);
                    });

                    selecionavelArr.push({idQuestao, alternativas});
                } else {
                    $(this).find('.discursiva').each(function(){
                        var val = $(this).val();
                        discursivaArr.push({idQuestao, val});
                    })
                }

            });

            data = {
                ofertaId: <?=$ofertaId?>,
                questionarioId: <?=$questionarioId?>,
                selecionaveis: selecionavelArr,
                discursivas: discursivaArr
            }

            jsonData = JSON.stringify(data, null, 2);

            $.ajax({
                url: 'EnviarQuestionario.php',
                type: 'POST',
                contentType: 'application/json', //sending
                dataType: 'text', // expecting
                data: jsonData,
                success: function(msg){
                    console.log(msg); 
                }, 
                error: function(a, b, err){
                    console.log(err);
                }
            })
            .done(function(){
                console.log('done')
                window.location.href = 'ListaOfertas.php';
            })
        });
    });

</script>

<main>
    <section class="mt-5 questionario">
        <!--<form method="POST" name="envio-questionario" id="envio-form">-->
        <?php
            for ($i = 0; $i < count($questionarioQuestoes); $i++){
                $questao = $questionarioQuestoes[$i]->getQuestao();
                $caminhoImagem = "public/uploads/".$questao->getImagem();
                $alternativas = $daoAlternativa->buscaPorQuestaoId($questao->getId()); 
                $idQ = $questao->getId();
                
                echo '<div class="container-fluid my-3 py-4 questao" id="'.$idQ.'">';
                echo '<div class="card mx-auto" style="max-width:700px">';
                echo '<div class="card-header bg-body-secondary">';
                echo '<span class="fw-bold"> Questão '.($i + 1).': </span>';

                echo $questao->getDescricao(); 
                if (is_file($caminhoImagem) && file_exists($caminhoImagem)){
                echo '<div>';
                echo '<img img-fluid width=250 class="m-5 img-fluid rounded mx-auto d-block" src="'.$caminhoImagem.'">';
                echo '</div>';
                }

                echo '</div>';
                echo '<div class="card-body bg-light">';

                if (count($alternativas) > 0) {
                    $tipo = $questao->getIsMultiplaEscolha() ? 'checkbox' : 'radio';

                    for ($j = 0; $j < count($alternativas); $j++){
                        $idA = $alternativas[$j]->getId();
                        $id = "q{$idQ}a{$idA}";

                        $inpt = '<input class="selecionavel form-check-input" type="'.$tipo.'" name="'.$idQ.'" id="'.$idA.'" value="1">';
                        $all = '<label class="form-check-label" for="'.$idA.'">' . $inpt . $alternativas[$j]->getDescricao() . '</label>';
                        
                        echo '<div class="form-check justify-content-center">';
                        echo $all;
                        echo '</div>';
                    }
                }
                else {
                    echo '<textarea class="discursiva form-control" name="respostas['.$questao->getId().']['.(-1).']" id="'.$questao->getId().'" cols="30" rows="5"></textarea>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        ?>

        <div class="d-flex justify-content-center">
            <!--<input type="submit" value="Enviar questionário" id="enviar-form" class="btn btn-primary btn-lg m-4 mx-auto float-center">-->
            <a type="button" id="enviar-questionario" class="btn btn-primary btn-lg m-4 mx-auto float-center">Enviar questionário<a>
        </div>
        <!--</form>-->
    </section>


</main>

<?php include_once 'LayoutFooter.php' ?>
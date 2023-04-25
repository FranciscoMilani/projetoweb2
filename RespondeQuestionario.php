<?php 

    $titulo = "Questionário";
    include_once 'LayoutHeader.php';
    include_once 'verificaUsuarios.php';
    include_once 'Fachada.php';

    $questionarioId = $_POST['questionarioId'];
    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();
    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();
    
    //validar se oferta existe
    //$daoOferta = $factory->getOfertaDao();
    
    
    // REMOVER!
    $questionarioId = 9;  //                   REMOVER temporario pra teste!!!
    $questionarioQuestoes = $daoQuestionarioQuestao->buscaPorQuestionario($questionarioId);
    
    $questoes = array();
    foreach ($questionarioQuestoes as $qq){
        $id = $qq->getQuestao();
        $qq->setQuestao($daoQuestao->buscaPorId($qq->getQuestao()));
    }
?>

<script type="text/javascript">

    $(document).ready(function(){
        $('#enviar-form').click(function(evento){
            evento.preventDefault();

            var dadosArr = []
            var discursivaArr = [];
            var selecionavelArr = [];

            dadosArr.push({idQuestionario:<?=$questionarioId?>});
            
            $('.questao').each(function(){  
                var alternativas = [];
                var idQuestao;
                
                idQuestao = $(this).attr('id');

                $(this).find('.selecionavel:checked').each(function(){
                    var idAlternativa = $(this).attr('id');
                    alternativas.push(idAlternativa);
                });

                $(this).find('.discursiva').each(function(){
                    var val = $(this).val();
                    discursivaArr.push({idQuestao, val});
                })

                selecionavelArr.push({idQuestao, alternativas});
            });

            data = {
                dados: dadosArr,
                selecionaveis: selecionavelArr,
                discursivas: discursivaArr
            }

            jsonData = JSON.stringify(data, null,  2);
            //console.log(jsonData);

            $.ajax({
                url: 'EnviarQuestionario.php',
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: jsonData,
                success: function(msg){
                    //window.location = 'EnviarQuestionario.php';
                }, 
                error: function(){
                    //window.location = 'EnviarQuestionario.php';
                }
            }).done(function(){
                //window.location = 'EnviarQuestionario.php';
            })
        });
    });

</script>

<main>
    <section class="mt-5 questionario">
        <form method="POST" name="envio-questionario" id="envio-form">
        <?php
            for ($i = 0; $i < count($questionarioQuestoes); $i++){
                $questao = $questionarioQuestoes[$i]->getQuestao();
                $alternativas = $daoAlternativa->buscaPorQuestaoId($questao->getId()); 
                $idQ = $questao->getId();
                
                echo '<div class="container-fluid my-3 py-4 questao" id="'.$idQ.'">';
                echo '<div class="card mx-auto" style="max-width:700px">';    
                echo '<div class="card-header bg-body-secondary"><span class="fw-bold"> Questão '.($i + 1).': </span>'.$questao->getDescricao().'</div>';
                echo '<div class="card-body bg-light">';

                    
                //$nome = 'q'.($i + 1).'';
                if (count($alternativas) > 0) {
                    $tipo = $questao->getIsMultiplaEscolha() ? 'checkbox' : 'radio';

                    for ($j = 0; $j < count($alternativas); $j++){
                        //$id = 'q'.($i + 1).'a'.($j + 1).'';
                        $idA = $alternativas[$j]->getId();
                        $id = "q{$idQ}a{$idA}";

                        // $inpt = '<input class="form-check-input" type="'.$tipo.'" name="'.$nome.'" id="'.$id.'">';
                        // $all = '<label class="form-check-label" for="'.$nome.'">' . $inpt . $alternativas[$j]->getDescricao() . '</label>';
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
            <input type="submit" value="Enviar questionário" id="enviar-form" class="btn btn-primary btn-lg m-4 mx-auto float-center">
        </div>
        </form>
    </section>


</main>

<?php include_once 'LayoutFooter.php' ?>
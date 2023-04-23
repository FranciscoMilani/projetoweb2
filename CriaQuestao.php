<?php 
    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';
    
    $descricao = $_POST['descricao'];
    $tipoquestao = $_POST['tipoquestao'];

    if ($tipoquestao == "discursiva"){
        // discursiva
        $questao = new Questao(null, $descricao, true, false, false);
    } else if ($tipoquestao == "selecionavel"){
        if (!empty($questao)){
            if (count($questao) >= 2){
                // multipla escolha
                $questao = new Questao(null, $descricao, false, false, true);
            } else {
                // objetiva
                $questao = new Questao(null, $descricao, false, true, false);
            }

            $questao->setAlternativas($alternativasCriadas);
        }
    }

    $alternativas[] = $_POST['alternativa1'];
    $alternativas[] = $_POST['alternativa2'];
    $alternativas[] = $_POST['alternativa3'];
    $alternativas[] = $_POST['alternativa4'];
    $alternativas[] = $_POST['alternativa5'];
    $alternativasTexto = $_POST['alternativaTexto'];
    
    $alternativas = array();
    $alternativasCriadas = array();

    $daoQ = $factory->getQuestaoDao();
    $daoA = $factory->getAlternativaDao();

    var_dump( $alternativas );
    var_dump( $alternativasTexto );

    for ($i = 0; $i < count($alternativas); $i++){
        $alternativaTemp = new Alternativa(null, $alternativasTexto[$i], $alternativas[$i]);
        $alternativasCriadas[] = $alternativaTemp;
        $daoA->insere($alternativaTemp);
    }
    

    verificaVariaveis($_POST);
    $daoQ->insere($questao);

    function verificaVariaveis($vars) {
        foreach ($vars as $variavel){
            if (!isset($variavel) || empty($variavel)) {
               // header('Location: CriacaoQuestao.php');
               // exit;
            }
        }
    }


    //header('Location: CriacaoQuestao.php');
    //exit;
?>
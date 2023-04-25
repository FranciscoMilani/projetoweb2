<?php 
    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';
    
    $descricao = $_POST['descricao'];
    $tipoquestao = $_POST['tipoquestao'];
    
    $alternativasCriadas = array();
    $alternativas = array();
    $alternativas[] = $_POST['alternativa1'];
    $alternativas[] = $_POST['alternativa2'];
    $alternativas[] = $_POST['alternativa3'];
    $alternativas[] = $_POST['alternativa4'];
    $alternativas[] = $_POST['alternativa5'];
    $alternativasTexto = $_POST['alternativaTexto'];

    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();

    if ($tipoquestao == "discursiva"){
        $questao = new Questao(null, $descricao, 1, 0, 0);
        $questaoId = $daoQuestao->insere($questao);
        
    } else if ($tipoquestao == "selecionavel"){
        var_dump($alternativas);

        $arr = array_count_values($alternativas);
        $qtd = $arr[1];

        if (!empty($alternativas)) {
            if ($qtd >= 2){
                // multipla escolha
                $questao = new Questao(null, $descricao, 0, 0, 1);
            } else {
                // objetiva
                $questao = new Questao(null, $descricao, 0, 1, 0);
            }
            
            $questao->setId($daoQuestao->insere($questao));
            
            for ($i = 0; $i < count($alternativas); $i++){
                //$isCorreta = (bool) $alternativas[$i];
                $alternativaTemp = new Alternativa(null, $alternativasTexto[$i], $alternativas[$i], $questao);
                $alternativasCriadas[] = $alternativaTemp;
                $daoAlternativa->insere($alternativaTemp);
            }
    
            $questao->setAlternativas($alternativasCriadas);
        }
    }
    
   header('Location: CriacaoQuestao.php');
   exit;

    // verificaVariaveis($_POST);

    // function verificaVariaveis($vars) {
    //     foreach ($vars as $variavel){
    //         if (!isset($variavel) || empty($variavel)) {
    //            // header('Location: CriacaoQuestao.php');
    //            // exit;
    //         }
    //     }
    // }
    
?>
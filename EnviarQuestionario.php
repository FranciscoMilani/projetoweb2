<?php 
    include_once 'verificaUsuarios.php';
    include_once 'Fachada.php';

    $dadosJson = file_get_contents('php://input');
    $dados = json_decode($dadosJson, true);

    $respostaDao = $factory->getRespostaDao();
    $questaoDao = $factory->getQuestaoDao();
    $questionarioQuestaoDao = $factory->getQuestionarioQuestaoDao();
    
    $idQuestionario = $dados['idQuestionario'];
    $selecionaveis = $dados['selecionaveis'];
    $discursivas = $dados['discursivas'];
    
    // validar se oferta existe aqui?
    // validar se o questionario é o mesmo da oferta

    
    foreach($selecionaveis as $s){
        $qq = $questionarioQuestaoDao->buscaPorQuestionarioEQuestao($idQuestionario, $s['idQuestao']);
        var_dump($idQuestionario);
        if ($qq != null){
            $r = new Resposta(null, null, $qq->getPontos(), null, $s['alternativas'], $s['idQuestao'], null);
            $respostaDao->insere($r);
        } else {
            echo 'nulo';
        }
    }

    foreach($discursivas as $d){
        $qq = $questionarioQuestaoDao->buscaPorQuestionarioEQuestao($idQuestionario, $s['idQuestao']);
        if ($qq != null){
            $r = new Resposta(null, null, $qq->getPontos(), null, null, $s['idQuestao'], null);
            $respostaDao->insere($r);
        } else {
            echo 'nulo';
        }
    }

?>
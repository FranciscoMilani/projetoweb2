<?php 
    include_once 'verificaUsuarios.php';
    include_once 'Fachada.php';

    $dadosJson = file_get_contents('php://input');

    $respostaDao = $factory->getRespostaDao();
    $questaoDao = $factory->getQuestaoDao();
    $questionarioQuestaoDao = $factory->getQuestionarioQuestaoDao();
    //$alternativaDao = $factory->getAlternativaDao();

    //$questionarioQuestaoDao->buscaPorQuestionarioEQuestao();

    $dados = json_decode($dadosJson, true);

    $dadosRnd = $dados['dados'];
    $selecionaveis = $dados['selecionaveis'];
    $discursivas = $dados['discursivas'];

    foreach($selecionaveis as $s){
        //$r = new Resposta(null, null, $s);
       // $respostaDao->insere();
        var_dump($s['idQuestao']);
    }

    // $resDao = $factory->getRespostaDao();
    // $questaoDao = $factory->getQuestaoDao();
    // $respostasObj = array();
    // foreach ($respostasArr as $r){
    //     $idQuestao = array_search($r, $respostasPost);
    // //    $respostasObj[] =  
    // }

    // //new Resposta(null, );
    // // valida se oferta existe aqui?
    // // valida se o questionario é o mesmo da oferta
    // // id (-1) da questao é discursiva n tem alternativa

    // foreach ($respostasArr as $r){
    //     $idQuestao = array_search($r, $respostasPost);
        
    // }
?>
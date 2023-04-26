<?php 
    include_once 'verificaUsuarios.php';
    include_once 'Fachada.php';
    
    $dadosJson = file_get_contents('php://input');
    $dados = json_decode($dadosJson, true);
    
    $idQuestionario = $dados['idQuestionario'];
    $selecionaveis = $dados['selecionaveis'];
    $discursivas = $dados['discursivas'];
    
    // validar se oferta existe aqui
    // validar se o questionario é o mesmo da oferta
    // validar se a oferta ja foi submetida por respondente
    // pegar id da oferta atendida para passar para a submissao

    if (!isset($idQuestionario)){
        header('Location: Menu.php');
        exit;
    }

    $respostaDao = $factory->getRespostaDao();
    $questaoDao = $factory->getQuestaoDao();
    $questionarioQuestaoDao = $factory->getQuestionarioQuestaoDao();
    $respAltDao = $factory->getRespostaAlternativaDao();
    $submissaoDao = $factory->getSubmissaoDao();


    // nao precisa passar data pq o sql faz o trabalho de obter a data.
    // pensar se precisa fazer uma transaction aqui e passar tudo no dao da submissao?
    $submissao = new Submissao(null, "Nome Ocasião", "Descrição da submissão.", null, 1); // passar ofertaId qndo criação de ofertas estiver pronto
    $subId = $submissaoDao->insere($submissao);

    
    foreach($selecionaveis as $s){
        $alternativas = $s['alternativas'];
        $questao = $s['idQuestao'];

        $qq = $questionarioQuestaoDao->buscaPorQuestionarioEQuestao($idQuestionario, $questao);
        if ($qq != null){
            $r = new Resposta(null, null, $qq->getPontos(), null, $questao, $subId); // !! Passar id submissao aqui
            $idR = $respostaDao->insere($r);
            
            foreach ($alternativas as $idA){
                $ra = new RespostaAlternativa(null, $idR, $idA);
                $respAltDao->insere($ra);
            }    
        }
    }

    foreach($discursivas as $d){
        $texto = $d['val'];
        $questao = $d['idQuestao'];

        $qq = $questionarioQuestaoDao->buscaPorQuestionarioEQuestao($idQuestionario, $questao);
        if ($qq != null){
            $r = new Resposta(null, $texto, $qq->getPontos(), null, $questao, $subId); // !! Passar id submissao aqui
            $respostaDao->insere($r);
        }
    }

    header('Location: Menu.php');

?>
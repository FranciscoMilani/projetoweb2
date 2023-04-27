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
    $alternativaDao = $factory->getAlternativaDao();


    // nao precisa passar data pq o sql faz o trabalho de obter a data.
    // pensar se precisa fazer uma transaction aqui e passar tudo no dao da submissao?
    $submissao = new Submissao(null, "Nome Ocasião", "Descrição da submissão.", null, 1); // !!! passar ofertaId qndo criação de ofertas estiver pronto
    $submissaoId = $submissaoDao->insere($submissao);

    
    foreach($selecionaveis as $s){
        $alternativas = $s['alternativas'];
        $questao = $s['idQuestao'];

        $qq = $questionarioQuestaoDao->buscaPorQuestionarioEQuestao($idQuestionario, $questao);
        if ($qq != null){ 
            if (count($alternativas) > 1){
                $corretasArr = $alternativaDao->buscaCorretasPorQuestaoId($questao);
                $notaFracionada = $qq->getPontos() / count($alternativas);
                $notaObtida = 0;
                $raArray = array();

                foreach ($alternativas as $idA){      
                    if (in_array($idA, $corretasArr)){
                        $notaObtida += $notaFracionada;
                    }
                } 
                
                $r = new Resposta(null, null, $notaObtida, null, $questao, $submissaoId);
                $idR = $respostaDao->insere($r);
                var_dump(count($raArray));
                foreach ($raArray as $ra){      
                    $raArray[] = new RespostaAlternativa(null, $idR, $idA);
                    $respAltDao->insere($ra);
                } 

            } else {
                $r = new Resposta(null, null, $qq->getPontos(), null, $questao, $submissaoId);
                $respostaDao->insere($r);
            }
        }
    }

    foreach($discursivas as $d){
        $texto = $d['val'];
        $questao = $d['idQuestao'];

        $qq = $questionarioQuestaoDao->buscaPorQuestionarioEQuestao($idQuestionario, $questao);
        if ($qq != null){                          // null? nao foi avaliado ainda
            $r = new Resposta(null, $texto, null, null, $questao, $submissaoId); // !! Passar id submissao aqui
            $respostaDao->insere($r);
        }
    }

    header('Location: Menu.php');

?>
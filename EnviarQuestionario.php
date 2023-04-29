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
        exit('erro');
    }

    $respostaDao = $factory->getRespostaDao();
    $questaoDao = $factory->getQuestaoDao();
    $questionarioQuestaoDao = $factory->getQuestionarioQuestaoDao();
    $respAltDao = $factory->getRespostaAlternativaDao();
    $submissaoDao = $factory->getSubmissaoDao();
    $alternativaDao = $factory->getAlternativaDao();

    // pensar se precisa fazer uma transaction aqui e passar tudo no dao da submissao?
    $submissao = new Submissao(null, "Nome Ocasião", "Descrição da submissão.", null, 1); // !!! passar ofertaId qndo criação de ofertas estiver pronto
    $submissaoId = $submissaoDao->insere($submissao);

    foreach($selecionaveis as $s){
        $questao = $s['idQuestao'];
        $alternativasMarcadas = $s['alternativas'];
        $alternativasDaQuestao = $alternativaDao->buscaPorQuestaoId($questao);
        $qst = $questaoDao->buscaPorId($questao);
        // TO-DO: validar questoes e alternativas recebidas

        if (!$alternativasMarcadas){
            $r = new Resposta(null, null, 0, null, $questao, $submissaoId);
            $idR = $respostaDao->insere($r);

            // Não tem alternativa pq nenhuma foi marcada, so tem resposta. Certo?
            //$ra = new RespostaAlternativa(null, $idR, $alternativasMarcadas[0]);
            //$respAltDao->insere($ra);
            continue;
        }
        
        $alternativasCorretasArr = $alternativaDao->buscaCorretasPorQuestaoId($questao);
        $idCorretasArr = array_map("mapAlternativasCorretasId", $alternativasCorretasArr);

        $qq = $questionarioQuestaoDao->buscaPorQuestionarioEQuestao($idQuestionario, $questao);
        if ($qq != null){ 
            //if (count($alternativasDaQuestao) > 1){
            if ($qst->getIsMultiplaEscolha()){
               // $corretasArr = $alternativaDao->buscaCorretasPorQuestaoId($questao);
                $notaFracionada = $qq->getPontos() / count($idCorretasArr);
                $notaObtida = 0;
                
                foreach ($alternativasMarcadas as $idA){      
                    if (in_array($idA, $idCorretasArr)){
                        $notaObtida += $notaFracionada;
                    } else {
                        $notaObtida -= $notaFracionada/2;
                    }
                } 

                $notaObtida = max(0, $notaObtida);
                $r = new Resposta(null, null, $notaObtida, null, $questao, $submissaoId);
                $idR = $respostaDao->insere($r);
                
                foreach ($alternativasMarcadas as $idA){      
                    // respostalternativa para alternativas nao marcadas? analisar se precisa
                    $ra = new RespostaAlternativa(null, $idR, $idA);
                    $respAltDao->insere($ra);
                } 

            } else if ($qst->getIsObjetiva()) {
                $idA = $alternativasMarcadas[0];

                if ($idA == $idCorretasArr[0]){
                    // acertou
                    $r = new Resposta(null, null, $qq->getPontos(), null, $questao, $submissaoId);
                } else {
                    // errou
                    $r = new Resposta(null, null, 0, null, $questao, $submissaoId);
                }

                $idR = $respostaDao->insere($r);
                $ra = new RespostaAlternativa(null, $idR, $idA);
                $respAltDao->insere($ra);
            } else {
                // erro, nao foi possivel identificar o tipo de questão
            }
        }
    }

    foreach($discursivas as $d) {
        $texto = $d['val'];
        $questao = $d['idQuestao'];

        $qq = $questionarioQuestaoDao->buscaPorQuestionarioEQuestao($idQuestionario, $questao);
        if ($qq != null) {
            $r = new Resposta(null, $texto, null, null, $questao, $submissaoId);
            $respostaDao->insere($r);
        }
    }

    function mapAlternativasCorretasId($v){
        return $v->getId();
    }

    exit('sucesso');
    //header('Location: Menu.php');
    //exit;
?>
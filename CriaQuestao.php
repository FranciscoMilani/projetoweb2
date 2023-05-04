<?php 
    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';
    
    $descricao = $_POST['descricao'];
    $tipoquestao = $_POST['tipoquestao'];
    $quantidadeAlternativas = $_POST['quantidade'];
    
    $alternativasCriadas = array();
    $alternativas = array();
    $alternativasTexto = $_POST['alternativaTexto'];

    for ($i = 0; $i < $quantidadeAlternativas; $i++){
        $alternativas[] = $_POST['alternativa'.($i+1).''];
    }
    
    $daoQuestao = $factory->getQuestaoDao();
    $daoAlternativa = $factory->getAlternativaDao();

    if ($tipoquestao == "discursiva") {
        $questao = new Questao(null, $descricao, 1, 0, 0);
        $questaoId = $daoQuestao->insere($questao);
        
    } else if ($tipoquestao == "selecionavel") {
        var_dump($alternativas);

        $arr = array_count_values($alternativas);
        $qtd = $arr[1];
        if (!empty($alternativas)) {
            if ($qtd >= 2){
                // multipla escolha
                $questao = new Questao(null, $descricao, 0, 0, 1);
            } else if (($qtd == 1)) {
                // objetiva
                $questao = new Questao(null, $descricao, 0, 1, 0);
            } else {
                //erro
                echo 'Erro';
                exit;
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
    
   header('Location: Menu.php');
   exit;
?>
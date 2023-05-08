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

    // file upload
    if ( is_uploaded_file($_FILES["imagem"]["tmp_name"] ) 
         && file_exists($_FILES["imagem"]["tmp_name"] )) {
        
        $allowed = array("jpeg", "png", "jpg");
        $nome_real = $_FILES["imagem"]["name"];
        $ext = strtolower(pathinfo($nome_real, PATHINFO_EXTENSION));

        $nome_novo = pathinfo($nome_real, PATHINFO_FILENAME)
                     .'_'.intval(microtime(true) * 1000) 
                     .'.'.pathinfo($nome_real, PATHINFO_EXTENSION);

        if (in_array($ext, $allowed)) {
            $nome_temporario = $_FILES["imagem"]["tmp_name"];
            $nome_novo = str_replace(" ", "_", $nome_novo);
            copy($nome_temporario, "public/uploads/$nome_novo");
        }
    }   

    // alternativas
    if ($tipoquestao == "discursiva") {
        $questao = new Questao(null, $descricao, 1, 0, 0, $nome_novo);
        $questaoId = $daoQuestao->insere($questao);
        
    } else if ($tipoquestao == "selecionavel") {
        $arr = array_count_values($alternativas);
        $qtd = $arr[1];
        if (!empty($alternativas)) {
            if ($qtd >= 2){
                $questao = new Questao(null, $descricao, 0, 0, 1, $nome_novo);
            } else if ($qtd == 1) {
                $questao = new Questao(null, $descricao, 0, 1, 0, $nome_novo);
            } else {
                echo 'Erro';
                exit;
            }
            
            $questao->setId($daoQuestao->insere($questao));

            for ($i = 0; $i < count($alternativas); $i++){
                $alternativaTemp = new Alternativa(null, $alternativasTexto[$i], $alternativas[$i], $questao);
                $alternativasCriadas[] = $alternativaTemp;
                $daoAlternativa->insere($alternativaTemp);
            }
    
            $questao->setAlternativas($alternativasCriadas);
        }
    }
    
   header('Location: ControleQuestoes.php');
   exit;
?>
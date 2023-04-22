<?php 
    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $notaAprovacao = $_POST['notaaprovacao'];
    $dataCriacao = date("d/m/Y");
    $elaboradorId = $_SESSION['id_elaborador'];
    
    $daoE = $factory->getElaboradorDao();  
    $elaborador = $daoE->buscaPorId($elaboradorId);
    
    if (!isset($elaborador)){
        header('Location: CriacaoQuestionario.php');
        exit;
    }
    
    $daoQ = $factory->getQuestionarioDao();
    verificaVariaveis($_POST);

    function verificaVariaveis($vars) {
        foreach ($vars as $variavel){
            if (!isset($variavel) || empty($variavel)) {
                header('Location: CriacaoQuestionario.php');
                exit;
            }
        }
    }

    $questionario = new Questionario(null, $nome, $descricao, $dataCriacao, $notaAprovacao, $elaborador);
    $questionarioId = $daoQ->insere($questionario);
    var_dump($questionarioId);
   // $_SESSION["id_questionario"] = $questionarioId;
    header('Location: VinculoQuestionarioQuestao.php?questionarioId='.$questionarioId);
    exit;
?>
<?php 
    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';

    $descricao = $_POST['descricao'];
    $isDiscursiva = $_POST['isDiscursiva'];
    $isObjetiva = $_POST['isObjetiva'];
    $isMultiplaEscolha = $_SESSION['isMultiplaEscolha'];
    
    $daoQ = $factory->getQuestaoDao();
    verificaVariaveis($_POST);

    function verificaVariaveis($vars) {
        foreach ($vars as $variavel){
            if (!isset($variavel) || empty($variavel)) {
                header('Location: CriacaoQuestao.php');
                exit;
            }
        }
    }

    $questao = new Questao(null, $descricao, $isDiscursiva, $isObjetiva, $isMultiplaEscolha);

    header('Location: CriacaoQuestao.php');
    exit;
?>
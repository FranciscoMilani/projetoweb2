<?php 

    // DAOs
    include_once 'dao/DaoFactory.php';
    include_once 'dao/PostgresDaoFactory.php';
    include_once 'dao/RespondenteDao.php';
    include_once 'dao/ElaboradorDao.php';
    include_once 'dao/QuestionarioDao.php';
    include_once 'dao/QuestaoDao.php';
    include_once 'dao/QuestionarioQuestaoDao.php';
    include_once 'dao/AlternativaDao.php';
    include_once 'dao/RespostaDao.php';
    include_once 'dao/RespostaAlternativaDao.php';
    include_once 'dao/SubmissaoDao.php';
    // include_once 'dao/OfertaDao.php';

    
    // models
    include_once 'model/Respondente.php';
    include_once 'model/Elaborador.php';
    include_once 'model/Questionario.php';
    include_once 'model/Questao.php';
    include_once 'model/QuestionarioQuestao.php';
    include_once 'model/Alternativa.php';
    include_once 'model/Resposta.php';
    include_once 'model/RespostaAlternativa.php';
    include_once 'model/Submissao.php';
    // include_once 'model/Oferta.php';

    // não printa Notices
    error_reporting(E_ERROR | E_USER_ERROR);

    $factory = new PostgresDaoFactory();
?>
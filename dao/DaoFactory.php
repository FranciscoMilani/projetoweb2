<?php
abstract class DaoFactory {

    protected abstract function getConnection();

    // DAOs
    public abstract function getRespondenteDao();
    public abstract function getElaboradorDao();
    public abstract function getQuestionarioDao();
    public abstract function getQuestaoDao();
    public abstract function getQuestionarioQuestaoDao();
    public abstract function getAlternativaDao();
    public abstract function getRespostaDao();
    public abstract function getRespostaAlternativaDao();
    public abstract function getSubmissaoDao();
    // public abstract function getOfertaDao();
}
?>
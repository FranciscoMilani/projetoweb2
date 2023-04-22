<?php
abstract class DaoFactory {

    protected abstract function getConnection();

    // DAOs
    public abstract function getRespondenteDao();
    public abstract function getElaboradorDao();

    public abstract function getQuestionarioDao();
    public abstract function getQuestaoDao();
    public abstract function getQuestionarioQuestaoDao();

}
?>
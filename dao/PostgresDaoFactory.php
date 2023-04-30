<?php

include_once('DaoFactory.php');

include_once('PostgresRespondenteDao.php');
include_once('PostgresElaboradorDao.php');
include_once('PostgresQuestionarioDao.php');
include_once('PostgresQuestaoDao.php');
include_once('PostgresQuestionarioQuestaoDao.php');
include_once('PostgresAlternativaDao.php');
include_once('PostgresRespostaDao.php');
include_once('PostgresRespostaAlternativaDao.php');
include_once('PostgresSubmissaoDao.php');
include_once('PostgresOfertaDao.php');


class PostgresDaoFactory extends DaoFactory {

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "ProjetoWeb2";
    private $port = "5432";
    private $username = "postgres";
    private $password = "ucs";
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            //$this->conn = new PDO("pgsql:host=localhost;port=5432;dbname=PHP_tutorial", $this->username, $this->password);
    
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    // ------------ USUARIOS -------------
    public function getRespondenteDao() {
        return new PostgresRespondenteDao($this->getConnection());
    }

    public function getElaboradorDao() {
        return new PostgresElaboradorDao($this->getConnection());
    }

    // ---------- QUESTIONARIOS E QUESTOES -----------
    public function getQuestionarioDao() { 
        return new PostgresQuestionarioDao($this->getConnection()); 
    }

    public function getQuestaoDao() { 
        return new PostgresQuestaoDao($this->getConnection()); 
    }

    public function getQuestionarioQuestaoDao() { 
        return new PostgresQuestionarioQuestaoDao($this->getConnection()); 
    }

    public function getAlternativaDao() {
        return new PostgresAlternativaDao($this->getConnection()); 
    }

    public function getRespostaDao() {
        return new PostgresRespostaDao($this->getConnection()); 
    }

    public function getRespostaAlternativaDao() {
        return new PostgresRespostaAlternativaDao($this->getConnection()); 
    }

    public function getSubmissaoDao() {
        return new PostgresSubmissaoDao($this->getConnection()); 
    }

    public function getOfertaDao() {
        return new PostgresOfertaDao($this->getConnection()); 
    }
}
?>
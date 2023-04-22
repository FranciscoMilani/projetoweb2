<?php

include_once('DaoFactory.php');

include_once('PostgresRespondenteDao.php');
include_once('PostgresElaboradorDao.php');

include_once('PostgresQuestionarioDao.php');
include_once('PostgresQuestaoDao.php');
include_once('PostgresQuestionarioQuestaoDao.php');

class PostgresDaoFactory extends DaoFactory {

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "projetoweb2";
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
}
?>
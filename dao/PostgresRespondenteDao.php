<?php

include_once('RespondenteDao.php');
include_once('PostgresDao.php');

class PostgresRespondenteDao extends PostgresDao implements RespondenteDao {

    private $table_name = 'respondente';
    
    public function insere($respondente) {

        $query = "INSERT INTO " . $this->table_name . 
        " (login, senha, nome, email, telefone) VALUES" .
        " (:login, :senha, :nome, :email, :telefone)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":login", $respondente->getLogin());
        $stmt->bindParam(":senha", md5($respondente->getSenha()));
        $stmt->bindParam(":nome", $respondente->getNome());
        $stmt->bindParam(':email', $respondente->getEmail());
        $stmt->bindParam(':telefone', $respondente->getTelefone());

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function removePorId($id) {
        $query = "DELETE FROM " . $this->table_name . 
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(':id', $id);

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function remove($respondente) {
        return removePorId($respondente->getId());
    }

    public function altera($respondente) {

        $query = "UPDATE " . $this->table_name . 
        " SET id = :id, login = :login, senha = :senha, nome = :nome, email = :email, telefone = :telefone" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(":id", $respondente->getId());
        $stmt->bindParam(":login", $respondente->getLogin());
        $stmt->bindParam(":senha", md5($respondente->getSenha()));
        $stmt->bindParam(":nome", $respondente->getNome());
        $stmt->bindParam(':email', $respondente->getEmail());
        $stmt->bindParam(':telefone', $respondente->getTelefone());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function buscaPorId($id) {
        
        $respondente = null;

        $query = "SELECT
                    id, login, nome, senha, email, telefone
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $respondente = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
        } 
     
        return $respondente;
    }

    public function buscaPorLogin($login) {

        $respondente = null;

        $query = "SELECT
                    id, login, nome, senha, email, telefone
                FROM
                    " . $this->table_name . "
                WHERE
                    login = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $login);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $respondente = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
        } 
     
        return $respondente;
    }

    public function buscaTodos() {

        $respondentes = array();

        $query = "SELECT
                    id, login, senha, nome, email, telefone
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $respondentes[] = new Respondente($id, $login, $senha, $nome, $email, $telefone);
        }
        
        return $respondentes;
    }

    public function buscaPorNome($nome) {

        $respondente = null;

        $query = "SELECT
                    id, login, senha, nome, email, telefone
                FROM
                    " . $this->table_name . "
                WHERE
                    nome = ?";
                // LIMIT
                //     1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $nome);
        $stmt->execute();
     
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $respondente = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
        }
     
        return $respondente;
    }

    public function buscaPorEmail($email) {

        $respondente = null;

        $query = "SELECT
                    id, login, nome, senha, instituicao, isAdmin
                FROM
                    " . $this->table_name . "
                WHERE
                    email = ?";
                // LIMIT
                //     1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $email);
        $stmt->execute();
     
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $respondente = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
        }
     
        return $respondente;
    }
}
?>
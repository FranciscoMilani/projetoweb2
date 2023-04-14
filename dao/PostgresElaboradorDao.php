<?php

include_once('ElaboradorDao.php');
include_once('PostgresDao.php');

class PostgresElaboradorDao extends PostgresDao implements ElaboradorDao {

    private $table_name = 'elaborador';
    
    public function insere($elaborador) {

        $query = "INSERT INTO " . $this->table_name . 
        " (login, senha, nome, email, instituicao, isAdmin) VALUES" .
        " (:login, :senha, :nome, :email, :instituicao, :isAdmin)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":login", $elaborador->getLogin());
        $stmt->bindParam(":senha", md5($elaborador->getSenha()));
        $stmt->bindParam(":nome", $elaborador->getNome());
        $stmt->bindParam(":email", $elaborador->getEmail());
        $stmt->bindParam(":instituicao", $elaborador->getInstituicao());
        $stmt->bindParam(":isAdmin", $elaborador->getIsAdmin());

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

    public function remove($elaborador) {
        return removePorId($elaborador->getId());
    }

    public function altera(&$elaborador) {

        $query = "UPDATE " . $this->table_name . 
        " SET login = :login, senha = :senha, nome = :nome, instituicao = :instituicao" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(":login", $elaborador->getLogin());
        $stmt->bindParam(":senha", md5($elaborador->getSenha()));
        $stmt->bindParam(":nome", $elaborador->getNome());
        $stmt->bindParam(':id', $elaborador->getId());
        $stmt->bindParam(":instituicao", $elaborador->getInstituicao());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function buscaPorId($id) {
        
        $elaborador = null;

        $query = "SELECT
                    id, login, nome, senha, instituicao, isAdmin
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
            $elaborador = new Elaborador($row['id'],$row['login'], $row['senha'], $row['nome'], $row['instituicao'], $row['isAdmin']);
        } 
     
        return $elaborador;
    }

    public function buscaPorLogin($login) {

        $elaborador = null;

        $query = "SELECT
                    id, login, nome, senha, instituicao, isAdmin
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
            $elaborador = new Elaborador($row['id'],$row['login'], $row['senha'], $row['nome'], $row['instituicao'], $row['isAdmin']);
        } 
     
        return $elaborador;
    }

    public function buscaTodos() {

        $elaboradors = array();

        $query = "SELECT
                    id, login, senha, nome, instituicao, isAdmin
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $elaboradors[] = new Elaborador($id, $login, $senha, $nome, $instituicao, $isAdmin);
        }
        
        return $elaboradors;
    }

    public function buscaPorNome($nome) {

        $elaborador = null;

        $query = "SELECT
                    id, login, nome, senha, instituicao, isAdmin
                FROM
                    " . $this->table_name . "
                WHERE
                    nome = ?";
                // LIMIT
                //     1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $nome);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $elaborador = new Elaborador($row['id'], $row['login'], $row['senha'], $row['nome'], $row['instituicao'], $row['isAdmin']);
        } 
     
        return $elaborador;
    }

    public function buscaPorEmail($email) {

        $elaborador = null;

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
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $elaborador = new Elaborador($row['id'], $row['login'], $row['senha'], $row['nome'], $row['instituicao'], $row['isAdmin']);
        } 
     
        return $elaborador;
    }
}
?>
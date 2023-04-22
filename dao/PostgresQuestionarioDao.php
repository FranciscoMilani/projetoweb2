<?php

include_once('QuestionarioDao.php');
include_once('PostgresDao.php');

class PostgresQuestionarioDao extends PostgresDao implements QuestionarioDao {

    private $table_name = 'questionario';
    
    public function insere($questionario) {

        $query = "INSERT INTO " . $this->table_name . 
        " (nome, descricao, datacriacao, notaaprovacao, elaboradorid) VALUES" .
        " (:nome, :descricao, :datacriacao, :notaaprovacao, :elaboradorid)" .
        " RETURNING id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nome", $questionario->getNome());
        $stmt->bindParam(":descricao", $questionario->getDescricao());
        $stmt->bindParam(":datacriacao", $questionario->getDataCriacao());
        $stmt->bindParam(":notaaprovacao", $questionario->getNotaAprovacao());
        $stmt->bindParam(":elaboradorid", $questionario->getElaborador()->getId());

        // retorna ID inserido
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        }else{
            return false;
        }
    }

    public function removePorId($id) {
        $query = "DELETE FROM " . $this->table_name . 
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function remove($questionario) {
        return $this->removePorId($questionario->getId());
    }

    /*                  IMPLEMENTAR ALTERAÇÃO SE FOR NECESSÁRIO
    
    public function altera($questionario) {

        $query = "UPDATE " . $this->table_name . 
        " SET login = :login, senha = :senha, nome = :nome, email = :email" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
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
    */

    public function buscaPorId($id) {
        $questionario = null;

        $query = "SELECT
                    id, nome, descricao, datacriacao, notaaprovacao, elaboradorid
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
            $questionario = new Questionario($row['id'], $row['nome'], $row['descricao'], $row['datacriacao'], $row['notaaprovacao'], $row['elaboradorid']);
        } 
     
        return $questionario;
    }

    public function buscaTodos() {
        $questionarios = array();

        $query = "SELECT
                    id, nome, descricao, datacriacao, notaaprovacao, elaboradorid
                FROM
                    " . $this->table_name . 
                    " ORDER BY datacriacao DESC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $questionarios[] = new Questionario($id, $nome, $descricao, $datacriacao, $notaaprovacao, $elaboradorid);
        }
        
        return $questionarios;
    }
}
?>
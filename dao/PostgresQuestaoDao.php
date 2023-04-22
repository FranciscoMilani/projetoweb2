<?php

include_once('QuestaoDao.php');
include_once('PostgresDao.php');

class PostgresQuestaoDao extends PostgresDao implements QuestaoDao {

    private $table_name = 'questao';
    
    public function insere($questao) {

        $query = "INSERT INTO " . $this->table_name . 
        " (descricao, isDiscursiva, isObjetiva, isMultiplaEscolha) VALUES" .
        " (:descricao, :isDiscursiva, :isObjetiva, :isMultiplaEscolha)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":descricao", $questao->getDescricao());
        $stmt->bindParam(":isDiscursiva", $questao->getIsDiscursiva());
        $stmt->bindParam(":isObjetiva", $questao->getIsObjetiva());
        $stmt->bindParam(":isMultiplaEscolha", $questao->getIsMultiplaEscolha());

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

        $stmt->bindParam(':id', $id);

        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function remove($questao) {
        return $this->removePorId($questao->getId());
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
        $questao = null;

        $query = "SELECT
                    id, descricao, isDiscursiva, isObjetiva, isMultiplaEscolha
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
            $questao = new Questao($row['id'], $row['descricao'], $row['isDiscursiva'], $row['isObjetiva'], $row['isMultiplaEscolha']);
        } 
     
        return $questao;
    }

    public function buscaTodos() {
        $questoes = array();

        $query = "SELECT
                    id, descricao, isDiscursiva, isObjetiva, isMultiplaEscolha
                FROM
                    " . $this->table_name . 
                    " ORDER BY id DESC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $questoes[] = new Questao($id, $descricao, $isDiscursiva, $isObjetiva, $isMultiplaEscolha);
        }
        
        return $questoes;
    }
}
?>
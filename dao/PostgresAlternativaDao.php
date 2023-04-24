<?php

include_once('AlternativaDao.php');
include_once('PostgresDao.php');

class PostgresAlternativaDao extends PostgresDao implements AlternativaDao {

    private $table_name = 'alternativa';
    
    public function insere($alternativa) {

        $query = "INSERT INTO " . $this->table_name . 
        " (descricao, iscorreta, questaoId) VALUES" .
        " (:descricao, :iscorreta, :questaoId)" .
        " RETURNING id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":descricao", $alternativa->getDescricao());
        $stmt->bindParam(":iscorreta", $alternativa->getIsCorreta());
        $stmt->bindParam(":questaoId", $alternativa->getQuestao()->getId());

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
    

    public function remove($alternativa) {
        return $this->removePorId($alternativa->getId());
    }


    public function buscaPorId($id) {
        $alternativa = null;

        $query = "SELECT
                    id, descricao, iscorreta, questaoId
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
            $alternativa = new Alternativa($row['id'], $row['descricao'], $row['iscorreta'], $row['questaoId']);
        } 
     
        return $alternativa;
    }


    public function buscaTodos() {
        $alternativas = array();

        $query = "SELECT
                    id, descricao, iscorreta, questaoId
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $alternativas[] = new Alternativa($id, $descricao, $iscorreta, $questaoId);
        }
        
        return $alternativas;
    }

    public function buscaPorQuestaoId($questaoId) {
        $alternativas = array();

        $query = "SELECT
                    id, descricao, iscorreta, questaoId
                FROM
                    " . $this->table_name . 
                    " WHERE questaoId = :questaoId ";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':questaoId', $questaoId);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $alternativas[] = new Alternativa($id, $descricao, $iscorreta, $questaoId);
        }
        
        return $alternativas;
    }
}
?>
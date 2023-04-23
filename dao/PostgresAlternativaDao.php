<?php

include_once('AlternativaDao.php');
include_once('PostgresDao.php');

class PostgresAlternativaDao extends PostgresDao implements AlternativaDao {

    private $table_name = 'alternativa';
    
    public function insere($alternativa) {

        $query = "INSERT INTO " . $this->table_name . 
        " (id, descricao, iscorreta) VALUES" .
        " (:id, :descricao, :iscorreta)" .
        " RETURNING id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $alternativa->getId());
        $stmt->bindParam(":descricao", $alternativa->getDescricao());
        $stmt->bindParam(":iscorreta", $alternativa->getIsCorreta());

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
                    id, descricao, iscorreta
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
            $alternativa = new Alternativa($row['id'], $row['descricao'], $row['iscorreta']);
        } 
     
        return $alternativa;
    }


    public function buscaTodos() {
        $alternativas = array();

        $query = "SELECT
                    id, descricao, iscorreta
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $alternativas[] = new Alternativa($id, $descricao, $iscorreta);
        }
        
        return $alternativas;
    }
}
?>
<?php

include_once('RespostaDao.php');
include_once('PostgresDao.php');

class PostgresRespostaDao extends PostgresDao implements RespostaDao {

    private $table_name = 'resposta';
    
    public function insere($resposta) {

        $query = "INSERT INTO " . $this->table_name . 
        " (texto, nota, observacao, questaoid, submissaoid) VALUES" .
        " (:texto, :nota, :observacao, :questaoid, :submissaoid)" .
        " RETURNING id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":texto", $resposta->getTexto());
        $stmt->bindParam(":nota", $resposta->getNota());
        $stmt->bindParam(":observacao", $resposta->getObservacao());
        $stmt->bindParam(":questaoid", $resposta->getQuestao());
        $stmt->bindParam(":submissaoid", $resposta->getSubmissao());

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

    public function remove($resposta) {
        return $this->removePorId($resposta->getId());
    }

    public function buscaPorId($id) {
        $resposta = null;

        $query = "SELECT
                    id, texto, nota, observacao, questaoid, submissaoid
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
            $resposta = new Resposta($row['id'], $row['texto'], $row['nota'], $row['observacao'], $row['questaoid'], $row['submissaoid']);
        } 
     
        return $resposta;
    }

    public function buscaPorSubmissaoId($submissaoId)
    {
        $respostas = array();

        $query = "SELECT id, texto, nota, observacao, questaoid, submissaoid
                  FROM {$this->table_name}
                  WHERE submissaoid = :id";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':id', $submissaoId);
        $stmt->execute();
     
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $respostas[] = new Resposta($id, $texto, $nota, $observacao, $questaoid, $submissaoid);
        } 
     
        return $respostas;
    }

    public function buscaTodos() {
        $respostas = array();

        $query = "SELECT
                    id, texto, nota, observacao, questaoid, submissaoid
                FROM
                    " . $this->table_name . 
                    " ORDER BY datacriacao DESC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $respostas[] = new Resposta($id, $texto, $nota, $observacao, $questaoid, $submissaoid);
        }
        
        return $respostas;
    }
}
?>
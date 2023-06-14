<?php

include_once('QuestaoDao.php');
include_once('PostgresDao.php');

class PostgresQuestaoDao extends PostgresDao implements QuestaoDao {

    private $table_name = 'questao';
    
    public function insere($questao) {

        $query = "INSERT INTO " . $this->table_name . 
        " (descricao, isdiscursiva, isobjetiva, ismultiplaescolha, caminhoimagem) VALUES" .
        " (:descricao, :isdiscursiva, :isobjetiva, :ismultiplaescolha, :caminhoimagem)" .
        " RETURNING id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":descricao", $questao->getDescricao());
        $stmt->bindParam(":isdiscursiva", $questao->getIsDiscursiva());
        $stmt->bindParam(":isobjetiva", $questao->getIsObjetiva());
        $stmt->bindParam(":ismultiplaescolha", $questao->getIsMultiplaEscolha());
        $stmt->bindParam(":caminhoimagem", $questao->getImagem());

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

    public function remove($questao) {
        return $this->removePorId($questao->getId());
    }

    public function buscaPorId($id) {
        $questao = null;

        $query = "SELECT
                    id, descricao, isdiscursiva, isobjetiva, ismultiplaescolha, caminhoimagem
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
            $questao = new Questao($row['id'], $row['descricao'], $row['isdiscursiva'], $row['isobjetiva'], $row['ismultiplaescolha'], $row['caminhoimagem']);
        } 
     
        return $questao;
    }

    public function buscaTodos() {
        $questoes = array();

        $query = "SELECT
                    id, descricao, isdiscursiva, isobjetiva, ismultiplaescolha, caminhoimagem
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $questoes[] = new Questao($id, $descricao, $isdiscursiva, $isobjetiva, $ismultiplaescolha, $caminhoimagem);
        }
        
        return $questoes;
    }

    public function buscaPorDescricaoTipoPaginado($desc, $isDisc, $isObj, $isMult, $limit, $offset)
    {
        $questoes = array();

        $stmt = $this->conn->prepare(
                "SELECT id, descricao, isdiscursiva, isobjetiva, ismultiplaescolha, caminhoimagem
                FROM {$this->table_name}
                WHERE LOWER(descricao) LIKE LOWER(:descricao)               
                AND ((:isDisc = true AND isdiscursiva = true) OR (:isObj = true AND isobjetiva = true) OR (:isMult = true AND ismultiplaescolha = true))
                ORDER BY descricao DESC
                LIMIT :limit OFFSET :offset"
        );


        $stmt->bindValue(':descricao', '%'.$desc.'%', PDO::PARAM_STR);
        $stmt->bindValue(':isDisc', $isDisc, PDO::PARAM_BOOL);
        $stmt->bindValue(':isObj', $isObj, PDO::PARAM_BOOL);
        $stmt->bindValue(':isMult', $isMult, PDO::PARAM_BOOL);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $questoes[] = new Questao($row['id'], $row['descricao'], $row['isdiscursiva'], $row['isobjetiva'], $row['ismultiplaescolha'], $row['caminhoimagem']);
        }
        return $questoes;
    }


    public function contaComDescricao($desc){
        $query = "SELECT COUNT(*) as contagem
                  FROM {$this->table_name}
                  WHERE LOWER(descricao) LIKE LOWER(:descricao)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':descricao', '%'.$desc.'%', PDO::PARAM_STR);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            return $contagem;
        }

        return 0;
    }
}
?>
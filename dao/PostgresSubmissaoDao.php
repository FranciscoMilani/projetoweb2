<?php

include_once('SubmissaoDao.php');
include_once('PostgresDao.php');

class PostgresSubmissaoDao extends PostgresDao implements SubmissaoDao {

    private $table_name = 'submissao';
    
    public function insere($submissao) {

        $query = "INSERT INTO " . $this->table_name . 
        " (nomeocasiao, descricao, data, ofertaid, respondenteid) VALUES" .
        " (:nomeocasiao, :descricao, DEFAULT, :ofertaid, :respondenteid)" .
        " RETURNING id";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nomeocasiao", $submissao->getNomeOcasiao());
        $stmt->bindParam(":descricao", $submissao->getDescricao());
        $stmt->bindParam(":ofertaid", $submissao->getOferta());
        $stmt->bindParam(":respondenteid", $submissao->getRespondente());

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

    public function remove($submissao) {
        return $this->removePorId($submissao->getId());
    }

    public function buscaPorId($id) {
        $submissao = null;

        $query = "SELECT
                    id, nomeocasiao, descricao, data, ofertaid, respondenteid
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
            $dataFormatada = date('d/m/Y', strtotime($row['data']));
            $submissao = new Submissao($row['id'], $row['nomeocasiao'], $row['descricao'], $dataFormatada, $row['ofertaid'], $row['respondenteid']);
        } 
     
        return $submissao;
    }
    
    public function buscaTodos() {
        $submissoes = array();

        $query = "SELECT
                    id, nomeocasiao, descricao, data, ofertaid, respondenteid
                FROM
                    " . $this->table_name . 
                    " ORDER BY data DESC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            //$data =  date('d-m-Y', strtotime($row['data']));
            $dataFormatada = date('d/m/Y', strtotime($data));
            $submissoes[] = new Submissao($id, $nomeocasiao, $descricao, $dataFormatada, $ofertaid, $respondenteid);
        }
        
        return $submissoes;
    }

    // public function buscaPorRespondente($usuario) {
    //     $submissoes = array();

    //     $query = "SELECT
    //                 id, nomeocasiao, descricao, data, ofertaid
    //             FROM
    //                 " . $this->table_name . 
    //                 " ORDER BY data DESC";
     
    //     $stmt = $this->conn->prepare( $query );
    //     $stmt->execute();

    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //         extract($row);
    //         //$data =  date('d-m-Y', strtotime($row['data']));
    //         $dataFormatada = date('d/m/Y', strtotime($data));
    //         $submissoes[] = new Submissao($id, $nomeocasiao, $descricao, $dataFormatada, $ofertaid);
    //     }
        
    //     return $submissoes;
    // }
    
}
?>
<?php
include_once('OfertaDao.php');
include_once('PostgresDao.php');

class PostgresOfertaDao extends PostgresDao implements OfertaDao
{
    private $table_name = 'oferta';

    public function insere($oferta)
    {
        $query = "INSERT INTO " . $this->table_name .
            " (data, questionarioid, respondenteid) VALUES" .
            " (:data, :questionarioid, :respondenteid)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":data", $oferta->getData());
        $stmt->bindParam(":questionarioid", $oferta->getquestionario());
        $stmt->bindParam(":respondenteid", $oferta->getRespondente());

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function removePorId($id)
    {
        $query = "DELETE FROM " . $this->table_name .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(':id', $id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // public function removePorQuestionarioId($id){
    //     $query = "DELETE FROM " . $this->table_name .
    //     " WHERE questionarioid = :id";

    //     $stmt = $this->conn->prepare($query);

    //     // bind parameters
    //     $stmt->bindParam(':id', $id);

    //     // execute the query
    //     if ($stmt->execute()) {
    //         return true;
    //     }

    //     return false;
    // }


    public function remove($oferta)
    {
        return $this->removePorId($oferta->getId());
    }

    public function buscaTodos()
    {

        $ofertas = array();

        $query = "SELECT
                    id, data, questionarioid, respondenteid
                FROM
                    " . $this->table_name .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ofertas[] = new Oferta($id, $data, $questionario, $respondente);
        }

        return $ofertas;
    }

    public function ofertasPorUsuario($id)
    {
        $ofertas = array();

        $query = "SELECT
                    id, data, questionarioid, respondenteid 
                FROM
                    " . $this->table_name . "
                WHERE
                    respondenteid = ?";


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ofertas[] = new Oferta($row['id'], $row['data'], $row['questionarioid'], $row['respondenteid']);
        }

        return $ofertas;
    }

    
    public function buscaPorQuestionarioId($id)
    {
        $ofertas = array();

        $query = "SELECT id, data, questionarioid, respondenteid 
                  FROM {$this->table_name}
                  WHERE questionarioid = :id";


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ofertas[] = new Oferta($row['id'], $row['data'], $row['questionarioid'], $row['respondenteid']);
        }

        return $ofertas;
    }

    public function buscaOfertasSubmetidasPorRespondente($id)
    {
        $ofertas = array();

        $query = "SELECT o.id, o.data, o.questionarioid, o.respondenteid 
                  FROM {$this->table_name} o
                  INNER JOIN submissao s
                  ON o.respondenteid = s.respondenteid
                  AND o.respondenteid = :id";


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ofertas[] = new Oferta($row['id'], $row['data'], $row['questionarioid'], $row['respondenteid']);
        }

        return $ofertas;
    }
}
?>
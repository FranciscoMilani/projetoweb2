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

    public function buscaOfertasSubmetidasPorRespondenteEElaborador($input, $idResp, $idElab, $limit, $offset)
    {
        $ofertas = array();

        $query = "  SELECT o.id, o.data, o.questionarioid, o.respondenteid 
                    FROM {$this->table_name} o
                    INNER JOIN submissao s ON o.respondenteid = s.respondenteid
                    WHERE o.id = s.ofertaid
                    AND o.respondenteid = :idResp
                    AND o.questionarioid IN 
                        (SELECT id 
                        FROM questionario q 
                        WHERE elaboradorid = :idElab
                        AND (LOWER(q.nome) LIKE LOWER(:query) OR LOWER(q.descricao) LIKE LOWER(:query)))
                    ORDER BY o.data
                    LIMIT :limit OFFSET :offset
                 ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idResp", $idResp);
        $stmt->bindParam(":idElab", $idElab);
        $stmt->bindValue(':query', '%'.$input.'%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ofertas[] = new Oferta($row['id'], $row['data'], $row['questionarioid'], $row['respondenteid']);
        }

        return $ofertas;
    }

    
    public function contaResultadosPorRespondenteEElaboradorComNome($input, $elabId, $respId){
        $query = "  SELECT COUNT(*) as contagem
                    FROM oferta o
                    INNER JOIN submissao s ON o.respondenteid = s.respondenteid
                    WHERE o.id = s.ofertaid
                    AND o.respondenteid = :respId
                    AND o.questionarioid IN 
                        (SELECT id 
                        FROM questionario q 
                        WHERE elaboradorid = :elabId
                        AND (LOWER(q.nome) LIKE LOWER(:query) OR LOWER(q.descricao) LIKE LOWER(:query)))";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':query', '%'.$input.'%', PDO::PARAM_STR);
        $stmt->bindValue(':elabId', $elabId, PDO::PARAM_INT);
        $stmt->bindValue(':respId', $respId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

/*
    public function buscaQuestionariosSubmetidosPorRespondenteEElaboradorPaginado($input, $idResp, $idElab, $limit, $offset)
    {
        $questionarios = array();

        $query = "  SELECT q.id, q.nome, q.descricao, q.datacriacao as data_criado, o.data as data_submetido
                    FROM questionario q
                    INNER JOIN oferta o ON q.id = o.questionarioid
                    WHERE o.id IN (SELECT s.ofertaid FROM submissao s WHERE s.respondenteid = :idResp)
                    AND q.elaboradorid = :idElab
                    AND (LOWER(q.nome) LIKE LOWER(:query) OR LOWER(q.descricao) LIKE LOWER(:query))
                    LIMIT :limit OFFSET :offset
                 ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idResp', $idResp);
        $stmt->bindParam(':idElab', $idElab);
        $stmt->bindValue(':query', '%'.$input.'%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $questionarios[] = new Questionario($row['id'], $row['nome'], $row['descricao'], $row['data_criado'], null, null);
        }

        return $questionarios;
    }
    */

    public function buscaPorNomePaginado($nome, $respId, $limit, $offset)
    {
        $ofertas = array();

        $stmt = $this->conn->prepare(
                "SELECT o.id as ofertaid, o.data, o.questionarioid, o.respondenteid, q.id
                FROM {$this->table_name} o, questionario q
                WHERE (LOWER(q.nome) LIKE LOWER(:nome) OR LOWER(q.descricao) LIKE LOWER(:nome))
                AND o.questionarioid = q.id
                AND o.respondenteid = :id
                ORDER BY o.data DESC
                LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':nome', '%'.$nome.'%', PDO::PARAM_STR);
        $stmt->bindValue(':id', $respId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $ofertas[] = new Oferta($row['ofertaid'], $row['data'], $row['questionarioid'], $row['respondenteid']);
        }

        return $ofertas;
    }


    public function contaComNome($nome, $respId){
        $query = "SELECT COUNT(*) as contagem
                  FROM {$this->table_name} o, questionario q
                  WHERE (LOWER(q.nome) LIKE LOWER(:nome) OR LOWER(q.descricao) LIKE LOWER(:nome))
                  AND o.questionarioid = q.id
                  AND o.respondenteid = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', '%'.$nome.'%', PDO::PARAM_STR);
        $stmt->bindValue(':id', $respId, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            return $contagem;
        }

        return 0;
    }
}
?>
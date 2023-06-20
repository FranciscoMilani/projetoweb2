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

    
    public function altera($questionario) {
        $query = "UPDATE " . $this->table_name . 
        " SET nome = :nome, descricao = :descricao, datacriacao = :datacriacao, notaaprovacao = :notaaprovacao, elaboradorid = :elaboradorid" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(":id", $questionario->getId());
        $stmt->bindParam(":nome", $questionario->getNome());
        $stmt->bindParam(":descricao", $questionario->getDescricao());
        $stmt->bindParam(":datacriacao", $questionario->getDataCriacao());
        $stmt->bindParam(':notaaprovacao', $questionario->getNotaAprovacao());
        $stmt->bindParam(':elaboradorid', $questionario->getElaborador()->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }


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

    public function buscaPorElaboradorId($elabId){
        $questionarios = array();

        $query = "SELECT id, nome, descricao, datacriacao, notaaprovacao, elaboradorid
                  FROM {$this->table_name}
                  WHERE elaboradorid = :elaboradorid";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':elaboradorid', $elabId);
        $stmt->execute(); 
   
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $questionarios[] = new Questionario($id, $nome, $descricao, $datacriacao, $notaaprovacao, $elaboradorid);
        }

        return $questionarios;
    }

    public function buscaOfertasPorElaboradorId($elabId){
        $ofertas = array();

        $query = "SELECT o.id, o.data, o.questionarioid, o.respondenteid
                  FROM oferta o, questionario q
                  WHERE q.elaboradorid = :elaboradorid
                  AND o.questionarioid = q.id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':elaboradorid', $elabId);
        $stmt->execute(); 
   
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $ofertas[] = new Oferta($id, $data, $questionarioid, $respondenteid);
        }

        return $ofertas;
    }

    public function contaTopPorQtdOfertas($qtd){
        $ofertas = array();

        $query = "SELECT COUNT(*) AS contagem, q.id, SUBSTRING(q.nome, 1, 11) as nome
                  FROM questionario q, oferta o
                  WHERE o.questionarioid = q.id
                  GROUP BY q.id
                  ORDER BY contagem DESC, q.id ASC
                  LIMIT :qtd";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':qtd', $qtd);
        $stmt->execute(); 
   
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $ofertas[] = ['count' => $contagem, 'nome' => $nome];
        }

        return $ofertas;
    }

    public function contaTopPorQtdRespostas($qtd){
        $ofertas = array();

        $query = "SELECT COUNT(*) AS contagem, q.id, SUBSTRING(q.nome, 1, 11) as nome
                  FROM questionario q, oferta o, submissao s
                  WHERE o.questionarioid = q.id
                  AND s.ofertaid = o.id
                  GROUP BY q.id
                  ORDER BY contagem DESC, q.id ASC
                  LIMIT :qtd";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':qtd', $qtd);
        $stmt->execute(); 
   
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $ofertas[] = ['count' => $contagem, 'nome' => $nome];
        }

        return $ofertas;
    }

    public function contaTotalRespondidos(){
        $query = "  SELECT SUM(contagem) as contagemTotal
                    FROM
                    (
                        SELECT COUNT(*) AS contagem, q.id
                        FROM questionario q, oferta o, submissao s
                        WHERE o.questionarioid = q.id
                        AND o.id = s.ofertaid
                        GROUP BY q.id
                    ) as subquery   ";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute(); 

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function contaTotalNaoRespondidos(){
        $query = "  SELECT SUM(contagem) as contagemTotal
                    FROM
                    (
                        SELECT COUNT(*) as contagem
                        FROM questionario q
                        JOIN oferta o ON q.id = o.questionarioid
                        LEFT JOIN submissao s ON o.id = s.ofertaid
                        WHERE s.ofertaid IS NULL
                        GROUP BY q.id
                    ) as subquery  ";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute(); 

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function contaPorPercentualAprovacao($id){
        // TO-DO
        return null;
    }

    public function buscaPorNomePaginado($nome, $limit, $offset)
    {
        $questionarios = array();

        $stmt = $this->conn->prepare(
                "SELECT id, nome, descricao, datacriacao, notaaprovacao, elaboradorid
                FROM {$this->table_name}
                WHERE LOWER(nome) LIKE LOWER(:nome) OR LOWER(descricao) LIKE LOWER(:nome)
                ORDER BY datacriacao DESC
                LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':nome', '%'.$nome.'%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $questionarios[] = new Questionario($row['id'], $row['nome'], $row['descricao'], $row['datacriacao'], $row['notaaprovacao'], $row['elaboradorid']);
        }
        return $questionarios;
    }

    
    public function buscaDoElaboradorPorNomePaginado($nome, $elabId, $limit, $offset){
        $questionarios = array();

        $stmt = $this->conn->prepare(
                "SELECT id, nome, descricao, datacriacao, notaaprovacao, elaboradorid
                FROM {$this->table_name}
                WHERE (LOWER(nome) LIKE LOWER(:nome) OR LOWER(descricao) LIKE LOWER(:nome))
                AND elaboradorid = :elabId
                ORDER BY datacriacao DESC
                LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':nome', '%'.$nome.'%', PDO::PARAM_STR);
        $stmt->bindValue(':elabId', $elabId);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $questionarios[] = new Questionario($row['id'], $row['nome'], $row['descricao'], $row['datacriacao'], $row['notaaprovacao'], $row['elaboradorid']);
        }
        return $questionarios;
    }

    public function contaComNome($nome){
        $query = "SELECT COUNT(*) as contagem
                  FROM {$this->table_name}
                  WHERE LOWER(nome) LIKE LOWER(:nome) OR LOWER(descricao) LIKE LOWER(:nome)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', '%'.$nome.'%', PDO::PARAM_STR);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            return $contagem;
        }

        return 0;
    }

    public function contaDoElaboradorComNome($nome, $elabId){
        $query = "SELECT COUNT(*) as contagem
                  FROM {$this->table_name}
                  WHERE (LOWER(nome) LIKE LOWER(:nome) OR LOWER(descricao) LIKE LOWER(:nome))
                  AND elaboradorid = :elabId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', '%'.$nome.'%', PDO::PARAM_STR);
        $stmt->bindValue(':elabId', $elabId);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            return $contagem;
        }

        return 0;
    }
}
?>
<?php

include_once('QuestionarioQuestaoDao.php');
include_once('PostgresDao.php');

class PostgresQuestionarioQuestaoDao extends PostgresDao implements QuestionarioQuestaoDao {

    private $table_name = 'questionarioquestao';
    
    public function insere($questionarioquestao) {
        $query = "INSERT INTO " . $this->table_name . 
        " (pontos, ordem, questionarioid, questaoid) VALUES" .
        " (:pontos, :ordem, :questionarioid, :questaoid)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":pontos", $questionarioquestao->getPontos());
        $stmt->bindParam(":ordem", $questionarioquestao->getOrdem());
        $stmt->bindParam(":questionarioid", $questionarioquestao->getQuestionarioId());
        $stmt->bindParam(":questaoid", $questionarioquestao->getQuestaoId());

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function removePorIds($questionarioId, $questaoId) {
        $query = "DELETE FROM " . $this->table_name . 
        " WHERE questionarioid = :questionarioid " . 
        " AND questaoid = :questaoid ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':questionarioid', $questionarioId);
        $stmt->bindParam(':questaoid', $questaoId);

        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function remove($questionarioquestao) {
        return removePorIds($questionarioquestao->getQuestionarioId(),
                            $questionarioquestao->getQuestaoId());
    }

    /*                  IMPLEMENTAR ALTERAÇÃO SE FOR NECESSÁRIO
    
    public function altera($questionario) {

        $query = "UPDATE " . $this->table_name . 
        " SET login = :login, senha = :senha, nome = :nome, email = :email" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(":login", $usuario->getLogin());
        $stmt->bindParam(":senha", md5($usuario->getSenha()));
        $stmt->bindParam(":nome", $usuario->getNome());
        $stmt->bindParam(':email', $usuario->getEmail());
        $stmt->bindParam(':telefone', $usuario->getTelefone());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }
    */

    public function buscaPorIds($questionarioId, $questaoId) {
        $questionarioquestao = null;

        $query = "SELECT
                    pontos, ordem, questionarioid, questaoid
                FROM
                    " . $this->table_name . "
                WHERE
                    questionarioId = ?
                AND 
                    questaoId = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $questionarioId);
        $stmt->bindParam(2, $questaoId);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $questionarioquestao = new QuestionarioQuestao($row['pontos'], $row['ordem'], $row['questionarioid'], $row['questaoid']);
        } 
     
        return $questionarioquestao;
    }

    /* PENSAR SE PRECISA IMPLEMENTAR BUSCA TODOS */

    // public function buscaTodos() {
    //     $questionarios = array();

    //     $query = "SELECT
    //                 id, nome, descricao, datacriacao, notaaprovacao, elaboradorid
    //             FROM
    //                 " . $this->table_name . 
    //                 " ORDER BY datacriacao DESC";
     
    //     $stmt = $this->conn->prepare( $query );
    //     $stmt->execute();

    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //         extract($row);
    //         $questionarios[] = new Questionario($id, $nome, $descricao, $datacriacao, $notaaprovacao, $elaboradorid);
    //     }
        
    //     return $questionarios;
    // }
}
?>
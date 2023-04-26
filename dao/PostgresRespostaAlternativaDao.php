<?php 

    include_once 'RespostaAlternativaDao.php';
    include_once 'PostgresDao.php';

    class PostgresRespostaAlternativaDao extends PostgresDao implements RespostaAlternativaDao {
        
        private $table_name = 'respostaalternativa';

        public function insere($respostaAlternativa){

            $query = "INSERT INTO " . $this->table_name . 
            " (respostaid, alternativaid) VALUES" .
            " (:respostaid, :alternativaid)" .
            " RETURNING id";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":respostaid", $respostaAlternativa->getResposta());
            $stmt->bindParam(":alternativaid", $respostaAlternativa->getAlternativa());
    
            // retorna ID inserido
            if($stmt->execute()){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['id'];
            }else{
                return false;
            }
        }

        public function removePorResposta($respostaId) {
            $query = "DELETE FROM " . $this->table_name . 
            " WHERE respostaid = :id";
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':id', $respostaId);
    
            if($stmt->execute()){
                return true;
            }    
    
            return false;
        }

        public function buscaPorResposta($respostaId) {
            $respostaAlternativa = null;

            $query = "SELECT
                        id, respostaid, alternativaid
                    FROM
                        " . $this->table_name . "
                    WHERE
                        respostaid = id";
         
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(':id', $respostaId);
            $stmt->execute();
         
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $respostaAlternativa = new RespostaAlternativa($row['id'], $row['respostaid'], $row['alternativaid']);
            } 
         
            return $respostaAlternativa;
        }
    }

?>
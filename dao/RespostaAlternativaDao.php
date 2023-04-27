<?php 
    interface RespostaAlternativaDao {
        public function insere($resposta);
        public function removePorRespostaId($respostaId);
        public function buscaPorRespostaId($respostaId);
    }
?>
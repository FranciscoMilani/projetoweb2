<?php 
    interface RespostaAlternativaDao {
        public function insere($resposta);
        public function removePorResposta($resposta);
        public function buscaPorResposta($resposta);
    }
?>
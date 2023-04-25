<?php 
    interface RespostaDao {
        public function insere($resposta);
        public function remove($resposta);
        public function removePorId($id);
        public function buscaPorSubmissaoId($submissaoId);
        public function buscaTodos();
    } 
?>
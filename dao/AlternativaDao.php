<?php 
    interface AlternativaDao {
        public function insere($alternativa);
        //public function altera($alternativa);
        public function remove($alternativa);
        public function removePorId($id);
        public function buscaPorId($id);
        public function buscaPorQuestaoId($questaoId);
        public function buscaTodos();
    }
?>
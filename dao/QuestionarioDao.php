<?php 
    interface QuestionarioDao{
        public function insere($questionario);
        public function altera($questionario);
        public function remove($questionario);
        public function removePorId($id);
        public function buscaPorId($id);
        public function buscaTodos();
    }
?>
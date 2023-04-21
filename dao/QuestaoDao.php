<?php 
    interface QuestaoDao{
        public function insere($questao);
        public function altera($questao);
        public function remove($questao);
        public function removePorId($id);
        public function buscaPorId($id);
        public function buscaTodos();
    }
?>
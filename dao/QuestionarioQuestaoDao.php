<?php 
    interface QuestionarioQuestaoDao{
        public function insere($questionarioquestao);
        //public function altera($questionarioquestao);
        public function remove($questionarioquestao);
        public function removePorIds($questionarioId, $questaoId);
        public function buscaPorIds($questionarioId, $questaoId);
        //public function buscaTodos();
    }
?>
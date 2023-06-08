<?php 
    interface QuestaoDao{
        public function insere($questao);
        public function remove($questao);
        public function removePorId($id);
        public function buscaPorId($id);
        public function buscaTodos();
        public function buscaPorDescricaoTipoPaginado($desc, $isDisc, $isObj, $isMult, $limit, $offset);
        public function contaComDescricao($desc);
    }
?>
<?php 
    interface SubmissaoDao {
        public function insere($submissao);
        public function remove($submissao);
        public function removePorId($id);
        public function buscaTodos();
        public function buscaPorOfertaRespondenteId($ofertaId, $respondenteId);
    } 
?>
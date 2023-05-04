<?php 
    interface OfertaDao {
        public function insere($oferta);
        public function remove($oferta);
        public function removePorId($id);
        public function removePorQuestionarioId($id);
        public function buscaTodos();
        public function ofertasPorUsuario($id);
    } 
?>
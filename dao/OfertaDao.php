<?php 
    interface OfertaDao {
        public function insere($oferta);
        public function remove($oferta);
        public function removePorId($id);
        public function buscaTodos();
        public function ofertasPorUsuario($id);
        public function buscaPorQuestionarioId($id);
        public function buscaOfertasSubmetidasPorRespondenteEElaborador($input, $idResp, $idElab, $limit, $offset);
        public function buscaPorNomePaginado($nome, $respId, $limit, $offset);
        public function contaComNome($nome, $respId);
    } 
?>
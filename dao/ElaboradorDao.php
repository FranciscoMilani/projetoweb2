<?php 
    interface ElaboradorDAO {
        public function insere($elaborador);
        public function altera($elaborador);
        public function remove($elaborador);
        public function buscaPorNome($nome);
        public function removePorId($id);
        public function buscaPorId($id);
        public function buscaPorLogin($login);
        public function buscaTodos();
        public function buscaPorNomePaginado($nome, $limit, $offset);
        public function contaComNome($nome);
    } 
?>
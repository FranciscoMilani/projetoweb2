<?php
interface RespondenteDao {
    public function insere($respondente);
    public function altera($respondente);
    public function remove($respondente);
    public function buscaPorNome($nome);
    public function removePorId($id);
    public function buscaPorId($id);
    public function buscaPorLogin($login);
    public function buscaTodos();
    public function buscaPorNomePaginado($nome, $limit, $offset);
    public function contaComNome($nome);
}
?>
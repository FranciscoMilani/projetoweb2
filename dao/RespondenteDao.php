<?php
interface RespondenteDao {
    public function insere($respondente);
    public function altera($respondente);
    public function remove($respondente);
    public function buscaPorNome($nome);
    public function buscaPorEmail($email);
    public function removePorId($id);
    public function buscaPorId($id);
    public function buscaPorLogin($login);
    public function buscaTodos();
}
?>
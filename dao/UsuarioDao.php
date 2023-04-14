<?php
interface UsuarioDao {
    public function insere($usuario);
    public function altera($usuario);
    public function remove($usuario);
    public function buscaPorNome($nome);
    public function buscaPorEmail($email);
    public function removePorId($id);
    public function buscaPorId($id);
    public function buscaPorLogin($login);
    public function buscaTodos();
}
?>
<?php
include_once 'model/Usuario.php';
class Respondente extends Usuario
{
    private $telefone;

    public function __construct($id, $login, $senha, $nome, $email, $telefone)
    {
        parent::__construct($id, $login, $senha, $nome, $email);
        $this->telefone = $telefone;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getDadosParaJSON() {
        $data = ['id' => $this->getId(), 'login' => $this->getLogin(), 'senha' => $this->getSenha(), 'nome' => $this->getNome(), 'email' => $this->getEmail(), 'telefone' => $this->getTelefone()];
        return $data;
    }
}
?>
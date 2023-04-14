<?php
class Elaborador {
    
    private $id;
    private $login;
    private $senha;
    private $nome;
    private $email;
    private $instituicao;
    private $isAdmin;

    public function __construct( $id, $login, $senha, $nome, $email, $instituicao, $isAdmin)
    {
        $this->id=$id;
        $this->login=$login;
        $this->senha=$senha;
        $this->nome=$nome;
        $this->email=$email;
        $this->instituicao=$instituicao;
        $this->isAdmin=$isAdmin;
    }

    public function getId() { return $this->id; }
    public function setId($id) {$this->id = $id;}

    public function getLogin() { return $this->login; }
    public function setLogin($login) {$this->login = $login;}

    public function getNome() { return $this->nome; }
    public function setNome($nome) {$this->nome = $nome;}

    public function getSenha() { return $this->senha; }
    public function setSenha($senha) {$this->senha = $senha;}

    public function getEmail() { return $this->email; }
    public function setEmail($email) {$this->email = $email;}
    
    public function getInstituicao() { return $this->instituicao; }
    public function setInstituicao($instituicao) {$this->instituicao = $instituicao;}
    
    public function getIsAdmin() { return $this->isAdmin; }
    public function setIsAdmin($isAdmin) {$this->isAdmin = $isAdmin;}
}
?>
<?php
include_once 'model/Usuario.php';
class Elaborador extends Usuario
{
    private $instituicao;
    private $isAdmin;

    public function __construct($id, $login, $senha, $nome, $email, $instituicao, $isAdmin)
    {
        parent::__construct($id, $login, $senha, $nome, $email);
        $this->instituicao = $instituicao;
        $this->isAdmin = $isAdmin;
    }

    public function getInstituicao()
    {
        return $this->instituicao;
    }

    public function setInstituicao($instituicao)
    {
        $this->instituicao = $instituicao;
    }
    
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
}
?>
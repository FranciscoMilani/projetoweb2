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

    public function getDadosParaJSON($listQuest)
    {
        $data = [
            'id' => $this->getId(),
            'login' => $this->getLogin(),
            'senha' => $this->getSenha(),
            'nome' => $this->getNome(),
            'email' => $this->getEmail(),
            'telefone' => $this->getTelefone(),
            'Questionarios' => []
        ];
        foreach ($listQuest as $sub) {
            $data['Questionarios'][] = [
            'nomeQuestionario' => $sub->getOferta()->getQuestionario()->getNome(),
            'notaObtida' => $sub->getNotaTotal()
            ];
        }
        return $data;
    }
}
?>
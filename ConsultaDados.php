<?php 

include_once "verificaElaborador.php";
include_once "Fachada.php";

class QuestionarioManager {
    private $daoQ;

    public function __construct($daoQ) {
        $this->daoQ = $daoQ;
    }

    public function contaTopPorQtdOfertas() {
        $dados = $this->daoQ->contaTopPorQtdOfertas(5);
        return $dados;
    }

    public function contaTopPorQtdRespostas() {
        $dados = $this->daoQ->contaTopPorQtdRespostas(5);
        return $dados;
    }

    // public function contaTopPorPercentualAprovacao() {

    // }

    public function contaTotalPizza() {
        $dados = array();
        $dados['Total Respondidos'] = $this->daoQ->contaTotalRespondidos();
        $dados['Total Nao Respondidos'] = $this->daoQ->contaTotalNaoRespondidos();
        return $dados;
    }
}

$daoQ = $factory->getQuestionarioDao();
$qManager = new QuestionarioManager($daoQ);
$dados = array(
    "c1" => array("label" => "Qtd. Ofertas", "dados"=>$qManager->contaTopPorQtdOfertas()),
    "c2" => array("label" => "Qtd. Respostas", "dados"=>$qManager->contaTopPorQtdRespostas()),
    "c3" => $qManager->contaTotalPizza(),
);

echo json_encode($dados, JSON_PRETTY_PRINT);

?>
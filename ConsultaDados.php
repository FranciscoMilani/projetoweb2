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

    public function contaTopPorPercentualAprovacao($id) {
        $dados = [];
        if ($this->daoQ->buscaPorId($id)){
            $dados = $this->daoQ->contaPorPercentualAprovacao($id);
            
            if (!$dados['porcentagem_maior_igual'] || !$dados['porcentagem_menor']){
                return null;
            }

            $dados = [
                "% Aprovados" => $dados['porcentagem_maior_igual'],
                "% Reprovados" => $dados['porcentagem_menor'],
            ];
        }

        return $dados;
    }

    public function contaTotalPizza() {
        $dados = array();
        $dados = [
            "Nº Respondidos" => $this->daoQ->contaTotalRespondidos(),
            "Nº Não Respondidos" => $this->daoQ->contaTotalNaoRespondidos()
        ];

        return $dados;
    }
}

$daoQ = $factory->getQuestionarioDao();
$qManager = new QuestionarioManager($daoQ);
$dados = array(
    "c1" => array("label" => "Qtd. Ofertas", "dados" => $qManager->contaTopPorQtdOfertas()),
    "c2" => array("label" => "Qtd. Respostas", "dados" => $qManager->contaTopPorQtdRespostas()),
    "c3" => $qManager->contaTotalPizza(),
    "c4" => $qManager->contaTopPorPercentualAprovacao($_GET['questionarioId'])
);

echo json_encode($dados, JSON_PRETTY_PRINT);

?>
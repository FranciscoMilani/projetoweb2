<?php 
    class QuestionarioQuestao {
        private $pontos;
        private $ordem;
        private $questao;

        public function __construct($pontos, $ordem, $questao)
        {
            $this->pontos = $pontos;
            $this->ordem = $ordem;
            $this->questao = $questao;
        }
        
        public function getPontos() { return $this->pontos; }
        public function setPontos($pontos) { $this->pontos = $pontos; }

        public function getOrdem() { return $this->ordem; }
        public function setOrdem($ordem) { $this->ordem = $ordem; }

        public function getQuestao() { return $this->questao; }
        public function setQuestao($questao) { $this->questao = $questao; }
    }
?>
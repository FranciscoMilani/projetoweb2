<?php 
    class QuestionarioQuestao {
        private $pontos;
        private $ordem;
        private $questionarioId;
        private $questaoId;

        public function __construct($pontos, $ordem, $questionarioId, $questao)
        {
            $this->pontos = $pontos;
            $this->ordem = $ordem;
            $this->questionarioId = $questionarioId;
            $this->questaoId = $questaoId;
        }
        
        public function getPontos() { return $this->pontos; }
        public function setPontos($pontos) { $this->pontos = $pontos; }

        public function getOrdem() { return $this->ordem; }
        public function setOrdem($ordem) { $this->ordem = $ordem; }

        public function getQuestionarioId() { return $this->questionarioId; }
        public function setQuestionarioId($questionarioId) { $this->questionarioId = $questionarioId; }

        public function getQuestaoId() { return $this->questaoId; }
        public function setQuestaoId($questaoId) { $this->questaoId = $questaoId; }
    }
?>
<?php 
    class Resposta {
        private $texto;
        private $nota;
        private $alternativa;
        private $questao;

        public function __construct($texto, $nota, $alternativa, $questao){
            $this->texto = $texto;
            $this->nota = $nota;
            $this->alternativa = $alternativa;
            $this->questao = $questao;
        }

        public function getTexto() { return $this->texto; }
        public function setTexto($texto) { $this->texto = $texto; }

        public function getNota() { return $this->nota; }
        public function setNota($nota) { $this->nota = $nota; }

        public function getAlternativa() { return $this->alternativa; }
        public function setAlternativa($alternativa) { $this->alternativa = $alternativa; }

        public function getQuestao() { return $this->questao; }
        public function setQuestao($questao) { $this->questao = $questao; }
    }
?>
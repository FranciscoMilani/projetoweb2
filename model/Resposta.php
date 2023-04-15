<?php 
    class Resposta {
        private $texto;
        private $avaliacao;
        private $alternativa;
        private $questao;

        public function __construct($texto, $avaliacao){
            $this->texto = $texto;
            $this->avaliacao = $avaliacao;
        }

        public function getTexto() { return $this->texto; }
        public function setTexto($texto) { $this->texto = $texto; }

        public function getAvaliacao() { return $this->avaliacao; }
        public function setAvaliacao($avaliacao) { $this->avaliacao = $avaliacao; }

        public function getAlternativa() { return $this->alternativa; }
        public function setAlternativa($alternativa) { $this->alternativa = $alternativa; }

        public function getQuestao() { return $this->questao; }
        public function setQuestao($questao) { $this->questao = $questao; }
    }
?>
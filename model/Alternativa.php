<?php 
    class Alternativa {

        private $descricao;
        private $isCorreta;

        public function __construct($descricao, $isCorreta){
            $this->descricao = $descricao;
            $this->isCorreta = $isCorreta;
        }

        public function getDescricao() { return $this->descricao; }
        public function setDescricao($descricao) { $this->descricao = $descricao; }

        public function getIsCorreta() { return $this->isCorreta; }
        public function setIsCorreta($isCorreta) { $this->isCorreta = $isCorreta; }
    }
?>
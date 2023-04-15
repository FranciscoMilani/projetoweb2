<?php 

    class Questao {
        private $descricao;
        private $isDiscursiva;
        private $isObjetiva;
        private $isMultiplaEscolha;
        private $imagem;

        public function __construct($descricao, $isDiscursiva, $isObjetiva, $isMultiplaEscolha, $imagem) {
            $this->$descricao = $descricao;
            $this->$isDiscursiva = $isDiscursiva;
            $this->$isObjetiva = $isObjetiva;
            $this->$isMultiplaEscolha = $isMultiplaEscolha;
            $this->$imagem = $imagem;
        }

        public function getDescricao() { return $this->descricao; }
        public function setDescricao($descricao) {$this->descricao = $descricao;}

        public function getIsDiscursiva() { return $this->isDiscursiva; }
        public function setIsDiscursiva($isDiscursiva) {$this->isDiscursiva = $isDiscursiva;}

        public function getIsObjetiva() { return $this->isObjetiva; }
        public function setIsObjetiva($isObjetiva) {$this->isObjetiva = $isObjetiva;}

        public function getIsMultiplaEscolha() { return $this->isMultiplaEscolha; }
        public function setIsMultiplaEscolha($isMultiplaEscolha) {$this->isMultiplaEscolha = $isMultiplaEscolha;}

        public function getImagem() { return $this->imagem; }
        public function setImagem($imagem) {$this->imagem = $imagem;}
    }
    
?>
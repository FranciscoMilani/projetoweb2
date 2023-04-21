<?php 

    class Questao {

        private $id;
        private $descricao;
        private $isDiscursiva;
        private $isObjetiva;
        private $isMultiplaEscolha;
        private $imagem;
        private $alternativas = array();

        public function __construct($id, $descricao, $isDiscursiva, $isObjetiva, $isMultiplaEscolha) {
            $this->id = $id;
            $this->$descricao = $descricao;
            $this->$isDiscursiva = $isDiscursiva;
            $this->$isObjetiva = $isObjetiva;
            $this->$isMultiplaEscolha = $isMultiplaEscolha;
        }

        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; }

        public function getDescricao() { return $this->descricao; }
        public function setDescricao($descricao) {$this->descricao = $descricao;}

        public function getIsDiscursiva() { return $this->isDiscursiva; }
        public function setIsDiscursiva($isDiscursiva) {$this->isDiscursiva = $isDiscursiva;}

        public function getIsObjetiva() { return $this->isObjetiva; }
        public function setIsObjetiva($isObjetiva) {$this->isObjetiva = $isObjetiva;}

        public function getIsMultiplaEscolha() { return $this->isMultiplaEscolha; }
        public function setIsMultiplaEscolha($isMultiplaEscolha) {$this->isMultiplaEscolha = $isMultiplaEscolha;}

        public function getAlternativas() { return $this->alternativas; }
        public function setAlternativas($alternativas) {$this->alternativas = $alternativas;}

        public function addAlternativa($alternativa) { array_push($alternativa); }
    }
    
?>
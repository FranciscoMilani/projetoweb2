<?php 

    class Questao {

        private $id;
        private $descricao;
        private $isDiscursiva;
        private $isObjetiva;
        private $isMultiplaEscolha;
        private $imagem;
        private $alternativas = array();
        private $tipo;

        public function __construct($id, $descricao, $isDiscursiva, $isObjetiva, $isMultiplaEscolha, $imagem) {
            $this->id = $id;
            $this->descricao = $descricao;
            $this->isDiscursiva = $isDiscursiva;
            $this->isObjetiva = $isObjetiva;
            $this->isMultiplaEscolha = $isMultiplaEscolha;
            $this->imagem = $imagem;
            $this->tipo = $this->definirTipo();
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

        public function getImagem() { return $this->imagem; }
        public function setImagem($imagem) {$this->imagem = $imagem;}

        public function getAlternativas() { return $this->alternativas; }
        public function setAlternativas($alternativas) {$this->alternativas = $alternativas;}

        public function addAlternativa($alternativa) { array_push($alternativa); }

        public function getTipo(){ return $this->tipo; }
        public function setTipo(Tipo $tipo){ $this->tipo = $tipo; }

        private function definirTipo() {
            if ($this->isDiscursiva || $this->isDiscursiva == 1) {
                return Tipo::DISCURSIVA;
            } elseif ($this->isObjetiva || $this->isObjetiva == 1) {
                return Tipo::OBJETIVA;
            } elseif ($this->isMultiplaEscolha || $this->isMultiplaEscolha == 1) {
                return Tipo::MULTIPLA_ESCOLHA;
            } else {
                return Tipo::UNDEFINED;
            }
        }
    }
    
    abstract class Tipo {
        const UNDEFINED = "?";
        const DISCURSIVA = "Discursiva";
        const OBJETIVA = "Objetiva";
        const MULTIPLA_ESCOLHA = "Multipla Escolha";
    }
?>
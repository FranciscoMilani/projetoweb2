<?php 
    class Alternativa {

        private $id;
        private $descricao;
        private $isCorreta;
        private $questao;

        public function __construct($id, $descricao, $isCorreta, $questao){
            $this->id = $id;
            $this->descricao = $descricao;
            $this->isCorreta = $isCorreta;
            $this->questao = $questao;
        }

        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; }

        public function getDescricao() { return $this->descricao; }
        public function setDescricao($descricao) { $this->descricao = $descricao; }

        public function getIsCorreta() { return $this->isCorreta; }
        public function setIsCorreta($isCorreta) { $this->isCorreta = $isCorreta; }

        public function getQuestao() { return $this->questao; }
        public function setQuestao($questao) { $this->questao = $questao; }
    }
?>
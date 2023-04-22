<?php 
    class Questionario {

        private $id;
        private $nome;
        private $descricao;
        private $dataCriacao;
        private $notaAprovacao;
        private $elaborador;
        private $questionarioQuestao = array();

        public function __construct($id, $nome, $descricao, $dataCriacao, $notaAprovacao, $elaborador)
        {
            $this->id = $id;
            $this->nome = $nome;
            $this->descricao = $descricao;
            $this->dataCriacao = $dataCriacao;
            $this->notaAprovacao = $notaAprovacao;
            $this->elaborador = $elaborador;
        }

        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; }
        
        public function getNome() { return $this->nome; }
        public function setNome($nome) { $this->nome = $nome; }

        public function getDescricao() { return $this->descricao; }
        public function setDescricao($descricao) { $this->descricao = $descricao; }

        public function getDataCriacao() { return $this->dataCriacao; }
        public function setDataCriacao($dataCriacao) { $this->dataCriacao = $dataCriacao; }

        public function getNotaAprovacao() { return $this->notaAprovacao; }
        public function setNotaAprovacao($notaAprovacao) { $this->notaAprovacao = $notaAprovacao; }

        public function getElaborador() { return $this->elaborador; }
        public function setElaborador($elaborador) { $this->elaborador = $elaborador; }

        public function getQuestionarioQuestao() { return $this->questionarioQuestao; }
        public function setQuestionarioQuestao($questionarioQuestao) {$this->questionarioQuestao = $questionarioQuestao;}

        public function addQuestionarioQuestao($questionarioQuestao) { array_push($questionarioQuestao); }
    }
?>
<?php 
    class Questionario {
        private $nome;
        private $descricao;
        private $dataCriacao;
        private $notaAprovacao;
        private $elaborador;
        private $questionarioQuestao = array();

        public function __construct($nome, $descricao, $dataCriacao, $notaAprovacao)
        {
            $this->nome = $nome;
            $this->descricao = $descricao;
            $this->dataCriacao = $dataCriacao;
            $this->notaAprovacao = $notaAprovacao;
        }
        
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
    }
?>
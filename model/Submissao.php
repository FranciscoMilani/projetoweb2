<?php 

    class Submissao {
        private $nomeOcasiao;
        private $descricao;
        private $data;
        private $respostas = array();

        public function __construct($nomeOcasiao, $descricao, $data, $respostas)
        {
            $this->nomeOcasiao = $nomeOcasiao;
            $this->descricao = $descricao;
            $this->data = $data;
            $this->respostas = $respostas;
        }

        public function getNomeOcasiao() { return $this->nomeOcasiao; }
        public function setNomeOcasiao($nomeOcasiao) { $this->nomeOcasiao = $nomeOcasiao; }

        public function getDescricao() { return $this->descricao; }
        public function setDescricao($descricao) { $this->descricao = $descricao; }

        public function getData() { return $this->data; }
        public function setData($data) { $this->data = $data; }

        public function getRespostas() { return $this->respostas; }
        public function setRespostas($respostas) { $this->respostas = $respostas; }

        public function addResposta($resposta) { array_push($resposta); }
    }

?>
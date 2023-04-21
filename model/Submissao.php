<?php 

    class Submissao {
        private $nomeOcasiao;
        private $descricao;
        private $data;
        private $ofertaAtendida;
        private $respostas = array();

        public function __construct($nomeOcasiao, $descricao, $data, $ofertaAtendida, $respostas)
        {
            $this->nomeOcasiao = $nomeOcasiao;
            $this->descricao = $descricao;
            $this->data = $data;
            $this->ofertaAtendida = $ofertaAtendida;
            $this->respostas = $respostas;
        }

        public function getNomeOcasiao() { return $this->nomeOcasiao; }
        public function setNomeOcasiao($nomeOcasiao) { $this->nomeOcasiao = $nomeOcasiao; }

        public function getDescricao() { return $this->descricao; }
        public function setDescricao($descricao) { $this->descricao = $descricao; }

        public function getData() { return $this->data; }
        public function setData($data) { $this->data = $data; }

        public function getOferta() { return $this->ofertaAtendida; }
        public function setOferta($ofertaAtendida) { $this->ofertaAtendida = $ofertaAtendida; }

        public function getRespostas() { return $this->respostas; }
        public function setRespostas($respostas) { $this->respostas = $respostas; }

        public function addResposta($resposta) { array_push($resposta); }
    }

?>
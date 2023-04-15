<?php 
    class Oferta {
        private $data;
        private $questionario;
        private $respondente;

        public function __construct($data, $questionario){
            $this->data = $data;
            $this->questionario = $questionario;
        }

        public function getData() { return $this->data; }
        public function setData($data) { $this->data = $data; }

        public function getQuestionario() { return $this->questionario; }
        public function setQuestionario($questionario) { $this->questionario = $questionario; }

        public function getRespondente() { return $this->respondente; }
        public function setRespondente($respondente) { $this->respondente = $respondente; }
    }
?>
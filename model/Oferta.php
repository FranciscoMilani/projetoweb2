<?php 
    class Oferta {
        private $data;
        private $questionario;
        private $respondente;
        private $id;

        public function __construct($id, $data, $questionario){
            $this->id = $id;
            $this->data = $data;
            $this->questionario = $questionario;
        }

        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; }

        public function getData() { return $this->data; }
        public function setData($data) { $this->data = $data; }

        public function getQuestionario() { return $this->questionario; }
        public function setQuestionario($questionario) { $this->questionario = $questionario; }

        public function getRespondente() { return $this->respondente; }
        public function setRespondente($respondente) { $this->respondente = $respondente; }
    }
?>
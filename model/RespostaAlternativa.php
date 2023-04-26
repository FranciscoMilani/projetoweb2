<?php 

    class RespostaAlternativa {

        private $id;
        private $resposta;
        private $alternativa;

        public function __construct($id, $resposta, $alternativa){
            $this->id = $id;
            $this->resposta = $resposta;
            $this->alternativa = $alternativa;
        }

        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; }

        public function getResposta() { return $this->resposta; }
        public function setResposta($resposta) { $this->resposta = $resposta; }

        public function getAlternativa() { return $this->alternativa; }
        public function setAlternativa($alternativa) { $this->alternativa = $alternativa; }
    }

?>
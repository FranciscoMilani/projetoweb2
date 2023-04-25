<?php 
    class Resposta {

        private $id;
        private $texto;
        private $nota;
        private $observacao;
        private $alternativa;
        private $questao;
        private $submissao;

        public function __construct($id, $texto, $nota, $observacao, $alternativa, $questao, $submissao){
            $this->id = $id;
            $this->texto = $texto;
            $this->nota = $nota;
            $this->observacao = $observacao;
            $this->alternativa = $alternativa;
            $this->questao = $questao;
            $this->submissao = $submissao;
        }

        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; }

        public function getTexto() { return $this->texto; }
        public function setTexto($texto) { $this->texto = $texto; }

        public function getNota() { return $this->nota; }
        public function setNota($nota) { $this->nota = $nota; }
        
        public function getObservacao() { return $this->observacao; }
        public function setObservacao($observacao) { $this->observacao = $observacao; }

        public function getAlternativa() { return $this->alternativa; }
        public function setAlternativa($alternativa) { $this->alternativa = $alternativa; }

        public function getQuestao() { return $this->questao; }
        public function setQuestao($questao) { $this->questao = $questao; }

        public function getSubmissao() { return $this->submissao; }
        public function setSubmissao($submissao) { $this->submissao = $submissao; }
    }
?>
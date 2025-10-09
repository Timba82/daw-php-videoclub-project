<?php
    
    abstract class Soporte extends Resumible{
        public $titulo;
        protected $numero;
        private $precio;
        const IVA=0.21;

        public function __construct($titulo,$numero,$precio){
            $this->titulo=$titulo;
            $this->numero=$numero;
            $this->precio=$precio;
        }
        
        public function getPrecio(){
            return $this->precio;
        }
        public function getPrecioConIva(){
            return $this->precio*(1+ self::IVA);
        }
        public function getNumero(){
            return $this->numero;
        }
        public function muestraResumen(){
            echo  "<br>Número: " . $this->numero . 
             ",<br>Título: " . $this->titulo . 
             ",<br> Precio: " . $this->precio . 
             ",<br> Precio con IVA ". $this->getPrecioConIva();
        }
    }
?>
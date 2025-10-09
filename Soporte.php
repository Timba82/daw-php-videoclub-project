<?php
    
    /**
     * Clase Soporte.
     *
     * Representa la entidad soporte del videoclub.
     *
     * Extiende: Resumible.
     */

    abstract class Soporte extends Resumible{
        public $titulo;
        protected $numero;        
        private $precio;
        const IVA = 0.21;

        /**
         * __construct.
         *
         * @param mixed $titulo Parámetro.
         * @param mixed $numero Parámetro.
         * @param mixed $precio Parámetro.
         */

        public function __construct($titulo,$numero,$precio){
            $this->titulo=$titulo;
            $this->numero=$numero;
            $this->precio=$precio;
        }
        
        /**
         * GetPrecio.
         * @return mixed Resultado.
         */

        public function getPrecio(){
            return $this->precio;
        }
        /**
         * GetPrecioConIva.
         * @return mixed Resultado.
         */

        public function getPrecioConIva(){
            return $this->precio*(1+ self::IVA);
        }
        /**
         * GetNumero.
         * @return mixed Resultado.
         */

        public function getNumero(){
            return $this->numero;
        }
        /**
         * MuestraResumen.
         * @return mixed Resultado.
         */

        public function muestraResumen(){
            echo  "<br>Número: " . $this->numero . 
             ",<br>Título: " . $this->titulo . 
             ",<br> Precio: " . $this->precio . 
             ",<br> Precio con IVA ". $this->getPrecioConIva();
        }
    }
?>
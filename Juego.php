<?php
    require_once 'Soporte.php';
    class Juego extends Soporte{
        // Atributos adicional
        public $consola;
        private $minNumJugadores;
        private $maxNumJugadores;

        // Constructor que llama al constructor del padre
        public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores) {
        // Llamar al constructor de la clase padre
            parent::__construct($titulo, $numero, $precio);
            $this->consola=$consola;
            $this->minNumJugadores = $minNumJugadores;
            $this->maxNumJugadores = $maxNumJugadores;
        }
    
        // Método para obtener los jugadores minimos 
        public function getMinNumJugadores() {
            return $this->minNumJugadores;
        }
        // Método para obtener los jugadores maximos
        public function getMaxNumJugadores() {
            return $this->maxNumJugadores;
        }


        public function muestraJugadoresPosibles() {
            if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
                echo "Para un jugador";
            } elseif ($this->minNumJugadores == $this->maxNumJugadores) {
                echo "Para " . $this->minNumJugadores . " jugadores";
            } else {
                echo "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores . " jugadores";
            }
        }

        public function muestraResumen() {
            // Llamar al método muestraResumen del padre
            parent::muestraResumen();
            // Añadir información específica de Juego
            echo ",<br> Consola: " . $this->consola . ", <br>";
            $this->muestraJugadoresPosibles();
        }
    }
?>
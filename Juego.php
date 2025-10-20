<?php
    // v0.331
    namespace Dwes\ProyectoVideoclub;
    require_once 'Soporte.php';
    /**
     * Clase Juego.
     *
     * Representa la entidad juego del videoclub.
     *
     * Extiende: Soporte.
     */

    class Juego extends Soporte{
        public $consola;
        private $minNumJugadores;
        private $maxNumJugadores;

        // Constructor que llama al constructor del padre
        /**
         * __construct.
         *
         * @param mixed $titulo Parámetro.
         * @param mixed $numero Parámetro.
         * @param mixed $precio Parámetro.
         * @param mixed $consola Parámetro.
         * @param mixed $minNumJugadores Parámetro.
         * @param mixed $maxNumJugadores Parámetro.
         */

        public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores) {
        // Llamar al constructor de la clase padre
            parent::__construct($titulo, $numero, $precio);
            $this->consola=$consola;
            $this->minNumJugadores = $minNumJugadores;
            $this->maxNumJugadores = $maxNumJugadores;
        }
    
        // Método para obtener los jugadores minimos 
        /**
         * GetMinNumJugadores.
         * @return mixed EL número mínimo de jugadores.
         */

        public function getMinNumJugadores() {
            return $this->minNumJugadores;
        }
        // Método para obtener los jugadores maximos
        /**
         * GetMaxNumJugadores.
         * @return mixed EL número máximo de jugadores.
         */

        public function getMaxNumJugadores() {
            return $this->maxNumJugadores;
        }


        /**
         * MuestraJugadoresPosibles.
         * @return mixed Resultado.
         */

        public function muestraJugadoresPosibles() {
            if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
                echo "Para un jugador";
            } elseif ($this->minNumJugadores == $this->maxNumJugadores) {
                echo "Para " . $this->minNumJugadores . " jugadores";
            } else {
                echo "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores . " jugadores";
            }
        }

        /**
         * MuestraResumen.
         * @return mixed Resultado.
         */

        public function muestraResumen(): void {
            // Llamar al método muestraResumen del padre
            parent::muestraResumen();
            // Añadir información específica de Juego
            echo ",<br> Consola: " . $this->consola . ", <br>";
            $this->muestraJugadoresPosibles();
        }
    }
?>
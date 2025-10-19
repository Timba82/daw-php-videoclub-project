<?php
    require_once 'Soporte.php';
    
    /**
     * Clase CintaVideo.
     *
     * Representa la entidad cintavideo del videoclub.
     *
     * Extiende: Soporte.
     */
    class CintaVideo extends Soporte{
        private $duracion;
    
        // Constructor que llama al constructor del padre
        /**
         * __construct.
         *
         * @param mixed $titulo Parámetro.
         * @param mixed $numero Parámetro.
         * @param mixed $precio Parámetro.
         * @param mixed $duracion Parámetro.
         */

        public function __construct($titulo, $numero, $precio, $duracion) {
        // Llamar al constructor de la clase padre
            parent::__construct($titulo, $numero, $precio);
            $this->duracion = $duracion;
        }
    
        // Método para obtener la duración
        /**
         * GetDuracion.
         * @return mixed Resultado.
         */

        public function getDuracion() {
            return $this->duracion;
        }

        /**
         * MuestraResumen.
         * @return mixed Resultado.
         */

        public function muestraResumen() {
            // Llamar al método muestraResumen del padre
            parent::muestraResumen();
            // Añadir información específica de CintaVideo
            echo ",<br> Duración: " . $this->duracion . " minutos";
        }
    }
?>
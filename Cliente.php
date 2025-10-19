
<?php
    // v0.331
    namespace Dwes\ProyectoVideoclub;
    /**
     * Clase Cliente.
     *
     * Representa la entidad cliente del videoclub.
     */

    class Cliente {

        public $nombre;
        private $numero;
        private $maxAlquilerConcurrente;        
        private array $soportesAlquilados;
        private $numSoportesAlquilados;
        
        // Constructor
        /**
         * __construct.
         *
         * @param mixed $nombre Parámetro.
         * @param mixed $numero Parámetro.
         * @param mixed $maxAlquilerConcurrente Parámetro.   
         */

        public function __construct($nombre, $numero, $maxAlquilerConcurrente = 3) {
            $this->nombre = $nombre;
            $this->numero = $numero;
            $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
            $this->soportesAlquilados = [];
            $this->numSoportesAlquilados = 0;
        }
        
        // Getters y Setters
        /**
         * GetNumero.
         * @return mixed Resultado.
         */

        public function getNumero() {
            return $this->numero;
        }
        
        /**
         * SetNumero.
         *
         * @param mixed $numero Parámetro.
         * @return mixed Resultado.
         */

        public function setNumero($numero) {
            $this->numero = $numero;
        }
        
        /**
         * GetNumSoportesAlquilados.
         * @return mixed Resultado.
         */

        public function getNumSoportesAlquilados() {
            return $this->numSoportesAlquilados;
        }
        

        // Método tieneAlquilado
        /**
         * TieneAlquilado.
         *
         * @param Soporte $s Parámetro.
         * @return bool Resultado.
         */

        public function tieneAlquilado(Soporte $s): bool {
            $encontrado=false;
            foreach ($this->soportesAlquilados as $soporte) {
                if ($soporte->getNumero() === $s->getNumero()) {
                    $encontrado=true;
                }
            }
            return $encontrado;
        }
        
        // Método alquilar
        /**
         * Alquilar.
         *
         * @param Soporte $s Parámetro.
         * @return bool Resultado.
         */

        public function alquilar(Soporte $s): Cliente {
            if ($this->tieneAlquilado($s)) {
                echo "<br>El soporte " . $s->getNumero() . " ya está alquilado por " . $this->nombre;
            } elseif ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
                echo "<br>" . $this->nombre . " ha superado el cupo máximo de " . $this->maxAlquilerConcurrente . " alquileres";
            } else {
                $this->soportesAlquilados[] = $s;
                $this->numSoportesAlquilados++;
                echo "<br>" . $this->nombre . " ha alquilado el soporte " . $s->getNumero() . " correctamente";
            }

            return $this; // permite encadenamiento
        }
        
        // Método devolver
        /**
         * Devolver.
         *
         * @param int $numSoporte Parámetro.
         * @return bool Resultado.
         */

        public function devolver(int $numSoporte): bool {

            foreach ($this->soportesAlquilados as $indice => $soporte) {
                if ($soporte->getNumero() === $numSoporte) {
                    // Encontrado, proceder a devolución
                    array_splice($this->soportesAlquilados, $indice, 1);
                    $this->numSoportesAlquilados--;
                    echo "<br>" . $this->nombre . " ha devuelto el soporte " . $numSoporte . " correctamente";
                    return true;
                }
            }
            
            echo "<br>El soporte " . $numSoporte . " no estaba alquilado por " . $this->nombre;
            return false;
        }
        
        // Método listarAlquileres
        /**
         * ListaAlquileres.
         * @return void Resultado.
         */

        public function listaAlquileres(): void {
            echo "<br>Alquileres de " . $this->nombre . ":";
            echo "<br>Total de alquileres: " . $this->numSoportesAlquilados;
            
            if ($this->numSoportesAlquilados > 0) {
                echo "<br>Soportes alquilados:";
                foreach ($this->soportesAlquilados as $soporte) {
                    echo "<br> Soporte " . $soporte->getNumero() . ": " . $soporte->titulo;
                }
            } else {
                echo "<br>No tiene soportes alquilados actualmente";
            }
        }
        
        // Método muestraResumen
        /**
         * MuestraResumen.
         * @return mixed Resultado.
         */

        public function muestraResumen() {
            echo "<br>Resumen del Cliente: <br>Nombre: " . $this->nombre;
            echo "<br>Alquileres actuales: " . $this->numSoportesAlquilados ;
        }
    }
?>

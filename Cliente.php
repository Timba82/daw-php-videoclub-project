<?php
    // v0.331
    namespace Dwes\ProyectoVideoclub;
    /**
     * Clase Cliente.
     *
     * Representa la entidad cliente del videoclub.
     */

    use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
    use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
    use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;

    require_once __DIR__ . '/Util/VideoclubException.php';
    require_once __DIR__ . '/Util/SoporteYaAlquiladoException.php';
    require_once __DIR__ . '/Util/CupoSuperadoException.php';
    require_once __DIR__ . '/Util/SoporteNoEncontradoException.php';

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
         * @return self
         * @throws SoporteYaAlquiladoException
         * @throws CupoSuperadoException
         */

        public function alquilar(Soporte $s): self {
            if ($this->tieneAlquilado($s)) {
                throw new SoporteYaAlquiladoException(
                    "El soporte {$s->getNumero()} ya está alquilado por {$this->nombre}"
                );
            }
            if ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
                throw new CupoSuperadoException(
                    "{$this->nombre} ha superado el cupo máximo de {$this->maxAlquilerConcurrente} alquileres"
                );
            }

            $this->soportesAlquilados[] = $s;
            $this->numSoportesAlquilados++;
            $s->alquilado = true;

            return $this; // encadenamiento
        }
        
        // Método devolver
        /**
         * Devolver.
         *
         * @param int $numSoporte Parámetro.
         * @return self  Devuelve el propio cliente para encadenar.
         * @throws SoporteNoEncontradoException
         */

        public function devolver(int $numSoporte): self {

            foreach ($this->soportesAlquilados as $indice => $soporte) {
                if ($soporte->getNumero() === $numSoporte) {
                    array_splice($this->soportesAlquilados, $indice, 1);
                    $this->numSoportesAlquilados--;

                    $soporte->alquilado = false;
                    
                    return $this; // encadenamiento
                }
            }

            throw new SoporteNoEncontradoException(
                "El soporte {$numSoporte} no estaba alquilado por {$this->nombre}"
            );
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

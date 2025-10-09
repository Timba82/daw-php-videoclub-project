<?php
    class Cliente {
        // Atributos
        private $nombre;
        private $numero;
        private $maxAlquilerConcurrente;
        private $soportesAlquilados;
        private $numSoportesAlquilados;
        
        // Constructor
        public function __construct($nombre, $numero, $maxAlquilerConcurrente = 3) {
            $this->nombre = $nombre;
            $this->numero = $numero;
            $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
            $this->soportesAlquilados = [];
            $this->numSoportesAlquilados = 0;
        }
        
        // Getters y Setters
        public function getNumero() {
            return $this->numero;
        }
        
        public function setNumero($numero) {
            $this->numero = $numero;
        }
        
        public function getNumSoportesAlquilados() {
            return $this->numSoportesAlquilados;
        }
        

        // Método tieneAlquilado
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
        public function alquilar(Soporte $s): bool {
            $superado=true;
            // Comprobar si ya está alquilado
            if ($this->tieneAlquilado($s)) {
                echo "<br>El soporte " . $s->getNumero() . " ya está alquilado por " . $this->nombre;
                $superado=false;
            }else{
                // Comprobar cupo máximo
                if ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
                    echo "<br>" . $this->nombre . " ha superado el cupo máximo de " . $this->maxAlquilerConcurrente . " alquileres";
                    $superado=false;
                }else{
                    // Alquilar el soporte
                    $this->soportesAlquilados[] = $s;
                    $this->numSoportesAlquilados++;
                    echo "<br>" . $this->nombre . " ha alquilado el soporte " . $s->getNumero() . " correctamente";
                }

            }
            return $superado;
        }
        
        // Método devolver
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
        public function muestraResumen() {
            echo "<br>Resumen del Cliente: <br>Nombre: " . $this->nombre;
            echo "<br>Alquileres actuales: " . $this->numSoportesAlquilados ;
        }
    }
?>
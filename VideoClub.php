<?php
    // v0.331
    namespace Dwes\ProyectoVideoclub;
    require_once 'Soporte.php';
    require_once 'CintaVideo.php';
    require_once 'Dvd.php';
    require_once 'Juego.php';
    require_once 'Cliente.php';

    

    use Dwes\ProyectoVideoclub\Util|{
        VideoclubException,
        ClienteNoEncontradoException,
        SoporteNoEncontradoException,
        SoporteYaAlquiladoException,
        CupoSuperadoException
    };

    /**
     * Clase Videoclub.
     *
     * Representa la entidad videoclub del videoclub.
     */

    class Videoclub {
        private $nombre;
        private array $productos;
        private $numProductos;
        private array $socios;
        private $numSocios;
        private int $numProductosAlquilados;
        private int $numTotalAlquileres;
        
        // Constructor
        /**
         * __construct.
         *
         * @param mixed $nombre Parámetro.
         */

        public function __construct($nombre) {
            $this->nombre = $nombre;
            $this->productos = [];
            $this->numProductos = 0;
            $this->socios = [];
            $this->numSocios = 0;
            $this->numProductosAlquilados = 0;
            $this->numTotalAlquileres = 0;
        }
        
        // Método privado para incluir productos
        /**
         * IncluirProducto.
         *
         * @param Soporte $producto Parámetro.
         * @return mixed Resultado.
         */

        private function incluirProducto(Soporte $producto) {
            $this->productos[] = $producto;
            $this->numProductos++;
        }
        
        // Métodos públicos para incluir diferentes tipos de soportes
        /**
         * IncluirCintaVideo.
         *
         * @param mixed $titulo Parámetro.
         * @param mixed $precio Parámetro.
         * @param mixed $duracion Parámetro.
         * @return mixed Resultado.
         */

        public function incluirCintaVideo($titulo, $precio, $duracion) {
            // Generar número único para el producto
            $numero = $this->numProductos + 1;
            $cintaVideo = new CintaVideo($titulo, $numero, $precio, $duracion);
            $this->incluirProducto($cintaVideo);
            return $cintaVideo;
        }
        
        /**
         * IncluirDvd.
         *
         * @param mixed $titulo Parámetro.
         * @param mixed $precio Parámetro.
         * @param mixed $idiomas Parámetro.
         * @param mixed $pantalla Parámetro.
         * @return mixed Resultado.
         */

        public function incluirDvd($titulo, $precio, $idiomas, $pantalla) {
            $numero = $this->numProductos + 1;
            $dvd = new Dvd($titulo, $numero, $precio, $idiomas, $pantalla);
            $this->incluirProducto($dvd);
            return $dvd;
        }
        
        /**
         * IncluirJuego.
         *
         * @param mixed $titulo Parámetro.
         * @param mixed $precio Parámetro.
         * @param mixed $consola Parámetro.
         * @param mixed $minJ Parámetro.
         * @param mixed $maxJ Parámetro.
         * @return mixed Resultado.
         */

        public function incluirJuego($titulo, $precio, $consola, $minJ, $maxJ) {
            $numero = $this->numProductos + 1;
            $juego = new Juego($titulo, $numero, $precio, $consola, $minJ, $maxJ);
            $this->incluirProducto($juego);
            return $juego;
        }
        
        // Método para incluir socios
        /**
         * IncluirSocio.
         *
         * @param mixed $nombre Parámetro.
         * @param mixed $maxAlquileresConcurrentes Parámetro.
         * @return mixed Resultado.
         */

        public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3) {
            $numero = $this->numSocios + 1;
            $socio = new Cliente($nombre, $numero, $maxAlquileresConcurrentes);
            $this->socios[] = $socio;
            $this->numSocios++;
            return $socio;
        }
        
        // Método para listar productos
        /**
         * ListarProductos.
         * @return mixed Resultado.
         */

        public function listarProductos() {
            echo "<br><strong>Productos del videoclub " . $this->nombre . ":</strong>";
            echo "<br>Total de productos: " . $this->numProductos;
            
            if ($this->numProductos > 0) {
                foreach ($this->productos as $producto) {
                    echo "<br><br>";
                    $producto->muestraResumen();
                }
            } else {
                echo "<br>No hay productos en el videoclub";
            }
            echo "<br>";
        }
        
        // Método para listar socios
        /**
         * ListarSocios.
         * @return mixed Resultado.
         */

        public function listarSocios() {
            echo "<br><strong>Socios del videoclub " . $this->nombre . ":</strong>";
            echo "<br>Total de socios: " . $this->numSocios;
            
            if ($this->numSocios > 0) {
                foreach ($this->socios as $socio) {
                    echo "<br><br>";
                    $socio->muestraResumen();
                }
            } else {
                echo "<br>No hay socios en el videoclub";
            }
            echo "<br>";
        }
        
        // Método para alquilar un producto a un socio
        /**
         * AlquilaSocioProducto.
         *
         * @param mixed $numeroCliente Parámetro.
         * @param mixed $numeroSoporte Parámetro.
         * @return mixed Resultado.
         */

        public function alquilaSocioProducto($numeroCliente, $numeroSoporte): Videoclub {
            try {
                // Buscar cliente
                $cliente = $this->buscarCliente($numeroCliente);
                if (!$cliente) {
                    throw new ClienteNoEncontradoException("No existe el cliente con número {$numeroCliente}");
                }

                // Buscar producto
                $producto = $this->buscarProducto($numeroSoporte);
                if (!$producto) {
                    throw new SoporteNoEncontradoException("No existe el producto con número {$numeroSoporte}");
                }

                // Intentar alquiler (puede lanzar excepciones)
                // Guardar estado previo por si hace falta ajustar contadores
                $estabaAlquiladoAntes = $producto->alquilado ?? false; 
                $cliente->alquilar($producto);

                // Si antes no estaba alquilado y ahora sí, actualizamos contadores
                if (!$estabaAlquiladoAntes && ($producto->alquilado ?? false) === true) { 
                    $this->numProductosAlquilados++;                                       
                    $this->numTotalAlquileres++;                                           
                }

                echo "<br>El cliente {$cliente->nombre} ha alquilado el producto {$numeroSoporte} correctamente.";
            }

            catch (
                ClienteNoEncontradoException |
                SoporteNoEncontradoException |
                SoporteYaAlquiladoException |
                CupoSuperadoException $e) {
                echo "<br>Error: " . $e->getMessage();
            } 
            catch (VideoclubException $e) {
                // Captura genérica (por si creas más excepciones en el futuro)
                echo "<br>Error inesperado en el videoclub: " . $e->getMessage();
            }

            return $this; // permite encadenamiento
        }
        
        // Método para devolver un producto
        /**
         * DevolverSocioProducto.
         *
         * @param mixed $numeroCliente Parámetro.
         * @param mixed $numeroSoporte Parámetro.
         * @return mixed Resultado.
         */

        public function devolverSocioProducto($numeroCliente, $numeroSoporte): Videoclub
        {
            try {
                $cliente = $this->buscarCliente($numeroCliente);
                if (!$cliente) {
                    throw new ClienteNoEncontradoException("No existe el cliente con número {$numeroCliente}");
                }

                // Localizar el producto para ajustar contadores tras devolver
                $producto = $this->buscarProducto($numeroSoporte);                  
                if (!$producto) {                                                   
                    throw new SoporteNoEncontradoException("No existe el producto con número {$numeroSoporte}"); 
                }                                                                   

                $estabaAlquiladoAntes = $producto->alquilado ?? false;             

                // Puede lanzar SoporteNoEncontradoException
                $cliente->devolver($numeroSoporte);

                // Si estaba alquilado y tras devolver ha quedado libre, decrementamos
                if ($estabaAlquiladoAntes && ($producto->alquilado ?? true) === false) { 
                    if ($this->numProductosAlquilados > 0) {                              
                        $this->numProductosAlquilados--;                                  
                    }                                                                     
                }                                                                          

                echo "<br>El cliente {$cliente->nombre} ha devuelto el producto {$numeroSoporte} correctamente.";
            } catch (ClienteNoEncontradoException|SoporteNoEncontradoException $e) {
                echo "<br>Error: " . $e->getMessage();
            } catch (VideoclubException $e) {
                echo "<br>Error inesperado en el videoclub: " . $e->getMessage();
            }

            return $this; // encadenamiento
        }
        
        // Métodos auxiliares privados para buscar
        /**
         * BuscarCliente.
         *
         * @param mixed $numeroCliente Parámetro.
         * @return mixed Resultado.
         */

        private function buscarCliente($numeroCliente) {
            foreach ($this->socios as $cliente) {
                if ($cliente->getNumero() == $numeroCliente) {
                    return $cliente;
                }
            }
            return null;
        }
        
        /**
         * BuscarProducto.
         *
         * @param mixed $numeroSoporte Parámetro.
         * @return mixed Resultado.
         */

        private function buscarProducto($numeroSoporte) {

            foreach ($this->productos as $producto) {
                if ($producto->getNumero() == $numeroSoporte) {
                    return $producto;
                }
            }
            return null;
        }
        
        // Getters
        /**
         * GetNombre.
         * @return mixed Resultado.
         */

        public function getNombre() {
            return $this->nombre;
        }
        
        /**
         * GetNumProductos.
         * @return mixed Resultado.
         */

        public function getNumProductos() {
            return $this->numProductos;
        }
        
        /**
         * GetNumSocios.
         * @return mixed Resultado.
         */

        public function getNumSocios() {
            return $this->numSocios;
        }
        
        /**
         * GetProductos.
         * @return mixed Resultado.
         */

        public function getProductos() {
            return $this->productos;
        }
        
        /**
         * GetSocios.
         * @return mixed Resultado.
         */

        public function getSocios() {
            return $this->socios;
        }

        /**
         * getNumProductosAlquilados.
         * @return numProductosAlquilados.
         */
        public function getNumProductosAlquilados(): int {
            return $this->numProductosAlquilados;
        }

        /**
         * getNumTotalAlquileres.
         * @return numTotalAlquileres.
         */
        public function getNumTotalAlquileres(): int {
            return $this->numTotalAlquileres;
        }
    }
?>

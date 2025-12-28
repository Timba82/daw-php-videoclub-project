<?php
    // v0.331
    namespace Dwes\ProyectoVideoclub;


    use Dwes\ProyectoVideoclub\Util\{
        VideoclubException,
        ClienteNoEncontradoException,
        SoporteNoEncontradoException,
        SoporteYaAlquiladoException,
        CupoSuperadoException
    };

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    /**
     * Clase Videoclub.
     *
     * Representa la entidad videoclub del videoclub.
     */

    class Videoclub {
        private $nombre;
        private $productos;
        private $numProductos;
        private $socios;
        private $numSocios;
        private $numProductosAlquilados;
        private $numTotalAlquileres;
        private $log;

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

            $this->log = new Logger('VideoclubLogger');
            $this->log->pushHandler(new StreamHandler(__DIR__ . '/../logs/videoclub.log', Logger::DEBUG));
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
            $socio = new Cliente($nombre, $numero, null, null, $maxAlquileresConcurrentes);
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
                    $this->log->warning("No existe el cliente con número {$numeroCliente}", [
                    'nombre_videoclub' => $this->nombre,
                    'numero_cliente' => $numeroCliente,
                    'numero_soporte' => $numeroSoporte,
                    'numero_producto' => $this->numProductos,
                    'numero_socio' => $this->numSocios,
                    'total_alquileres' => $this->numTotalAlquileres,
                    'productos_alquilados' => $this->numProductosAlquilados,
                    'cliente_nombre' => $cliente->nombre,
                ]);
                    throw new ClienteNoEncontradoException("No existe el cliente con número {$numeroCliente}");
                }

                // Buscar producto
                $producto = $this->buscarProducto($numeroSoporte);
                if (!$producto) {
                    $this->log->warning("No existe el producto con número {$numeroSoporte}", [
                        'nombre_videoclub' => $this->nombre,
                        'numero_cliente' => $numeroCliente,
                        'numero_soporte' => $numeroSoporte,
                        'numero_producto' => $this->numProductos,
                        'numero_socio' => $this->numSocios,
                        'total_alquileres' => $this->numTotalAlquileres,
                        'productos_alquilados' => $this->numProductosAlquilados,
                        'cliente_nombre' => $cliente->nombre,
                ]);
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
                    $this->log->warning("No existe el cliente con número {$numeroCliente}", [
                        'nombre_videoclub' => $this->nombre,
                        'numero_cliente' => $numeroCliente,
                        'numero_soporte' => $numeroSoporte,
                        'numero_producto' => $this->numProductos,
                        'numero_socio' => $this->numSocios,
                        'total_alquileres' => $this->numTotalAlquileres,
                        'productos_alquilados' => $this->numProductosAlquilados,
                        'cliente_nombre' => $cliente->nombre,
                ]);
                    throw new ClienteNoEncontradoException("No existe el cliente con número {$numeroCliente}");
                }

                // Localizar el producto para ajustar contadores tras devolver
                $producto = $this->buscarProducto($numeroSoporte);                  
                if (!$producto) {                   
                    $this->log->warning("No existe el producto con número {$numeroSoporte}", [
                        'nombre_videoclub' => $this->nombre,
                        'numero_cliente' => $numeroCliente,
                        'numero_soporte' => $numeroSoporte,
                        'numero_producto' => $this->numProductos,
                        'numero_socio' => $this->numSocios,
                        'total_alquileres' => $this->numTotalAlquileres,
                        'productos_alquilados' => $this->numProductosAlquilados,
                        'cliente_nombre' => $cliente->nombre,
                ]);                                
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


        /**
         * DevolverSocioProductos.
         *
         * Devuelve varios productos de un socio. Soporta encadenamiento.
         * Actualiza "alquilado" de cada soporte y el contador de productos alquilados.
         * Si algún producto da error (no existe/no estaba alquilado por el socio), continúa con los demás.
         *
         * @param int   $numSocio          Número de socio.
         * @param array $numerosProductos  Array de números de producto a devolver.
         * @return Videoclub
         */
        public function devolverSocioProductos(int $numSocio, array $numerosProductos): Videoclub
        {
            try {
                if (empty($numerosProductos)) {
                    echo "<br>Error: no se han indicado productos a devolver.";
                    return $this;
                }

                // Buscar cliente
                $cliente = $this->buscarCliente($numSocio);
                if (!$cliente) {
                    $this->log->warning("No existe el cliente con número {$numSocio}", [
                        'nombre_videoclub' => $this->nombre,
                        'numero_producto' => $this->numProductos,
                        'numero_socio' => $this->numSocios,
                        'total_alquileres' => $this->numTotalAlquileres,
                        'productos_alquilados' => $this->numProductosAlquilados,
                        'cliente_nombre' => $cliente->nombre,
                ]);
                    throw new ClienteNoEncontradoException("No existe el cliente con número {$numSocio}");
                }

                // Normalizar (quitar duplicados)
                $numerosSolicitados = array_values(array_unique($numerosProductos));

                $devueltos = [];
                $errores  = [];

                foreach ($numerosSolicitados as $numSoporte) {
                    // Localizamos producto para ajustar contadores y validar existencia
                    $producto = $this->buscarProducto($numSoporte);
                    if (!$producto) {
                        $errores[] = "No existe el producto con número {$numSoporte}";
                        continue;
                    }

                    $estabaAlquiladoAntes = $producto->alquilado ?? false;

                    try {
                        // Puede lanzar SoporteNoEncontradoException si ese cliente no lo tenía
                        $cliente->devolver($numSoporte);

                        // Si estaba alquilado y ahora queda libre, decrementamos contador
                        if ($estabaAlquiladoAntes && ($producto->alquilado ?? true) === false) {
                            if ($this->numProductosAlquilados > 0) {
                                $this->numProductosAlquilados--;
                            }
                        }

                        $devueltos[] = $numSoporte;
                    } catch (SoporteNoEncontradoException $e) {
                        $errores[] = $e->getMessage();
                    }
                }

                // Mensajes
                if (!empty($devueltos)) {
                    $listaOk = implode(', ', $devueltos);
                    echo "<br>El cliente {$cliente->nombre} ha devuelto los productos: {$listaOk} correctamente.";
                }
                if (!empty($errores)) {
                    foreach ($errores as $msg) {
                        echo "<br>Error: {$msg}";
                    }
                }
            } catch (ClienteNoEncontradoException $e) {
                echo "<br>Error: " . $e->getMessage();
            } catch (VideoclubException $e) {
                echo "<br>Error inesperado en el videoclub: " . $e->getMessage();
            }

            return $this;
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

        
        /**
         * AlquilarSocioProductos.
         *
         * Antes de alquilarlos, comprueba que TODOS los soportes existen y están disponibles.
         * Si alguno no lo está, NO se alquila ninguno.
         *
         * @param int   $numSocio          Número de socio.
         * @param array $numerosProductos  Array de números de producto (soportes) a alquilar.
         * @return Videoclub
         */
        public function alquilarSocioProductos(int $numSocio, array $numerosProductos): Videoclub
        {
            try {
                // Validaciones básicas
                if (empty($numerosProductos)) {
                    echo "<br>Error: no se han indicado productos a alquilar.";
                    return $this;
                }

                // Buscar cliente
                $cliente = $this->buscarCliente($numSocio);
                if (!$cliente) {
                    $this->log->warning("No existe el cliente con número {$numSocio}", [
                        'nombre_videoclub' => $this->nombre,
                        'numero_producto' => $this->numProductos,
                        'numero_socio' => $this->numSocios,
                        'total_alquileres' => $this->numTotalAlquileres,
                        'productos_alquilados' => $this->numProductosAlquilados,
                        'cliente_nombre' => $cliente->nombre,
                    ]);
                    throw new ClienteNoEncontradoException("No existe el cliente con número {$numSocio}");
                }

                // Normalizamos entradas (evitar duplicados simples)
                $numerosSolicitados = array_values(array_unique($numerosProductos));

                // Comprobacikón que todos existan y estén disponibles
                $productosAAlquilar = [];
                foreach ($numerosSolicitados as $numSoporte) {
                    $producto = $this->buscarProducto($numSoporte);
                    if (!$producto) {
                        $this->log->warning("No existe el producto con número {$numSoporte}", [
                            'nombre_videoclub' => $this->nombre,
                            'numero_producto' => $this->numProductos,
                            'numero_socio' => $this->numSocios,
                            'total_alquileres' => $this->numTotalAlquileres,
                            'productos_alquilados' => $this->numProductosAlquilados,
                            'cliente_nombre' => $cliente->nombre,
                            ]
                        );
                        throw new SoporteNoEncontradoException("No existe el producto con número {$numSoporte}");
                    }
                    if (($producto->alquilado ?? false) === true) {
                        $this->log->warning("El producto {$numSoporte} ya está alquilado", [
                            'nombre_videoclub' => $this->nombre,
                            'numero_producto' => $this->numProductos,
                            'numero_socio' => $this->numSocios,
                            'total_alquileres' => $this->numTotalAlquileres,
                            'productos_alquilados' => $this->numProductosAlquilados,
                            'cliente_nombre' => $cliente->nombre,
                        ]);
                        throw new SoporteYaAlquiladoException("El producto {$numSoporte} ya está alquilado");
                    }
                    $productosAAlquilar[] = $producto;
                }

                // Alquilar todos (si algo falla se revierte todo)
                $alquiladosTemporalmente = [];
                try {
                    foreach ($productosAAlquilar as $producto) {
                        // Puede lanzar CupoSuperadoException (límite del cliente)
                        $cliente->alquilar($producto);
                        $alquiladosTemporalmente[] = $producto;
                    }
                } catch (CupoSuperadoException | SoporteYaAlquiladoException $e) {
                    // Devolver los ya alquilados en esta operación
                    foreach ($alquiladosTemporalmente as $p) {
                        try {
                            $cliente->devolver($p->getNumero());
                        } catch (\Throwable $ignore) {
                            
                        }
                    }
                    // Re-lanzamos para informar al usuario en el catch exterior
                    throw $e;
                }

                // Contadores solo si todo fue bien
                $numNuevos = count($alquiladosTemporalmente);
                if ($numNuevos > 0) {
                    $this->numProductosAlquilados += $numNuevos;
                    $this->numTotalAlquileres   += $numNuevos;
                }

                // Mensaje de éxito
                $nums = [];
                foreach ($alquiladosTemporalmente as $p) {
                    $nums[] = $p->getNumero();
                }
                $lista = implode(', ', $nums);
                echo "<br>El cliente {$cliente->nombre} ha alquilado los productos: {$lista} correctamente.";
            }
            catch (ClienteNoEncontradoException|
                   SoporteNoEncontradoException|
                   SoporteYaAlquiladoException|
                   CupoSuperadoException $e) {
                echo "<br>Error: " . $e->getMessage();
            }
            catch (VideoclubException $e) {
                echo "<br>Error inesperado en el videoclub: " . $e->getMessage();
            }

            return $this;
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

<?php
// v0.331
namespace Dwes\ProyectoVideoclub;

require_once __DIR__ . '/Resumible.php';
/**
 * Clase Soporte.
 *
 * Representa la entidad soporte del videoclub.
 *
 * Implementa la interfaz Resumible.
 */

abstract class Soporte implements Resumible
{
    public $titulo;
    protected $numero;
    private $precio;
    const IVA = 0.21;
    public bool $alquilado = false;

    /**
     * __construct.
     *
     * @param mixed $titulo Parámetro.
     * @param mixed $numero Parámetro.
     * @param mixed $precio Parámetro.
     */

    public function __construct($titulo, $numero, $precio)
    {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    /**
     * GetPrecio.
     * @return mixed Resultado.
     */

    public function getPrecio()
    {
        return $this->precio;
    }
    /**
     * GetPrecioConIva.
     * @return mixed Resultado.
     */

    public function getPrecioConIva()
    {
        return $this->precio * (1 + self::IVA);
    }
    /**
     * GetNumero.
     * @return mixed Resultado.
     */

    public function getNumero()
    {
        return $this->numero;
    }
    /**
     * MuestraResumen.
     * Esta clase está obligada a implementar este método porque implementa la interfaz Resumible
     * Nota: Si quisieramos que todas las subclases implementaran obligatoriamente este método, y cada una a su manera deberíamos 
     * tener el método así: abstract public function muestraResumen(): void;
     * Pero tal y como lo tenemos, las clases no tienen obligación a implementarlo, y heredan esto, y además pueden sobreescribirlo
     * @return mixed Resultado.
     */

    public function muestraResumen(): string
    {
        $msg = "<br>Número: " . $this->numero .
            ",<br>Título: " . $this->titulo .
            ",<br> Precio: " . $this->precio .
            ",<br> Precio con IVA " . $this->getPrecioConIva();

        echo $msg;
        return $msg;
    }
}

<?php

declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;

final class CoberturaEmpujonFinalTest extends TestCase
{
    public function testListarConVideoclubVacio(): void
    {
        $vc = new Videoclub("Vacío");

        $this->expectOutputRegex('/No hay productos/');
        $vc->listarProductos();

        $this->expectOutputRegex('/No hay socios/');
        $vc->listarSocios();
    }

    public function testConstructorYComportamientoCliente(): void
    {
        $c = new Cliente("Selina", 10, null, null, 2);

        // Validamos número (este getter sí lo tienes)
        $this->assertSame(10, $c->getNumero());

        // Validamos nombre vía salida (porque no hay getNombre)
        $this->expectOutputRegex('/Selina/');
        $c->muestraResumen();
    }

    public function testMuestraResumenDvdYJuegoExtra(): void
    {
        $dvd = new Dvd("Blade Runner", 5, 12, "es,en", "16:9");
        $juego = new Juego("Mario Kart", 6, 45, "Switch", 1, 4);

        $this->expectOutputRegex('/Blade Runner/');
        $dvd->muestraResumen();

        $this->expectOutputRegex('/Mario Kart/');
        $juego->muestraResumen();
    }
}

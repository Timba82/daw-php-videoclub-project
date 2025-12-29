<?php

declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;

final class CoberturaFinalTest extends TestCase
{
    public function testCoberturaClienteCompleta(): void
    {
        $c = new Cliente("Alfred", 99, null, null, 1);
        $dvd = new Dvd("Origen", 1, 10, "es", "16:9");

        $c->alquilar($dvd);
        $this->assertTrue($c->tieneAlquilado($dvd));

        $c->devolver(1);
        $this->assertFalse($c->tieneAlquilado($dvd));

        $this->expectOutputRegex('/Cliente:/');
        $c->muestraResumen();
    }

    public function testCoberturaDvdYJuego(): void
    {
        $dvd = new Dvd("Matrix", 1, 10, "es,en", "16:9");
        $juego = new Juego("FIFA", 2, 50, "PS5", 1, 4);

        $this->expectOutputRegex('/DVD:/');
        $dvd->muestraResumen();

        $this->expectOutputRegex('/Consola:/');
        $juego->muestraResumen();
    }

    public function testCoberturaExtraVideoclub(): void
    {
        $vc = new Videoclub("Final");

        $vc->incluirSocio("Diana", 1);
        $vc->incluirJuego("Zelda", 60, "Switch", 1, 1);

        $this->expectOutputRegex('/Productos del videoclub/');
        $vc->listarProductos();

        $this->expectOutputRegex('/Socios del videoclub/');
        $vc->listarSocios();
    }
}

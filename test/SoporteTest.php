<?php
declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Soporte;

final class SoporteTest extends TestCase
{
    public function testGettersYPrecioConIva(): void
    {
        // Soporte es abstracta, creamos una clase anónima mínima
        $s = new class("Soporte Test", 1, 10) extends Soporte {};

        // Getters básicos
        $this->assertSame(1, $s->getNumero());
        $this->assertSame(10, $s->getPrecio());

        // IVA 21%: 10 * 1.21 = 12.1
        $this->assertEquals(12.1, $s->getPrecioConIva(), '', 0.0001);
    }

    public function testMuestraResumenHaceEchoYDevuelveString(): void
    {
        $s = new class("Soporte Test", 1, 10) extends Soporte {};

        // El resumen debe coincidir con el texto que imprime y además retornarlo
        $esperado = "<br>Número: 1" .
            ",<br>Título: Soporte Test" .
            ",<br> Precio: 10" .
            ",<br> Precio con IVA " . $s->getPrecioConIva();

        // Comprueba el echo
        $this->expectOutputString($esperado);

        // Comprueba el return
        $ret = $s->muestraResumen();
        $this->assertSame($esperado, $ret);
    }
}

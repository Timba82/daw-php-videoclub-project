<?php
declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\CintaVideo;

final class CintaVideoTest extends TestCase
{
    public function testMuestraResumenHaceEchoYDevuelveString(): void
    {
        $c = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);

        // Parent (Soporte) + extra de duración
        $esperado = "<br>Número: 23" .
            ",<br>Título: Los cazafantasmas" .
            ",<br> Precio: 3.5" .
            ",<br> Precio con IVA " . $c->getPrecioConIva() .
            ",<br> Duración: 107 minutos";

        $this->expectOutputString($esperado);
        $ret = $c->muestraResumen();

        $this->assertSame($esperado, $ret);
    }
}

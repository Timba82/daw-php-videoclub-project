<?php

declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Dvd;

final class DvdTest extends TestCase
{
    public function testMuestraResumenHaceEchoYDevuelveString(): void
    {
        $d = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");

        $esperado = "<br>Número: 24" .
            ",<br>Título: Origen" .
            ",<br> Precio: 15" .
            ",<br> Precio con IVA " . $d->getPrecioConIva() .
            ",<br> Idiomas: es,en,fr" .
            ",<br> Formato Pantalla: 16:9";

        $this->expectOutputString($esperado);
        $ret = $d->muestraResumen();

        $this->assertSame($esperado, $ret);
    }
    public function testDvdResumenConMultiplesIdiomas()
    {
        $d = new Dvd("Blade Runner", 77, 20, "es,en,fr,de", "4K");

        $this->expectOutputRegex('/Blade Runner/');
        $this->expectOutputRegex('/es,en,fr,de/');
        $this->expectOutputRegex('/4K/');

        $d->muestraResumen();
    }
}

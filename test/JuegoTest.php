<?php

declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Juego;

final class JuegoTest extends TestCase
{
    public function testMuestraResumenHaceEchoYDevuelveString_unJugador(): void
    {
        $j = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);

        $esperado = "<br>Número: 26" .
            ",<br>Título: The Last of Us Part II" .
            ",<br> Precio: 49.99" .
            ",<br> Precio con IVA " . $j->getPrecioConIva() .
            ",<br> Consola: PS4, <br>" .
            "Para un jugador";

        $this->expectOutputString($esperado);
        $ret = $j->muestraResumen();

        $this->assertSame($esperado, $ret);
    }

    public function testMuestraJugadoresPosibles_rango(): void
    {
        $j = new Juego("Mario Kart", 50, 30, "Switch", 2, 4);

        $esperado = "De 2 a 4 jugadores";

        $this->expectOutputString($esperado);
        $ret = $j->muestraJugadoresPosibles();

        $this->assertSame($esperado, $ret);
    }
    public function testJuegoResumenConDatosExtremos()
    {
        $j = new Juego("Mario Kart", 99, 0.01, "Switch", 1, 8);

        $this->expectOutputRegex('/Mario Kart/');
        $this->expectOutputRegex('/Switch/');
        $this->expectOutputRegex('/1 a 8 jugadores/');

        $j->muestraResumen();
    }
}

<?php
declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;

use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;

use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;

final class ClienteTest extends TestCase
{
    /**
     * Proveedor de datos: cupos distintos
     */
    public function cuposProvider(): array
    {
        return [
            "cupo 1" => [1],
            "cupo 2" => [2],
            "cupo 3" => [3],
        ];
    }

    /**
     * @dataProvider cuposProvider
     */
    public function testConstructorGuardaDatos(int $cupo): void
    {
        $c = new Cliente("Bruce Wayne", 23, "bruce", "1234", $cupo);

        // nombre es public en tu clase
        $this->assertSame("Bruce Wayne", $c->nombre);
        $this->assertSame(23, $c->getNumero());
    }

    public function testAlquilarYTieneAlquilado(): void
    {
        $c = new Cliente("Bruce Wayne", 23, "bruce", "1234", 3);
        $s1 = new CintaVideo("Los cazafantasmas", 1, 3.5, 107);

        $this->assertFalse($c->tieneAlquilado($s1));

        $c->alquilar($s1);

        $this->assertTrue($c->tieneAlquilado($s1));
        $this->assertSame(1, $c->getNumSoportesAlquilados());
    }

    public function testAlquilarMismoSoporteDosVecesLanzaExcepcion(): void
    {
        $c = new Cliente("Bruce Wayne", 23, "bruce", "1234", 3);
        $s1 = new Dvd("Origen", 2, 15, "es,en,fr", "16:9");

        $c->alquilar($s1);

        $this->expectException(SoporteYaAlquiladoException::class);
        $c->alquilar($s1);
    }

    public function testSuperarCupoLanzaExcepcion(): void
    {
        $c = new Cliente("Bruce Wayne", 23, "bruce", "1234", 1);

        $s1 = new Juego("TLOU2", 10, 49.99, "PS4", 1, 1);
        $s2 = new CintaVideo("CV2", 11, 3.5, 100);

        $c->alquilar($s1);

        $this->expectException(CupoSuperadoException::class);
        $c->alquilar($s2);
    }

    public function testDevolverSoporteLoElimina(): void
    {
        $c = new Cliente("Bruce Wayne", 23, "bruce", "1234", 3);
        $s1 = new Dvd("Origen", 2, 15, "es", "16:9");

        $c->alquilar($s1);
        $this->assertSame(1, $c->getNumSoportesAlquilados());

        $c->devolver(2);

        $this->assertSame(0, $c->getNumSoportesAlquilados());
        $this->assertFalse($c->tieneAlquilado($s1));
    }

    public function testDevolverInexistenteLanzaExcepcion(): void
    {
        $c = new Cliente("Bruce Wayne", 23, "bruce", "1234", 3);

        $this->expectException(SoporteNoEncontradoException::class);
        $c->devolver(999);
    }

    /**
     * Proveedor de datos "más grande" para cumplir el enunciado
     */
    public function alquilerMasivoProvider(): array
    {
        return [
            "cupo 2 mete 2 OK" => [2, 2, false],
            "cupo 2 mete 3 FAIL" => [2, 3, true],
            "cupo 3 mete 3 OK" => [3, 3, false],
            "cupo 3 mete 4 FAIL" => [3, 4, true],
        ];
    }

    /**
     * @dataProvider alquilerMasivoProvider
     */
    public function testAlquilerMasivoConCupos(int $cupo, int $n, bool $debeFallar): void
    {
        $c = new Cliente("Bruce Wayne", 23, "bruce", "1234", $cupo);

        $soportes = [
            new CintaVideo("CV1", 1, 3.5, 100),
            new Dvd("DVD1", 2, 10, "es", "16:9"),
            new Juego("J1", 3, 20, "PC", 1, 2),
            new CintaVideo("CV2", 4, 4.0, 90),
        ];

        if ($debeFallar) {
            $this->expectException(CupoSuperadoException::class);
        }

        for ($i = 0; $i < $n; $i++) {
            $c->alquilar($soportes[$i]);
        }

        if (!$debeFallar) {
            $this->assertSame($n, $c->getNumSoportesAlquilados());
        }
    }
}

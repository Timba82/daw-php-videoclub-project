<?php
declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;

final class VideoClubTest extends TestCase
{
    private function crearVideoclubBasico(int $cupoSocio = 3): Videoclub
    {
        $vc = new Videoclub("Mi VC");
        $vc->incluirSocio("Bruce Wayne", $cupoSocio);

        // ids 1..3
        $vc->incluirCintaVideo("CV1", 3.5, 100);                 // 1
        $vc->incluirDvd("DVD1", 10, "es,en", "16:9");            // 2
        $vc->incluirJuego("J1", 20, "PS4", 1, 1);                // 3

        return $vc;
    }

    public function testIncluirSocioYProductosIncrementaContadores(): void
    {
        $vc = $this->crearVideoclubBasico();

        $this->assertSame(1, $vc->getNumSocios());
        $this->assertSame(3, $vc->getNumProductos());
        $this->assertSame(0, $vc->getNumProductosAlquilados());
        $this->assertSame(0, $vc->getNumTotalAlquileres());
    }

    public function testAlquilaSocioProductoActualizaContadores(): void
    {
        $vc = $this->crearVideoclubBasico();

        $this->expectOutputString("<br>El cliente Bruce Wayne ha alquilado el producto 1 correctamente.");
        $vc->alquilaSocioProducto(1, 1);

        $this->assertSame(1, $vc->getNumProductosAlquilados());
        $this->assertSame(1, $vc->getNumTotalAlquileres());
    }

    public function testDevolverSocioProductoActualizaContadores(): void
    {
        $vc = $this->crearVideoclubBasico();

        // Como primero alquilamos, ese mensaje también forma parte del output total
        $this->expectOutputString(
            "<br>El cliente Bruce Wayne ha alquilado el producto 1 correctamente." .
            "<br>El cliente Bruce Wayne ha devuelto el producto 1 correctamente."
        );

        $vc->alquilaSocioProducto(1, 1);
        $vc->devolverSocioProducto(1, 1);

        $this->assertSame(0, $vc->getNumProductosAlquilados());
        $this->assertSame(1, $vc->getNumTotalAlquileres());
    }

    public function testAlquilaSocioProductoClienteInexistenteMuestraError(): void
    {
        $vc = $this->crearVideoclubBasico();

        $this->expectOutputString("<br>Error: No existe el cliente con número 99");
        $vc->alquilaSocioProducto(99, 1);

        $this->assertSame(0, $vc->getNumProductosAlquilados());
        $this->assertSame(0, $vc->getNumTotalAlquileres());
    }

    public function testAlquilaSocioProductoSoporteInexistenteMuestraError(): void
    {
        $vc = $this->crearVideoclubBasico();

        $this->expectOutputString("<br>Error: No existe el producto con número 999");
        $vc->alquilaSocioProducto(1, 999);

        $this->assertSame(0, $vc->getNumProductosAlquilados());
        $this->assertSame(0, $vc->getNumTotalAlquileres());
    }

    public function testAlquilarMismoProductoDosVecesMuestraError(): void
    {
        $vc = $this->crearVideoclubBasico();

        $this->expectOutputString(
            "<br>El cliente Bruce Wayne ha alquilado el producto 1 correctamente." .
            "<br>Error: El soporte 1 ya está alquilado por Bruce Wayne"
        );

        $vc->alquilaSocioProducto(1, 1);
        $vc->alquilaSocioProducto(1, 1);

        $this->assertSame(1, $vc->getNumProductosAlquilados());
        $this->assertSame(1, $vc->getNumTotalAlquileres());
    }

    public function testAlquilarPorArrayAlquilaTodosYActualizaContadores(): void
    {
        $vc = $this->crearVideoclubBasico(3);

        $this->expectOutputString("<br>El cliente Bruce Wayne ha alquilado los productos: 1, 2, 3 correctamente.");
        $vc->alquilarSocioProductos(1, [1, 2, 3]);

        $this->assertSame(3, $vc->getNumProductosAlquilados());
        $this->assertSame(3, $vc->getNumTotalAlquileres());
    }

    public function testAlquilarPorArraySiUnoNoExisteNoAlquilaNinguno(): void
    {
        $vc = $this->crearVideoclubBasico(3);

        $this->expectOutputString("<br>Error: No existe el producto con número 999");
        $vc->alquilarSocioProductos(1, [1, 999]);

        $this->assertSame(0, $vc->getNumProductosAlquilados());
        $this->assertSame(0, $vc->getNumTotalAlquileres());
    }

    public function testAlquilarPorArraySiUnoYaEstaAlquiladoNoAlquilaNingunoNuevo(): void
    {
        $vc = $this->crearVideoclubBasico(3);

        $this->expectOutputString(
            "<br>El cliente Bruce Wayne ha alquilado el producto 1 correctamente." .
            "<br>Error: El producto 1 ya está alquilado"
        );

        $vc->alquilaSocioProducto(1, 1);
        $vc->alquilarSocioProductos(1, [1, 2]);

        $this->assertSame(1, $vc->getNumProductosAlquilados());
        $this->assertSame(1, $vc->getNumTotalAlquileres());
    }

    public function testAlquilarPorArraySiSuperaCupoRevierteTodo(): void
    {
        $vc = $this->crearVideoclubBasico(1);

        $this->expectOutputString("<br>Error: Bruce Wayne ha superado el cupo máximo de 1 alquileres");
        $vc->alquilarSocioProductos(1, [1, 2]);

        $this->assertSame(0, $vc->getNumProductosAlquilados());
        $this->assertSame(0, $vc->getNumTotalAlquileres());
    }

    public function testDevolverPorArrayDevuelveYActualizaContadores(): void
    {
        $vc = $this->crearVideoclubBasico(3);

        $this->expectOutputString(
            "<br>El cliente Bruce Wayne ha alquilado los productos: 1, 2, 3 correctamente." .
            "<br>El cliente Bruce Wayne ha devuelto los productos: 1, 3 correctamente."
        );

        $vc->alquilarSocioProductos(1, [1, 2, 3]);
        $vc->devolverSocioProductos(1, [1, 3]);

        $this->assertSame(1, $vc->getNumProductosAlquilados());
        $this->assertSame(3, $vc->getNumTotalAlquileres());
    }

    public function testDevolverPorArrayConErroresContinua(): void
    {
        $vc = $this->crearVideoclubBasico(3);

        $this->expectOutputString(
            "<br>El cliente Bruce Wayne ha alquilado el producto 1 correctamente." .
            "<br>El cliente Bruce Wayne ha devuelto los productos: 1 correctamente." .
            "<br>Error: No existe el producto con número 999"
        );

        $vc->alquilaSocioProducto(1, 1);
        $vc->devolverSocioProductos(1, [1, 999]);

        $this->assertSame(0, $vc->getNumProductosAlquilados());
    }
}

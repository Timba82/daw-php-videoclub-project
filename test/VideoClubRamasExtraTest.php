<?php

declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;

final class VideoClubRamasExtraTest extends TestCase
{
    private function vcCon1SocioY2Productos(int $cupo = 3): Videoclub
    {
        $vc = new Videoclub("VC");
        $vc->incluirSocio("Bruce Wayne", $cupo);

        // productos 1 y 2
        $vc->incluirCintaVideo("CV1", 3.5, 100);        // 1
        $vc->incluirDvd("DVD1", 10, "es", "16:9");      // 2

        return $vc;
    }

    public function testDevolverSocioProductoClienteNoExiste(): void
    {
        $vc = $this->vcCon1SocioY2Productos();

        $this->expectOutputString("<br>Error: No existe el cliente con número 99");
        $vc->devolverSocioProducto(99, 1);
    }

    public function testDevolverSocioProductoProductoNoExiste(): void
    {
        $vc = $this->vcCon1SocioY2Productos();

        $this->expectOutputString("<br>Error: No existe el producto con número 999");
        $vc->devolverSocioProducto(1, 999);
    }

    public function testDevolverSocioProductoClienteNoTeniaEseProducto(): void
    {
        $vc = $this->vcCon1SocioY2Productos();

        // Producto existe (1) pero el cliente no lo ha alquilado -> Cliente->devolver lanza
        $this->expectOutputString("<br>Error: El soporte 1 no estaba alquilado por Bruce Wayne");
        $vc->devolverSocioProducto(1, 1);
    }

    public function testDevolverSocioProductosMezclaOkYErrores(): void
    {
        $vc = $this->vcCon1SocioY2Productos();

        // alquilamos solo el 1
        $vc->alquilaSocioProducto(1, 1);

        // devolvemos: 1 (ok), 2 (existe pero no alquilado), 999 (no existe)
        $this->expectOutputString(
            "<br>El cliente Bruce Wayne ha alquilado el producto 1 correctamente." .
                "<br>El cliente Bruce Wayne ha devuelto los productos: 1 correctamente." .
                "<br>Error: El soporte 2 no estaba alquilado por Bruce Wayne" .
                "<br>Error: No existe el producto con número 999"
        );

        $vc->devolverSocioProductos(1, [1, 2, 999]);
    }

    public function testDevolverSocioProductosConDuplicados(): void
    {
        $vc = $this->vcCon1SocioY2Productos();

        // alquilamos 1 y 2
        $vc->alquilarSocioProductos(1, [1, 2]);

        // devolvemos con duplicados para cubrir array_unique
        $this->expectOutputString(
            "<br>El cliente Bruce Wayne ha alquilado los productos: 1, 2 correctamente." .
                "<br>El cliente Bruce Wayne ha devuelto los productos: 1, 2 correctamente."
        );

        $vc->devolverSocioProductos(1, [1, 1, 2, 2]);
    }

    public function testAlquilarSocioProductosConDuplicadosSoloAlquilaUnaVez(): void
    {
        $vc = $this->vcCon1SocioY2Productos();

        // duplicados [1,1,2] => debe normalizar y alquilar 1 y 2
        $this->expectOutputString("<br>El cliente Bruce Wayne ha alquilado los productos: 1, 2 correctamente.");
        $vc->alquilarSocioProductos(1, [1, 1, 2]);

        $this->assertSame(2, $vc->getNumProductosAlquilados());
        $this->assertSame(2, $vc->getNumTotalAlquileres());
    }
    public function testListarProductosVacio()
    {
        $v = new Videoclub("Vacío");
        $this->expectOutputRegex('/No hay productos/');
        $v->listarProductos();
    }

    public function testListarSociosVacio()
    {
        $v = new Videoclub("Vacío");
        $this->expectOutputRegex('/No hay socios/');
        $v->listarSocios();
    }
    public function testAlquilarSocioProductosClienteNoExisteMuestraError(): void
    {
        $vc = new Videoclub("VC");
        // no metemos socios a propósito
        $vc->incluirCintaVideo("CV1", 3.5, 100);

        $this->expectOutputString("<br>Error: No existe el cliente con número 99");
        $vc->alquilarSocioProductos(99, [1]);
    }

    public function testDevolverSocioProductosClienteNoExisteMuestraError(): void
    {
        $vc = new Videoclub("VC");
        // no metemos socios a propósito
        $vc->incluirCintaVideo("CV1", 3.5, 100);

        $this->expectOutputString("<br>Error: No existe el cliente con número 99");
        $vc->devolverSocioProductos(99, [1]);
    }
}

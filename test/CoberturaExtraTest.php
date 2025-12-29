<?php
declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;

final class CoberturaExtraTest extends TestCase
{
    public function testListarProductosYListarSocios(): void
    {
        $vc = new Videoclub("Extra");

        $vc->incluirSocio("Clark Kent", 2);
        $vc->incluirCintaVideo("Matrix", 5, 120);
        $vc->incluirDvd("Interstellar", 10, "en", "16:9");

        $this->expectOutputRegex('/Productos del videoclub/');
        $vc->listarProductos();

        $this->expectOutputRegex('/Socios del videoclub/');
        $vc->listarSocios();
    }

    public function testGettersVideoClub(): void
    {
        $vc = new Videoclub("Extra");

        $vc->incluirSocio("Clark Kent", 2);
        $vc->incluirCintaVideo("Matrix", 5, 120);

        $this->assertSame("Extra", $vc->getNombre());
        $this->assertCount(1, $vc->getSocios());
        $this->assertCount(1, $vc->getProductos());
        $this->assertSame(1, $vc->getNumSocios());
        $this->assertSame(1, $vc->getNumProductos());
    }
}

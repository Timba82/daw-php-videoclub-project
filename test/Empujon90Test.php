<?php
declare(strict_types=1);

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;

final class Empujon90Test extends TestCase
{
    public function testListarVacioCubreRamas(): void
    {
        $v = new Videoclub("Vacío");

        $this->expectOutputRegex('/No hay productos/');
        $v->listarProductos();

        $this->expectOutputRegex('/No hay socios/');
        $v->listarSocios();
    }
}

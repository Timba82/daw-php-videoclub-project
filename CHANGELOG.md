# Changelog

## [v0.0.0.1] Videoclub 1.0 20/10/2025
### Features Added
- **Clase `Soporte.php`**:
  - Clase base para todos los soportes (cintas de vídeo, DVDs, videojuegos, etc.).
  - Constructor que inicializa las propiedades.
  - Constante privada y estática `IVA` con valor 21%.
  - Implementa la interfaz `Resumible` con método `muestraResumen()`.
- **Clase `CintaVideo`**:
  - Hereda de `Soporte`.
  - Añadido atributo `duracion`.
  - Sobrescrito constructor y método `muestraResumen()`.
- **Clase `Dvd`**:
  - Hereda de `Soporte`.
  - Añadidos atributos `idiomas` y `formatoPantalla`.
  - Sobrescrito constructor y método `muestraResumen()`.
- **Clase `Juego`**:
  - Hereda de `Soporte`.
  - Atributos: `consola`, `minNumJugadores`, `maxNumJugadores`.
  - Método `muestraJugadoresPosibles()`.
  - Sobrescrito constructor y método `muestraResumen()`.
- **Clase `Cliente`**:
  - Constructor: `nombre`, `numero`, `maxAlquilerConcurrente` (por defecto 3).
  - Getter/setter para `numero` y getter para `numSoportesAlquilados`.
  - Array `soportesAlquilados` para almacenar soportes alquilados.
  - Métodos: `muestraResumen()`, `tieneAlquilado(Soporte $s): bool`, `alquilar(Soporte $s): bool`, `devolver(int $numSoporte): bool`, `listarAlquileres(): void`.
- **Archivos de prueba**:
  - `inicio.php`, `inicio2.php`, `inicio3.php` con pruebas de:
    - Creación y visualización de soportes.
    - Alquiler y devolución de soportes por clientes.
    - Listado de productos y socios.

## [v0.0.0.2] Videoclub 2.0 22/10/2025
### Features Added
- **Clase `Videoclub`**:
  - Arrays `productos` y `socios`.
  - Métodos para incluir soportes y clientes, creando el objeto internamente.
  - Métodos de alquiler y devolución de productos:
    - `alquilarSocioProductos(int numSocio, array numerosProductos)`
    - `devolverSocioProducto(int numSocio, int numeroProducto)`
    - `devolverSocioProductos(int numSocio, array numerosProductos)`
  - Propiedades `numProductosAlquilados` y `numTotalAlquileres` con getters.
  - Operaciones soportan encadenamiento de métodos.
- **Excepciones de aplicación** (`Dwes\ProyectoVideoclub\Util`):
  - `VideoclubException` (base)
  - Hijos: `SoporteYaAlquiladoException`, `CupoSuperadoException`, `SoporteNoEncontradoException`, `ClienteNoEncontradoException`.
- **Mejoras de diseño**:
  - `Soporte` convertido en clase abstracta.
  - Propiedad pública `alquilado` para controlar disponibilidad.
  - Implementación de interfaz `Resumible`.
  - Código preparado para extensión y mantenimiento.
- **Namespaces y estructura de proyecto**:
  - Todas las clases e interfaces en `Dwes\ProyectoVideoclub`.
  - Reorganización de carpetas: `app`, `test`, `vendor`.
  - Archivo `autoload.php` para carga automática de clases.
  - Eliminación de includes previos, uso de `use` en archivos de prueba.
- **Archivos de prueba**:
  - Actualización de `inicio.php`, `inicio2.php` y `inicio3.php` para pruebas de:
    - Inclusión de soportes y socios en Videoclub.
    - Alquiler y devolución de soportes con control de excepciones.
    - Comprobación de límites de alquiler y mensajes informativos.
- Proyecto listo para producción y subida a GitHub con etiquetas `v0.329`, `v0.331` y `v0.337`.

> ⚠️ Nota: Este CHANGELOG.md ha sido generado con la ayuda de **ChatGPT (modelo GPT-5 mini)** de OpenAI.

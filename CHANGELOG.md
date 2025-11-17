# Changelog

## [v0.0.0.3] Videoclub 3.0 16/11/2025
### Features Added
- **Sistema de login con sesiones**:
  - Creación de `index.php` con formulario de usuario/password.
  - Comprobación de credenciales en `login.php`:
    - Administrador: `admin/admin`.
    - Usuario estándar: `usuario/usuario`.
  - Si las credenciales son incorrectas, se recarga el formulario mostrando mensaje de error.
  - Si las credenciales son correctas, se inicia sesión y se redirige a la página correspondiente.

- **Carga de datos del videoclub en sesión (solo admin)**:
  - Si el usuario es **administrador**, en `login.php` se cargan en `$_SESSION`:
    - Datos de **soportes** (cintas, DVDs, juegos, etc.).
    - Datos de **clientes** del videoclub.
  - Los datos se copian desde las pruebas previas y se insertan en arrays asociativos (sin `include`).

- **Navegación por rol de usuario**:
  - `main.php`:
    - Muestra mensaje de bienvenida con el nombre del usuario logueado.
    - Incluye enlace para cerrar sesión y volver al login.
  - `mainAdmin.php` (solo admin):
    - Muestra listado de clientes.
    - Muestra listado de soportes.
  - `mainCliente.php` (cliente normal):
    - Si el usuario coincide con un cliente de la sesión, se listan sus alquileres.

- **Cambios en la clase `Cliente`**:
  - Añadidos atributos `user` y `password` para cada cliente.
  - Nuevo método `getAlquileres(): array` para devolver los soportes alquilados.
  - Adaptación del constructor y del listado de `mainAdmin.php` para mostrar también el usuario.

- **Alta de nuevos clientes**:
  - `formCreateCliente.php`: formulario para crear un nuevo cliente.
  - `createCliente.php`:
    - Recoge datos por `POST`, valida y los introduce en la sesión.
    - Si todo es correcto, redirige a `mainAdmin.php` para ver el nuevo cliente.
    - Si hay errores, vuelve a cargar el formulario mostrando la información de error.

- **Edición de clientes**:
  - `formUpdateCliente.php`: formulario para editar los datos de un cliente existente.
  - `updateCliente.php`: procesa la edición y actualiza los datos en la sesión.
  - Los datos de un cliente se pueden modificar tanto desde la página del propio cliente como desde el listado del administrador.

- **Eliminación de clientes**:
  - Desde el listado de clientes en `mainAdmin.php` se ofrece la opción de borrar un cliente.
  - Antes de redirigir al servidor, se muestra una confirmación en el navegador con JavaScript.
  - `removeCliente.php`:
    - Elimina el cliente de la sesión.
    - Reorganiza el array si es necesario.
    - Redirige de nuevo a `mainAdmin.php` para mostrar el listado actualizado.

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

> ⚠️ Nota: Este CHANGELOG.md ha sido generado con la ayuda de **ChatGPT (modelo GPT-5 mini)** de OpenAI.

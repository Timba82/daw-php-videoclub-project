# daw-php-videoclub-project
Proyecto de un Videoclub (basado en la propuesta que hace el tutorial de desarrolloweb.com), el cual vamos a realizar mediante un desarrollo incremental y siguiendo la práctica de programación en parejas (pair programming)

# 🎬 Proyecto Videoclub

Este proyecto es una simulación de un pequeño **sistema de gestión de un videoclub**, desarrollado con **PHP**.  
Está basado en la propuesta del tutorial de [desarrolloweb.com](https://desarrolloweb.com) y se ha realizado de forma **incremental**, siguiendo la práctica de **programación en parejas (pair programming)**.

El objetivo principal es practicar la **programación orientada a objetos (POO)** en PHP, trabajando con clases, herencia, encapsulación, constantes, arrays y objetos.

---

## 🧩 Estructura del Proyecto

El proyecto se desarrolla paso a paso, incorporando nuevas clases y funcionalidades en cada etapa.

### 1️⃣ Clase `Soporte`
Clase base que representa un soporte físico o digital disponible en el videoclub (como cintas de vídeo, DVDs o videojuegos).

**Características principales:**
- Atributos: `titulo`, `numero`, `precio`.
- Constante estática `IVA = 21%`.
- Método `muestraResumen()` que muestra el título y el precio del soporte.

📄 **Archivo:** `Soporte.php`  
📄 **Archivo de prueba:** `inicio.php`

---

### 2️⃣ Clase `CintaVideo`
Hereda de `Soporte` e introduce el atributo adicional `duracion`.

**Características principales:**
- Atributo: `duracion` (en minutos).
- Sobrescribe el método `muestraResumen()` llamando al del padre.

📄 **Archivo:** `CintaVideo.php`

---

### 3️⃣ Clase `Dvd`
Hereda de `Soporte` e incluye información adicional sobre los idiomas disponibles y el formato de pantalla.

**Características principales:**
- Atributos: `idiomas`, `formatoPantalla`.
- Sobrescribe el método `muestraResumen()` para incluir los nuevos datos.

📄 **Archivo:** `Dvd.php`

---

### 4️⃣ Clase `Juego`
Hereda de `Soporte` e introduce los atributos `consola`, `minNumJugadores`, `maxNumJugadores`.

**Características principales:**
- Método adicional `muestraJugadoresPosibles()`, que indica si es para un jugador, para varios o un rango.
- Sobrescribe `muestraResumen()`.

📄 **Archivo:** `Juego.php`

---

### 5️⃣ Clase `Cliente`
Representa a un cliente del videoclub.

**Características principales:**
- Atributos: `nombre`, `numero`, `maxAlquilerConcurrente`, `soportesAlquilados`.
- Métodos principales:
  - `tieneAlquilado(Soporte $s)`: comprueba si el soporte ya está alquilado.
  - `alquilar(Soporte $s)`: realiza un nuevo alquiler (si es posible).
  - `devolver(int $numSoporte)`: devuelve un soporte alquilado.
  - `listarAlquileres()`: lista todos los alquileres actuales.
  - `muestraResumen()`: muestra un resumen del cliente y sus alquileres.

📄 **Archivo:** `Cliente.php`  
📄 **Archivo de prueba:** `inicio2.php`

---

### 6️⃣ Clase `Videoclub`
Gestiona el conjunto de clientes y soportes disponibles en el videoclub.

**Características principales:**
- Arrays:
  - `productos`: lista de objetos `Soporte`.
  - `socios`: lista de objetos `Cliente`.
- Métodos:
  - `incluirProducto(Soporte $s)`: añade un soporte al catálogo.
  - `incluirSocio(Cliente $c)`: añade un cliente.
  - Métodos públicos específicos para crear soportes (que llaman internamente a `incluirProducto()`).

📄 **Archivo:** `Videoclub.php`  
📄 **Archivo de prueba:** `inicio3.php`

---

## 🧠 Conceptos Clave

- **Herencia:** Las clases `CintaVideo`, `Dvd` y `Juego` heredan de `Soporte`.
- **Polimorfismo:** Cada clase hija redefine el método `muestraResumen()`.
- **Encapsulación:** Los atributos son privados o protegidos, accedidos mediante getters/setters.
- **Constantes y estáticos:** La clase `Soporte` define un IVA común para todos los productos.
- **Arrays de objetos:** Los clientes y los productos se almacenan y gestionan mediante arrays.
- **Control de flujo lógico:** Validación de cupo de alquileres y existencia de soportes alquilados.

---

## 🧱 Extensiones Finales

### 🔹 Clase abstracta `Soporte`
Transformar `Soporte` en una clase abstracta impide su instanciación directa y refuerza la idea de que solo las subclases concretas (`CintaVideo`, `Dvd`, `Juego`) representan soportes reales.

### 🔹 Interfaz `Resumible`
Define el método `muestraResumen()`, que deben implementar todas las clases que quieran ofrecer un resumen textual de sus datos.  
`Soporte` implementa esta interfaz, y sus clases hijas la heredan automáticamente.

---

## 🧪 Archivos de prueba

| Archivo | Propósito |
|----------|------------|
| `inicio.php` | Prueba de `Soporte`, `CintaVideo`, `Dvd` y `Juego`. |
| `inicio2.php` | Prueba de `Cliente` y sus métodos. |
| `inicio3.php` | Prueba de `Videoclub`, con múltiples clientes y soportes. |

---

## ⚙️ Instrucciones de Uso

### 🖥️ 1. Inicializar el repositorio local
```bash
git init
git add .
git commit -m "Inicializando proyecto"


> ⚠️ Nota: Este README.md ha sido generado con la ayuda de **ChatGPT (modelo GPT-5 mini)** de OpenAI.

# Proyecto Final de Desarrollo Web en Entorno Servidor de una Tienda: La Charcutería de Don Manolo

![Logo de la Charcutería de Don Manolo](./assets/images/donmanolo.png)

<div style="page-break-after: always;"></div>

## Introducción

Este proyecto es una aplicación web de una tienda de charcutería llamada "Charcutería de Don Manolo". La charcutería de Don Manolo es una charcutería de postín conocida por su secreto íntimo familiar sobre jamones y su corte perfecto. La aplicación permite a los usuarios registrarse, iniciar sesión, ver productos destacados, gestionar categorías, productos y pedidos, y realizar compras. El proyecto está desarrollado en PHP y utiliza una arquitectura MVC (Modelo-Vista-Controlador).

## Índice

1. Estructura del Proyecto
2. Explicación de los Ficheros

   1. Raíz del Proyecto
   2. Directorio assets
   3. Directorio controllers
   4. Directorio database
   5. Directorio helpers
   6. Directorio lib
   7. Directorio models
   8. Directorio views
3. Enlaces/Bibliografía

<div style="page-break-after: always;"></div>

## Estructura del Proyecto

La estructura del proyecto es la siguiente:

**DWES_ProyectoFinal_Tienda_MartinVazquez_Adrian/**

**│**

**├── assets/**

**│   ├── css/**

**│   │   └── estilos.css**

**│   ├── fonts/**

**│   │   └── (varios archivos .ttf)**

**│   └── images/**

**│       └── (varios archivos de imagen)**

**│**

**├── controllers/**

**│   ├── CarritoController.php**

**│   ├── CategoriaController.php**

**│   ├── ErrorController.php**

**│   ├── PedidoController.php**

**│   ├── ProductoController.php**

**│   └── UsuarioController.php**

**│**

**├── database/**

**│   └── database.sql**

**│**

**├── helpers/**

**│   └── Utils.php**

**│**

**├── lib/**

**│   └── BaseDatos.php**

**│**

**├── models/**

**│   ├── Categoria.php**

**│   ├── Pedido.php**

**│   ├── Producto.php**

**│   └── Usuario.php**

**│**

**├── views/**

**│   ├── carrito/**

**│   ├── categoria/**

**│   │   ├── crear.php**

**│   │   ├── lista.php**

**│   │   └── index.php**

**│   ├── layout/**

**│   │   ├── footer.php**

**│   │   ├── header.php**

**│   │   └── sidebar.php**

**│   ├── pedido/**

**│   ├── producto/**

**│   │   ├── crear.php**

**│   │   ├── editar.php**

**│   │   ├── lista.php**

**│   │   ├── destacados.php**

**│   │   ├── todosLosProductos.php**

**│   │   └── productosPorCategoria.php**

**│   └── usuario/**

**│       ├── login.php**

**│       ├── registro.php**

**│       ├── lista.php**

**│       ├── editarUsuarioLista.php**

**│       ├── editarCuenta.php**

**│       └── crear.php**

<div style="page-break-after: always;"></div>

## Explicación de los Ficheros

### Raíz del Proyecto

***.env** : Archivo que contiene las variables de entorno, como las credenciales de la base de datos.

***.gitignore** : Archivo que especifica qué archivos y directorios deben ser ignorados por Git.

***.htaccess** : Archivo de configuración de Apache para la reescritura de URLs y manejo de errores.

***autoload.php** : Archivo que define la función de autocarga para cargar automáticamente las clases de los controladores y modelos.

***config.php** : Archivo de configuración que define las constantes de configuración de la base de datos y otras configuraciones del proyecto.

***index.php** : Archivo principal que inicia la aplicación, maneja las rutas y carga los controladores y vistas correspondientes.

### Directorio [assets](./assets)

***css/estilos.css** : Archivo de estilos CSS para la aplicación.

***fonts/** : Directorio que contiene varios archivos de fuentes `.ttf`.

***images/** : Directorio que contiene varios archivos de imagen utilizados en la aplicación.

### Directorio [controllers](./controllers)

***CarritoController.php** : Controlador para gestionar las acciones relacionadas con el carrito de compras.

***CategoriaController.php** : Controlador para gestionar las acciones relacionadas con las categorías.

***ErrorController.php** : Controlador para gestionar las acciones relacionadas con los errores.

***PedidoController.php** : Controlador para gestionar las acciones relacionadas con los pedidos.

***ProductoController.php** : Controlador para gestionar las acciones relacionadas con los productos.

***UsuarioController.php** : Controlador para gestionar las acciones relacionadas con los usuarios.

### Directorio [database](./database)

***database.sql** : Archivo SQL que contiene el script para crear y poblar la base de datos.

### Directorio [helpers](./helpers)

***Utils.php** : Clase de utilidades con métodos estáticos para diversas funciones comunes, como la gestión de sesiones y la validación de datos.

### Directorio [lib](./lib)

***BaseDatos.php** : Clase para gestionar la conexión y las operaciones con la base de datos utilizando PDO.

### Directorio [models](./models)

***Categoria.php** : Modelo para gestionar las operaciones relacionadas con las categorías.

***Pedido.php** : Modelo para gestionar las operaciones relacionadas con los pedidos.

***Producto.php** : Modelo para gestionar las operaciones relacionadas con los productos.

***Usuario.php** : Modelo para gestionar las operaciones relacionadas con los usuarios.

### Directorio [views](./views)

***carrito/** : Directorio que contiene las vistas relacionadas con el carrito de compras.

***categoria/** : Directorio que contiene las vistas relacionadas con las categorías.

  ***crear.php** : Vista para crear una nueva categoría.

  ***lista.php** : Vista para listar las categorías.

  ***index.php** : Vista principal para gestionar las categorías.

***layout/** : Directorio que contiene las vistas de la estructura de la página.

  ***footer.php** : Vista del pie de página.

  ***header.php** : Vista de la cabecera.

  ***sidebar.php** : Vista de la barra lateral.

***pedido/** : Directorio que contiene las vistas relacionadas con los pedidos.

***producto/** : Directorio que contiene las vistas relacionadas con los productos.

  ***crear.php** : Vista para crear un nuevo producto.

  ***editar.php** : Vista para editar un producto existente.

  ***lista.php** : Vista para listar los productos.

  ***destacados.php** : Vista de productos destacados.

  ***todosLosProductos.php** : Vista para listar todos los productos con paginación.

  ***productosPorCategoria.php** : Vista para listar productos por categoría con paginación.

***usuario/** : Directorio que contiene las vistas relacionadas con los usuarios.

  ***login.php** : Vista del formulario de inicio de sesión.

  ***registro.php** : Vista del formulario de registro de usuario.

  ***lista.php** : Vista de la lista de usuarios.

  ***editarUsuarioLista.php** : Vista para editar un usuario desde la lista de usuarios.

  ***editarCuenta.php** : Vista para editar la cuenta del usuario actual.

  ***crear.php** : Vista para crear un nuevo usuario.

<div style="page-break-after: always;"></div>

## Enlaces/Bibliografía

* [Repositorio en GitHub](https://github.com/6R4N4DR1/DWES_ProyectoFinal_Tienda_MartinVazquez_Adrian)
* [Documentación Oficial de PHP](https://www.php.net/manual/es/index.php)
* [Documentación de Composer](https://getcomposer.org/doc/)
* [Documentación de PDO](https://www.php.net/manual/es/book.pdo.php)
* El Guión PDF del proyecto
* [Lista de Conceptos PHP por Aloncraft](https://github.com/AloncraftMC/DWES_Hernandez_Robles_Alonso/blob/master/LISTA%20DE%20CONCEPTOS%20PHP.md)
* [Copilot](https://github.com/copilot)
* [ChatGPT](https://chatgpt.com/)
* Guias varias de YouTube sobre el manejo de PHP con MySQL y xampp
* Ayuda, apoyo y explicaciones de compañeros de clase

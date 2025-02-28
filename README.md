
# Proyecto Final de Desarrollo Web en Entorno Servidor

## Índice

1. Portada
2. Índice
3. Estructura del Proyecto
4. Explicación de los Ficheros

## Portada

![Logo de la Charcutería de Don Manolo](vscode-file://vscode-app/c:/xampp/htdocs/dashboard/DWES_ProyectoFinal_Tienda_MartinVazquez_Adrian/assets/images/donmanolo.png)

Este proyecto es una aplicación web de una tienda de charcutería llamada "Charcutería de Don Manolo". La charcutería de Don Manolo es una charcutería de postín conocida por su secreto íntimo familiar sobre jamones y su corte perfecto. La aplicación permite a los usuarios registrarse, iniciar sesión, ver productos destacados, gestionar categorías, productos y pedidos, y realizar compras. El proyecto está desarrollado en PHP y utiliza una arquitectura MVC (Modelo-Vista-Controlador).

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

**│   └── ProductoController.php**

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

**│   │   └── index.php**

**│   ├── layout/**

**│   │   ├── footer.php**

**│   │   ├── header.php**

**│   │   └── sidebar.php**

**│   ├── pedido/**

**│   ├── producto/**

**│   │   └── destacados.php**

**│   └── usuario/**

**│       ├── login.php**

**│       ├── registro.php**

**│       ├── lista.php**

**│       ├── editarUsuarioLista.php**

**│       ├── editarCuenta.php**

**│       └── crear.php**

**│**

**├── .env**

**├── .gitignore**

**├── .htaccess**

**├── autoload.php**

**├── config.php**

**└── index.php**

## Explicación de los Ficheros

### Raíz del Proyecto

* **.env** : Archivo que contiene las variables de entorno, como las credenciales de la base de datos.
* **.gitignore** : Archivo que especifica qué archivos y directorios deben ser ignorados por Git.
* **.htaccess** : Archivo de configuración de Apache para la reescritura de URLs y manejo de errores.
* **autoload.php** : Archivo que define la función de autocarga para cargar automáticamente las clases de los controladores y modelos.
* **config.php** : Archivo de configuración que define las constantes de configuración de la base de datos y otras configuraciones del proyecto.
* **index.php** : Archivo principal que inicia la aplicación, maneja las rutas y carga los controladores y vistas correspondientes.

### Directorio [assets](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)

* **css/estilos.css** : Archivo de estilos CSS para la aplicación.
* **fonts/** : Directorio que contiene varios archivos de fuentes `.ttf`.
* **images/** : Directorio que contiene varios archivos de imagen utilizados en la aplicación.

### Directorio [controllers](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)

* **CarritoController.php** : Controlador para gestionar las acciones relacionadas con el carrito de compras.
* **CategoriaController.php** : Controlador para gestionar las acciones relacionadas con las categorías.
* **ErrorController.php** : Controlador para gestionar las acciones relacionadas con los errores.
* **PedidoController.php** : Controlador para gestionar las acciones relacionadas con los pedidos.
* **ProductoController.php** : Controlador para gestionar las acciones relacionadas con los productos.

### Directorio [database](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)

* **database.sql** : Archivo SQL que contiene el script para crear y poblar la base de datos.

### Directorio [helpers](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)

* **Utils.php** : Clase de utilidades con métodos estáticos para diversas funciones comunes, como la gestión de sesiones y la validación de datos.

### Directorio [lib](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)

* **BaseDatos.php** : Clase para gestionar la conexión y las operaciones con la base de datos utilizando PDO.

### Directorio [models](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)

* **Categoria.php** : Modelo para gestionar las operaciones relacionadas con las categorías.
* **Pedido.php** : Modelo para gestionar las operaciones relacionadas con los pedidos.
* **Producto.php** : Modelo para gestionar las operaciones relacionadas con los productos.
* **Usuario.php** : Modelo para gestionar las operaciones relacionadas con los usuarios.

### Directorio [views](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)

* **carrito/** : Directorio que contiene las vistas relacionadas con el carrito de compras.
* **categoria/index.php** : Vista principal para gestionar las categorías.
* **layout/footer.php** : Vista del pie de página.
* **layout/header.php** : Vista de la cabecera.
* **layout/sidebar.php** : Vista de la barra lateral.
* **pedido/** : Directorio que contiene las vistas relacionadas con los pedidos.
* **producto/destacados.php** : Vista de productos destacados.
* **usuario/login.php** : Vista del formulario de inicio de sesión.
* **usuario/registro.php** : Vista del formulario de registro de usuario.
* **usuario/lista.php** : Vista de la lista de usuarios.
* **usuario/editarUsuarioLista.php** : Vista para editar un usuario desde la lista de usuarios.
* **usuario/editarCuenta.php** : Vista para editar la cuenta del usuario actual.
* **usuario/crear.php** : Vista para crear un nuevo usuario.

## Enlaces

* [Repositorio en GitHub](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)
* [Documentación Oficial de PHP](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)
* [Documentación de Composer](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)
* [Documentación de PDO](vscode-file://vscode-app/c:/Users/adria/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html)

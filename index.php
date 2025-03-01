<?php
    // Inicia el buffering de salida antes de cualquier otra cosa.
    ob_start();

    // Inicia la sesión
    session_start();

    // Importa el controlador de errores y el modelo de Usuario
    use controllers\ErrorController;
    use models\Usuario;

    // Carga los archivos necesarios
    require_once 'autoload.php';
    require_once 'config.php';
    require_once 'helpers/Utils.php';

    // Verifica si el usuario ha iniciado sesión y si su ID está presente en la sesión
    if (isset($_SESSION['identity']) && isset($_SESSION['identity']['id'])) {
        // Obtiene los datos del usuario por su ID
        $usuario = Usuario::getUserPorId($_SESSION['identity']['id']);
        // Actualiza la información del usuario en la sesión
        $_SESSION['identity'] = [
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
            'apellidos' => $usuario->getApellidos(),
            'email' => $usuario->getEmail(),
            'rol' => $usuario->getRol()
        ];

        // Si el usuario es administrador, establece una sesión de administrador
        if($usuario->getRol() == 'admin'){
            $_SESSION['admin'] = true;
        }
    }
    /*
    Nota: La linea de la 17 a la 34 son necesarias para el correcto funcionamiento de la gestión de usuarios y permisos en la aplicación.
    Son fundamentales para mantener la sesión del usuario actualizada y para gestionar los permisos de administrador de manera adecuada.
    Con esto el sistema verifica si el usuario ha iniciado sesión y si su ID está presente en la sesión, ademas de si tiene privilegios de administrador.
    Asi no se pierde la sesión del usuario y se mantiene la información actualizada y no manejamos sesiones en un limbo, sino en tiempo real todo momento.
    */

    // Carga las vistas de la cabecera y la barra lateral
    require_once 'views/layout/header.php';
    require_once 'views/layout/sidebar.php';

    // Se utiliza la etiqueta <main> para definir el contenido principal de la página
    // Esto ayuda a mejorar la accesibilidad y la semántica del HTML
    echo '<main>';
    
    // Verifica si se ha pasado un controlador por la URL
    if(isset($_GET['controller'])){
        // Construye el nombre completo del controlador
        $nombre_controlador = 'controllers\\' . $_GET['controller'] . 'Controller';
    } elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
        // Si no se ha pasado ni controlador ni acción, usa el controlador por defecto
        $nombre_controlador = 'controllers\\' . CONTROLLER_DEFAULT . 'Controller';
    }else{
        // Si no se encuentra el controlador, muestra un mensaje de error y llama al controlador de errores para mostrar "Página no encontrada"
        (new ErrorController())->index();
    }
    
    // Verifica si la clase del controlador existe
    if(class_exists($nombre_controlador)){
        // Crea una instancia del controlador
        $controlador = new $nombre_controlador();

        // Verifica si se ha pasado una acción por la URL y si el método existe en el controlador
        if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
            $action = $_GET['action'];
            // Llama a la acción del controlador
            $controlador->$action();
        } elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
            // Si no se ha pasado ni controlador ni acción, usa la acción por defecto
            $action_default = ACTION_DEFAULT;
            $controlador->$action_default();
        } else {
            // Si no se encuentra la acción, muestra un mensaje de error y llama al controlador de errores para mostrar "Página no encontrada"
            (new ErrorController())->index();
        }
    } else {
        // Si no se encuentra el controlador, muestra un mensaje de error y llama al controlador de errores para mostrar "Página no encontrada"
        (new ErrorController())->index();
    }

    echo '</main>';

    // Carga la vista del pie de página
    require_once 'views/layout/footer.php';

    // Al final del script, se envía todo el contenido acumulado.
    ob_end_flush();
?>
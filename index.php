<?php
    // Inicia el buffering de salida antes de cualquier otra cosa.
    ob_start();

    // Inicia la sesión
    session_start();

    // Importa el controlador de errores
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

        if ($usuario) {
            // Actualiza la información del usuario en la sesión
            $_SESSION['identity'] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'apellidos' => $usuario->getApellidos(),
                'email' => $usuario->getEmail(),
                'rol' => $usuario->getRol()
            ];
        }

        // Si el usuario es administrador, establece una sesión de administrador
        if($usuario->getRol() == 'admin'){
            $_SESSION['admin'] = true;
        }
    }

    // Carga las vistas de la cabecera y la barra lateral
    require_once 'views/layout/header.php';
    require_once 'views/layout/sidebar.php';

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

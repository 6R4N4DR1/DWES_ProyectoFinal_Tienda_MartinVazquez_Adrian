<?php
    namespace controllers;

    // Importa los modelos de Categoria, y las utilidades
    use models\Categoria;
    use helpers\Utils;

    /**
     * Clase CategoriaController
     * Controlador para gestionar las acciones relacionadas con las categorías.
     */
    class CategoriaController{
        
        /**
         * Método save
         * Guarda una nueva categoría en la base de datos.
         */
        public function save(){
            Utils::isAdmin(); // Verifica si el usuario es administrador

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

                // Guarda el nombre en la sesión para reutilizarlo en caso de error
                $_SESSION['form_data']['nombre'] = $nombre;

                if($nombre){
                    // Verifica que el nombre solo contenga letras y espacios
                    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $nombre)){
                        $_SESSION['register'] = 'failed_nombre';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'categoria/crearCategoria');
                        exit();
                    }
                    
                    $categoria = new Categoria();
                    $categoria->setNombre($nombre);

                    // Verifica si la categoría ya existe
                    if($categoria->existeCategoria()){
                        $_SESSION['categoria'] = 'failed_existe';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'categoria/crearCategoria');
                        exit();
                    }

                    // Guarda la categoría en la base de datos
                    $save = $categoria->guardar();

                    if($save){
                        Utils::deleteSession('form_data');
                        $_SESSION['categoria'] = 'complete';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'categoria/crearCategoria');
                        exit();
                    }else{
                        $_SESSION['categoria'] = 'failed';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'categoria/crearCategoria');
                        exit();
                    }
                }else{
                    $_SESSION['categoria'] = 'failed';
                    if(ob_get_length()) { ob_clean(); }
                    header('Location:'.BASE_URL.'categoria/crearCategoria');
                    exit();
                }
            }else{
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL);
                exit();
            }
        }

        /**
         * Método crearCategoria
         * Carga la vista para crear una nueva categoría.
         */
        public function crearCategoria(){
            Utils::isAdmin(); // Verifica si el usuario es administrador

            // Obtener el total de páginas de categorías
            $categorias = Categoria::getAllCat();
            $categoriasPorPagina = CATEGORIES_PER_PAGE;
            $totalPaginas = max(1, ceil(count($categorias) / $categoriasPorPagina));

            require_once 'views/categoria/crear.php';
        }

        /**
         * Método listaCategorias
         * Carga la vista con la lista de categorías paginadas.
         */
        public function listaCategorias(){
            Utils::isAdmin(); // Verifica si el usuario es administrador

            $categoriasPorPagina = CATEGORIES_PER_PAGE;
            $_SESSION['pagina'] = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

            $categorias = Categoria::getAllCat();

            $totalPaginas = max(1, ceil(count($categorias) / $categoriasPorPagina));
            $categorias = array_slice($categorias, ($_SESSION['pagina'] - 1) * $categoriasPorPagina, $categoriasPorPagina);

            // Verifica si la página es menor que 1
            if($_SESSION['pagina'] < 1) {
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL.'categoria/listaCategorias&pagina=1');
                exit();
            }

            // Verifica si la página es mayor que el total de páginas
            if($_SESSION['pagina'] > $totalPaginas) {
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL.'categoria/listaCategorias&pagina='.$totalPaginas);
                exit();
            }

            require_once 'views/categoria/lista.php';
        }

        /**
         * Método getCategoriasParaNav
         * Obtiene las categorías para la navegación paginada.
         * 
         * @param int $pagina Página actual de la navegación.
         * @return array Lista de categorías y el total de páginas.
         */
        public static function getCategoriasParaNav($pagina){
            $categoriasPorPagina = CATEGORIES_PER_PAGE;
            $categorias = Categoria::getAllCat();
            $totalPaginas = max(1, ceil(count($categorias) / $categoriasPorPagina));
            $categorias = array_slice($categorias, ($pagina - 1) * $categoriasPorPagina, $categoriasPorPagina);

            return [$categorias, $totalPaginas];
        }
    }
?>
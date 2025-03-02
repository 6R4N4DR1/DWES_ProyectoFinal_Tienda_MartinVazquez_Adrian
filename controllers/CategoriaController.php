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
        public function save(){
            Utils::isAdmin(); // Verifica si el usuario es administrador

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

                $_SESSION['form_data']['nombre'] = $nombre;

                if($nombre){
                    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $nombre)){
                        $_SESSION['register'] = 'failed_nombre';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'categoria/crearCategoria');
                        exit();
                    }
                    
                    $categoria = new Categoria();
                    $categoria->setNombre($nombre);

                    if($categoria->existeCategoria()){
                        $_SESSION['categoria'] = 'failed_existe';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'categoria/crearCategoria');
                        exit();
                    }

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

        public function crearCategoria(){
            Utils::isAdmin(); // Verifica si el usuario es administrador

            // Obtener el total de páginas de categorías
            $categorias = Categoria::getAllCat();
            $categoriasPorPagina = CATEGORIES_PER_PAGE;
            $totalPaginas = max(1, ceil(count($categorias) / $categoriasPorPagina));

            require_once 'views/categoria/crear.php';
        }

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

        public static function getCategoriasParaNav($pagina){
            $categoriasPorPagina = CATEGORIES_PER_PAGE;
            $categorias = Categoria::getAllCat();
            $totalPaginas = max(1, ceil(count($categorias) / $categoriasPorPagina));
            $categorias = array_slice($categorias, ($pagina - 1) * $categoriasPorPagina, $categoriasPorPagina);

            return [$categorias, $totalPaginas];
        }
    }
?>
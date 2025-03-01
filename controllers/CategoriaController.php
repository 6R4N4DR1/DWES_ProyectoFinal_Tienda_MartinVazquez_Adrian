<?php
    namespace controllers;

    // Importa los modelos de Categoria y Producto, y las utilidades
    use models\Categoria;
    use models\Producto;
    use helpers\Utils;

    /**
     * Clase CategoriaController
     * Controlador para gestionar las acciones relacionadas con las categorías.
     */
    class CategoriaController{
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
    }
?>
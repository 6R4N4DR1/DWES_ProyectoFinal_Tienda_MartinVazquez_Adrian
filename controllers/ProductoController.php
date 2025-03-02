<?php
    namespace controllers;

    // Importa las utilidades y los modelos de Producto y Categoria
    use helpers\Utils;
    use models\Producto;
    use models\Categoria;

    /**
     * Clase ProductoController
     * Controlador para gestionar las acciones relacionadas con los productos.
     */
    class ProductoController{
        
        /**
         * Método destacados
         * Carga la vista de productos destacados.
         */
        public function destacados(){
            // Obtiene los primeros 6 productos
            $productos = Producto::getPrimerosProductos(6);
            // Carga la vista de productos destacados
            require_once 'views/producto/destacados.php';
        }

        /**
         * Método todosLosProductos
         * Carga la vista con todos los productos paginados.
         */
        public function todosLosProductos(){
            // Número de productos por página
            $productosPorPagina = PRODUCTS_PER_PAGE;
            // Página actual
            $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        
            // Obtiene todos los productos
            $todosLosProductos = Producto::getAllProd();
            // Total de productos
            $totalProductos = count($todosLosProductos);
            // Total de páginas
            $totalPaginas = max(1, ceil($totalProductos / $productosPorPagina));
        
            // Obtiene los productos para la página actual
            $productos = array_slice($todosLosProductos, ($paginaActual - 1) * $productosPorPagina, $productosPorPagina);
        
            // Carga la vista de todos los productos
            require_once 'views/producto/todosLosProductos.php';
        }

        /**
         * Método save
         * Guarda un nuevo producto en la base de datos.
         * Solo accesible para el administrador.
         */
        public function save(){
            Utils::isAdmin(); // Verifica si el usuario es administrador
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                // Obtiene los datos del formulario
                $categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : false;
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
                $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
                $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
                $oferta = isset($_POST['oferta']) ? $_POST['oferta'] : false;
                $fecha = date('Y-m-d'); // Fecha actual
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : false;
        
                // Guarda los datos del formulario en la sesión
                $_SESSION['form_data'] = $_POST;
        
                // Verifica que todos los datos estén presentes
                if($categoria_id && $nombre && $descripcion && $precio && $stock && $oferta && $imagen){
                    // Validaciones de los datos
                    if(!preg_match("/^[0-9]+$/", $categoria_id)){
                        $_SESSION['producto'] = 'failed_categoria_id';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }
        
                    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]+$/", $nombre)){
                        $_SESSION['producto'] = 'failed_nombre';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }
        
                    if(!preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $precio)){
                        $_SESSION['producto'] = 'failed_precio';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }
        
                    if(!preg_match("/^[0-9]+$/", $stock)){
                        $_SESSION['producto'] = 'failed_stock';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }
        
                    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]+$/", $oferta)){
                        $_SESSION['producto'] = 'failed_oferta';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }
        
                    // Manejo de la imagen
                    $nombreImagen = $imagen['name'];
                    if(!is_dir('assets/images')){
                        mkdir('assets/images', 0777, true);
                    }
                    move_uploaded_file($imagen['tmp_name'], 'assets/images/'.$nombreImagen);
        
                    // Crea un nuevo producto
                    $producto = new Producto();
                    $producto->setCategoriaId($categoria_id);
                    $producto->setNombre($nombre);

                    // Verifica si el producto ya existe
                    if($producto->existeProducto()){
                        $_SESSION['producto'] = 'failed_existe';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }

                    // Establece los datos del producto
                    $producto->setDescripcion($descripcion);
                    $producto->setPrecio($precio);
                    $producto->setStock($stock);
                    $producto->setOferta($oferta);
                    $producto->setFecha($fecha);
                    $producto->setImagen($nombreImagen);
        
                    // Guarda el producto en la base de datos
                    $save = $producto->guardar();
        
                    if($save){
                        Utils::deleteSession('form_data');
                        $_SESSION['producto'] = 'complete';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }else{
                        $_SESSION['producto'] = 'failed';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }
                }else{
                    $_SESSION['producto'] = 'failed';
                    if(ob_get_length()) { ob_clean(); }
                    header('Location:'.BASE_URL.'producto/crearProducto');
                    exit();
                }
            }else{
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL);
                exit();
            }
        }

        /**
         * Método crearProducto
         * Carga la vista para crear un nuevo producto.
         * Solo accesible para el administrador.
         */
        public function crearProducto(){
            Utils::isAdmin(); // Verifica si el usuario es administrador

            // Obtiene todos los productos
            $productos = Producto::getAllProd();
            // Número de productos por página
            $productosPorPagina = PRODUCTS_PER_PAGE;
            // Total de páginas
            $totalPaginas = max(1, ceil(count($productos) / $productosPorPagina));

            // Obtener todas las categorías
            $categorias = Categoria::getAllCat();

            // Carga la vista para crear un nuevo producto
            require_once 'views/producto/crear.php';
        }

        /**
         * Método listaProductos
         * Carga la vista con la lista de productos.
         * Solo accesible para el administrador.
         */
        public function listaProductos(){
            Utils::isAdmin(); // Verifica si el usuario es administrador
    
            // Número de productos por página
            $productosPorPagina = PRODUCTS_PER_PAGE;
            // Página actual
            $_SESSION['pagina'] = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    
            // Obtiene todos los productos
            $productos = Producto::getAllProd();
    
            // Total de páginas
            $totalPaginas = max(1, ceil(count($productos) / $productosPorPagina));
            // Obtiene los productos para la página actual
            $productos = array_slice($productos, ($_SESSION['pagina'] - 1) * $productosPorPagina, $productosPorPagina);
    
            // Obtener todas las categorías
            $categorias = Categoria::getAllCat();
            $categoriasMap = [];
            foreach ($categorias as $categoria) {
                $categoriasMap[$categoria->getId()] = $categoria->getNombre();
            }
    
            // Verifica si la página es menor que 1
            if($_SESSION['pagina'] < 1) {
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL.'producto/listaProductos&pagina=1');
                exit();
            }
    
            // Verifica si la página es mayor que el total de páginas
            if($_SESSION['pagina'] > $totalPaginas) {
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL.'producto/listaProductos&pagina='.$totalPaginas);
                exit();
            }
    
            // Carga la vista de la lista de productos
            require_once 'views/producto/lista.php';
        }

        /**
         * Método delete
         * Elimina un producto de la base de datos.
         * Solo accesible para el administrador.
         */
        public function delete() {
            Utils::isAdmin(); // Verifica si el usuario es administrador
    
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                $producto = new Producto();
                $producto->setId($id);
    
                // Elimina el producto
                $delete = $producto->eliminar();
    
                if ($delete) {
                    $_SESSION['delete'] = 'complete';
                } else {
                    $_SESSION['delete'] = 'failed';
                }
            } else {
                $_SESSION['delete'] = 'failed';
            }
    
            if (ob_get_length()) { ob_clean(); }
            header('Location:' . BASE_URL . 'producto/listaProductos');
            exit();
        }

        /**
         * Método edit
         * Carga la vista para editar un producto.
         * Solo accesible para el administrador.
         */
        public function edit() {
            Utils::isAdmin(); // Verifica si el usuario es administrador
    
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Verifica si el producto existe
                if(Producto::getProdPorId($id)){
                    require_once 'views/producto/editar.php';
                }else{
                    if (ob_get_length()) { ob_clean(); }
                    header('Location:' . BASE_URL . 'producto/listaProductos&' . (isset($_SESSION['pagina']) ? "&pagina=" . $_SESSION['pagina'] : "") . "#" . $id);
                    exit();
                }
            } else {
                if (ob_get_length()) { ob_clean(); }
                header('Location:' . BASE_URL . 'producto/listaProductos');
                exit();
            }
        }

        /**
         * Método editarProducto
         * Actualiza los datos de un producto en la base de datos.
         * Solo accesible para el administrador.
         */
        public function editarProducto(){
            Utils::isAdmin(); // Verifica si el usuario es administrador
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                // Obtiene los datos del formulario
                $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
                $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : null;
                $oferta = isset($_POST['oferta']) ? $_POST['oferta'] : null;
                $fecha = date('Y-m-d'); // Fecha actual
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;
        
                // Guarda los datos del formulario en la sesión
                $_SESSION['form_data'] = [
                    'precio' => $precio,
                    'stock' => $stock,
                    'oferta' => $oferta,
                    'fecha' => $fecha
                ];
        
                // Obtiene el ID del producto
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                // Obtiene el producto actual
                $productoActual = Producto::getProdPorId($id);
                
                // Verifica si hay cambios en los datos
                if($precio > 0 || $stock >= 0 || $oferta != $productoActual->getOferta() || $imagen){
                    // Validaciones de los datos
                    if($precio > 0 && !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $precio)){
                        $_SESSION['edicion'] = 'failed_precio';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit();
                    }
        
                    if($stock >= 0 && !preg_match("/^[0-9]+$/", $stock)){
                        $_SESSION['edicion'] = 'failed_stock';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit();
                    }
        
                    if($oferta && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]+$/", $oferta)){
                        $_SESSION['edicion'] = 'failed_oferta';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit();
                    }
        
                    // Manejo de la imagen
                    if($imagen && $imagen['name'] != ''){
                        $nombreImagen = $imagen['name'];
                        if(!is_dir('assets/images')){
                            mkdir('assets/images', 0777, true);
                        }
                        move_uploaded_file($imagen['tmp_name'], 'assets/images/'.$nombreImagen);
                    } else {
                        $nombreImagen = $productoActual->getImagen();
                    }
        
                    // Actualiza los datos del producto
                    $producto = new Producto();
                    $producto->setId($id);
                    $producto->setPrecio($precio);
                    $producto->setStock($stock);
                    $producto->setOferta($oferta);
                    $producto->setFecha($fecha);
                    $producto->setImagen($nombreImagen);
        
                    // Guarda los cambios en la base de datos
                    if($producto->actualizarBD()){
                        $_SESSION['edicion'] = 'complete';
                        Utils::deleteSession('form_data');
        
                        if(isset($_GET['id'])){
                            if(ob_get_length()) { ob_clean(); }
                            header('Location:'.BASE_URL.'producto/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                            exit();
                        }
                    }else{
                        $_SESSION['edicion'] = 'failed';
                        if(isset($_GET['id'])){
                            if(ob_get_length()) { ob_clean(); }
                            header('Location:'.BASE_URL.'producto/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                            exit();
                        }
                    }
                }else{
                    $_SESSION['edicion'] = 'undefined';
                }
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL.'producto/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                exit();
            }else{
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL);
                exit();
            }
        }

        /**
         * Método productosPorCategoria
         * Carga la vista con los productos de una categoría específica.
         */
        public function productosPorCategoria(){
            if(isset($_GET['id'])){
                // Obtiene el ID de la categoría
                $categoria_id = $_GET['id'];
                // Número de productos por página
                $productosPorPagina = PRODUCTS_PER_PAGE;
                // Página actual
                $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        
                // Obtiene todos los productos de la categoría
                $todosLosProductos = Producto::getProdPorCategoria($categoria_id);
                // Total de productos
                $totalProductos = count($todosLosProductos);
                // Total de páginas
                $totalPaginas = max(1, ceil($totalProductos / $productosPorPagina));
        
                // Obtiene los productos para la página actual
                $productos = array_slice($todosLosProductos, ($paginaActual - 1) * $productosPorPagina, $productosPorPagina);
        
                // Obtener todas las categorías
                $categorias = Categoria::getAllCat();
                $categoriasMap = [];
                foreach ($categorias as $categoria) {
                    $categoriasMap[$categoria->getId()] = $categoria->getNombre();
                }
        
                // Carga la vista de productos por categoría
                require_once 'views/producto/productosPorCategoria.php';
            } else {
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL);
                exit();
            }
        }
    }
?>
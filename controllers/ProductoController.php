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
            require_once 'views/producto/destacados.php';
        }

        /**
         * Método save
         * Guarda un nuevo producto en la base de datos.
         * Solo accesible para el administrador.
         */
        public function save(){
            Utils::isAdmin(); // Verifica si el usuario es administrador
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : false;
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
                $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
                $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
                $oferta = isset($_POST['oferta']) ? $_POST['oferta'] : false;
                $fecha = date('Y-m-d'); // Fecha actual
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : false;
        
                $_SESSION['form_data'] = $_POST;
        
                if($categoria_id && $nombre && $descripcion && $precio && $stock && $oferta && $imagen){
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
        
                    $producto = new Producto();
                    $producto->setCategoriaId($categoria_id);
                    $producto->setNombre($nombre);

                    if($producto->existeProducto()){
                        $_SESSION['producto'] = 'failed_existe';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'producto/crearProducto');
                        exit();
                    }

                    $producto->setDescripcion($descripcion);
                    $producto->setPrecio($precio);
                    $producto->setStock($stock);
                    $producto->setOferta($oferta);
                    $producto->setFecha($fecha);
                    $producto->setImagen($nombreImagen);
        
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

            $productos = Producto::getAllProd();
            $productosPorPagina = PRODUCTS_PER_PAGE;
            $totalPaginas = max(1, ceil(count($productos) / $productosPorPagina));

            // Obtener todas las categorías
            $categorias = Categoria::getAllCat();

            require_once 'views/producto/crear.php';
        }

        /**
         * Método listaProductos
         * Carga la vista con la lista de productos.
         * Solo accesible para el administrador.
         */
        public function listaProductos(){
            Utils::isAdmin(); // Verifica si el usuario es administrador
    
            $productosPorPagina = PRODUCTS_PER_PAGE;
            $_SESSION['pagina'] = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    
            $productos = Producto::getAllProd();
    
            $totalPaginas = max(1, ceil(count($productos) / $productosPorPagina));
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
    
            require_once 'views/producto/lista.php';
        }

        public function delete() {
            Utils::isAdmin(); // Verifica si el usuario es administrador
    
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                $producto = new Producto();
                $producto->setId($id);
    
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

        public function edit() {
            Utils::isAdmin(); // Verifica si el usuario es administrador
    
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

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

        public function editarProducto(){
            Utils::isAdmin();
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
                $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : null;
                $oferta = isset($_POST['oferta']) ? $_POST['oferta'] : null;
                $fecha = date('Y-m-d'); // Fecha actual
                $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;
        
                $_SESSION['form_data'] = [
                    'precio' => $precio,
                    'stock' => $stock,
                    'oferta' => $oferta,
                    'fecha' => $fecha
                ];
        
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $productoActual = Producto::getProdPorId($id);
                
                if($precio > 0 || $stock >= 0 || $oferta != $productoActual->getOferta() || $imagen){
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
        
                    if($imagen && $imagen['name'] != ''){
                        $nombreImagen = $imagen['name'];
                        if(!is_dir('assets/images')){
                            mkdir('assets/images', 0777, true);
                        }
                        move_uploaded_file($imagen['tmp_name'], 'assets/images/'.$nombreImagen);
                    } else {
                        $nombreImagen = $productoActual->getImagen();
                    }
        
                    $producto = new Producto();
                    $producto->setId($id);
                    $producto->setPrecio($precio);
                    $producto->setStock($stock);
                    $producto->setOferta($oferta);
                    $producto->setFecha($fecha);
                    $producto->setImagen($nombreImagen);
        
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
    }
?>
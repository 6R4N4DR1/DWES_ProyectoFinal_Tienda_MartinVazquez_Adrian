<?php
    namespace models;

    use lib\BaseDatos;

    /**
     * Clase Producto
     * Modelo para gestionar las operaciones relacionadas con los productos.
     */
    class Producto{
        // Propiedades de la clase
        private int $id; // ID del producto
        private int $categoria_id; // ID de la categoría del producto
        private string $nombre; // Nombre del producto
        private string $descripcion; // Descripción del producto
        private float $precio; // Precio del producto
        private int $stock; // Stock del producto
        private string $oferta; // Oferta del producto
        private string $fecha; // Fecha de creación del producto
        private string $imagen; // Imagen del producto
        private BaseDatos $bd; // Instancia de la base de datos

        /* Getter y Setter de las propiedades */

        /**
         * Obtiene el ID del producto.
         * 
         * @return int ID del producto.
         */
        public function getId(): int {
            return $this->id;
        }

        /**
         * Establece el ID del producto.
         * 
         * @param int $id ID del producto.
         */
        public function setId(int $id): void {
            $this->id = $id;
        }

        /**
         * Obtiene el ID de la categoría del producto.
         * 
         * @return int ID de la categoría del producto.
         */
        public function getCategoriaId(): int {
            return $this->categoria_id;
        }

        /**
         * Establece el ID de la categoría del producto.
         * 
         * @param int $categoria_id ID de la categoría del producto.
         */
        public function setCategoriaId(int $categoria_id): void {
            $this->categoria_id = $categoria_id;
        }

        /**
         * Obtiene el nombre del producto.
         * 
         * @return string Nombre del producto.
         */
        public function getNombre(): string {
            return $this->nombre;
        }

        /**
         * Establece el nombre del producto.
         * 
         * @param string $nombre Nombre del producto.
         */
        public function setNombre(string $nombre): void {
            $this->nombre = $nombre;
        }

        /**
         * Obtiene la descripción del producto.
         * 
         * @return string Descripción del producto.
         */
        public function getDescripcion(): string {
            return $this->descripcion;
        }

        /**
         * Establece la descripción del producto.
         * 
         * @param string $descripcion Descripción del producto.
         */
        public function setDescripcion(string $descripcion): void {
            $this->descripcion = $descripcion;
        }

        /**
         * Obtiene el precio del producto.
         * 
         * @return float Precio del producto.
         */
        public function getPrecio(): float {
            return $this->precio;
        }

        /**
         * Establece el precio del producto.
         * 
         * @param float $precio Precio del producto.
         */
        public function setPrecio(float $precio): void {
            $this->precio = $precio;
        }

        /**
         * Obtiene el stock del producto.
         * 
         * @return int Stock del producto.
         */
        public function getStock(): int {
            return $this->stock;
        }

        /**
         * Establece el stock del producto.
         * 
         * @param int $stock Stock del producto.
         */
        public function setStock(int $stock): void {
            $this->stock = $stock;
        }

        /**
         * Obtiene la oferta del producto.
         * 
         * @return string Oferta del producto.
         */
        public function getOferta(): string {
            return $this->oferta;
        }

        /**
         * Establece la oferta del producto.
         * 
         * @param string $oferta Oferta del producto.
         */
        public function setOferta(string $oferta): void {
            $this->oferta = $oferta;
        }

        /**
         * Obtiene la fecha de creación del producto.
         * 
         * @return string Fecha de creación del producto.
         */
        public function getFecha(): string {
            return $this->fecha;
        }

        /**
         * Establece la fecha de creación del producto.
         * 
         * @param string $fecha Fecha de creación del producto.
         */
        public function setFecha(string $fecha): void {
            $this->fecha = $fecha;
        }

        /**
         * Obtiene la imagen del producto.
         * 
         * @return string Imagen del producto.
         */
        public function getImagen(): string {
            return $this->imagen;
        }

        /**
         * Establece la imagen del producto.
         * 
         * @param string $imagen Imagen del producto.
         */
        public function setImagen(string $imagen): void {
            $this->imagen = $imagen;
        }

        /**
         * Guarda un nuevo producto en la base de datos.
         * 
         * @return bool True si el producto se guardó correctamente, false en caso contrario.
         */
        public function guardar(): bool {
            $this->bd = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)"; // Consulta SQL para insertar un nuevo producto
            $this->bd->ejecutarConsulta($sql, [
                ":categoria_id" => $this->categoria_id, 
                ":nombre" => $this->nombre, 
                ":descripcion" => $this->descripcion, 
                ":precio" => $this->precio, 
                ":stock" => $this->stock, 
                ":oferta" => $this->oferta, 
                ":fecha" => $this->fecha, 
                ":imagen" => $this->imagen
            ]); // Ejecuta la consulta

            $salidaBD = $this->bd->getNumRegistros() == 1; // Verifica si se insertó una fila
            $this->bd->closeBD(); // Cierra la conexión a la base de datos
            return $salidaBD; // Retorna el resultado de la operación
        }

        /**
         * Elimina un producto de la base de datos.
         * 
         * @return bool True si el producto se eliminó correctamente, false en caso contrario.
         */
        public function eliminar(): bool {
            $this->bd = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "DELETE FROM productos WHERE id = :id"; // Consulta SQL para eliminar un producto
            $this->bd->ejecutarConsulta($sql, [":id" => $this->id]); // Ejecuta la consulta
    
            $salidaBD = $this->bd->getNumRegistros() == 1; // Verifica si se eliminó una fila
            $this->bd->closeBD(); // Cierra la conexión a la base de datos
            return $salidaBD; // Retorna el resultado de la operación
        }

        /**
         * Actualiza los datos de un producto en la base de datos.
         * 
         * @return bool True si el producto se actualizó correctamente, false en caso contrario.
         */
        public function actualizarBD(): bool {
            $this->bd = new BaseDatos(); // Crea una nueva instancia de la base de datos
        
            $sql = "UPDATE productos SET precio = :precio, stock = :stock, oferta = :oferta, fecha = :fecha, imagen = :imagen WHERE id = :id"; // Consulta SQL para actualizar un producto
            $this->bd->ejecutarConsulta($sql, [
                ':precio' => $this->precio,
                ':stock' => $this->stock,
                ':oferta' => $this->oferta,
                ':fecha' => $this->fecha,
                ':imagen' => $this->imagen,
                ':id' => $this->id
            ]); // Ejecuta la consulta
            $salidaBD = $this->bd->getNumRegistros() == 1; // Verifica si se actualizó una fila
            $this->bd->closeBD(); // Cierra la conexión a la base de datos
            
            return $salidaBD; // Retorna el resultado de la operación
        }

        /**
         * Verifica si un producto ya existe en la base de datos.
         * 
         * @return bool True si el producto existe, false en caso contrario.
         */
        public function existeProducto(): bool {
            $this->bd = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "SELECT id FROM productos WHERE nombre = :nombre"; // Consulta SQL para verificar si el producto existe
            $this->bd->ejecutarConsulta($sql, [":nombre" => $this->nombre]); // Ejecuta la consulta
    
            $existe = $this->bd->getNumRegistros() > 0; // Verifica si se encontró algún registro
            $this->bd->closeBD(); // Cierra la conexión a la base de datos
    
            return $existe; // Retorna el resultado de la verificación
        }

        /**
         * Obtiene todos los productos de la base de datos.
         * 
         * @return array Lista de productos.
         */
        public static function getAllProd(): array {
            $bdClon = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "SELECT * FROM productos"; // Consulta SQL para obtener todos los productos
            $bdClon->ejecutarConsulta($sql); // Ejecuta la consulta
            $registros = $bdClon->getRegistros(); // Obtiene los registros de la consulta
            $productos = []; // Array para almacenar los productos

            // Itera sobre los registros y crea instancias de la clase Producto
            foreach($registros as $registro){
                $producto = new Producto();
                $producto->setId($registro["id"]);
                $producto->setCategoriaId($registro["categoria_id"]);
                $producto->setNombre($registro["nombre"]);
                $producto->setDescripcion($registro["descripcion"]);
                $producto->setPrecio($registro["precio"]);
                $producto->setStock($registro["stock"]);
                $producto->setOferta($registro["oferta"]);
                $producto->setFecha($registro["fecha"]);
                $producto->setImagen($registro["imagen"]);
                $productos[] = $producto; // Añade el producto al array
            }
            $bdClon->closeBD(); // Cierra la conexión a la base de datos

            return $productos; // Retorna la lista de productos
        }

        /**
         * Obtiene un producto por su ID.
         * 
         * @param int $id ID del producto.
         * @return Producto|null Producto si se encontró, null en caso contrario.
         */
        public static function getProdPorId(int $id): ?Producto {
            $bdClon = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "SELECT * FROM productos WHERE id = :id"; // Consulta SQL para obtener un producto por su ID
            $bdClon->ejecutarConsulta($sql, [':id' => $id]); // Ejecuta la consulta

            if($bdClon->getNumRegistros() == 1){
                $registro = $bdClon->getNextRegistro(); // Obtiene el siguiente registro

                $producto = new Producto();
                $producto->setId($registro['id']);
                $producto->setCategoriaId($registro['categoria_id']);
                $producto->setNombre($registro['nombre']);
                $producto->setDescripcion($registro['descripcion']);
                $producto->setPrecio($registro['precio']);
                $producto->setStock($registro['stock']);
                $producto->setOferta($registro['oferta']);
                $producto->setFecha($registro['fecha']);
                $producto->setImagen($registro['imagen']);
                $bdClon->closeBD(); // Cierra la conexión a la base de datos

                return $producto; // Retorna el producto
            }
            $bdClon->closeBD(); // Cierra la conexión a la base de datos

            return null; // Retorna null si no se encontró el producto
        }

        /**
         * Obtiene los primeros N productos de la base de datos.
         * 
         * @param int $limite Número de productos a obtener.
         * @return array Lista de productos.
         */
        public static function getPrimerosProductos(int $limite): array {
            $bdClon = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "SELECT * FROM productos LIMIT $limite"; // Consulta SQL para obtener los primeros N productos
            $bdClon->ejecutarConsulta($sql); // Ejecuta la consulta
            $registros = $bdClon->getRegistros(); // Obtiene los registros de la consulta
            $productos = []; // Array para almacenar los productos
        
            // Itera sobre los registros y crea instancias de la clase Producto
            foreach($registros as $registro){
                $producto = new Producto();
                $producto->setId($registro["id"]);
                $producto->setCategoriaId($registro["categoria_id"]);
                $producto->setNombre($registro["nombre"]);
                $producto->setDescripcion($registro["descripcion"]);
                $producto->setPrecio($registro["precio"]);
                $producto->setStock($registro["stock"]);
                $producto->setOferta($registro["oferta"]);
                $producto->setFecha($registro["fecha"]);
                $producto->setImagen($registro["imagen"]);
                $productos[] = $producto; // Añade el producto al array
            }
            $bdClon->closeBD(); // Cierra la conexión a la base de datos
        
            return $productos; // Retorna la lista de productos
        }

        /**
         * Obtiene los productos de una categoría específica.
         * 
         * @param int $categoria_id ID de la categoría.
         * @return array Lista de productos de la categoría.
         */
        public static function getProdPorCategoria(int $categoria_id): array {
            $bdClon = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "SELECT * FROM productos WHERE categoria_id = :categoria_id"; // Consulta SQL para obtener los productos de una categoría
            $bdClon->ejecutarConsulta($sql, [':categoria_id' => $categoria_id]); // Ejecuta la consulta
            $registros = $bdClon->getRegistros(); // Obtiene los registros de la consulta
            $productos = []; // Array para almacenar los productos
        
            // Itera sobre los registros y crea instancias de la clase Producto
            foreach($registros as $registro){
                $producto = new Producto();
                $producto->setId($registro["id"]);
                $producto->setCategoriaId($registro["categoria_id"]);
                $producto->setNombre($registro["nombre"]);
                $producto->setDescripcion($registro["descripcion"]);
                $producto->setPrecio($registro["precio"]);
                $producto->setStock($registro["stock"]);
                $producto->setOferta($registro["oferta"]);
                $producto->setFecha($registro["fecha"]);
                $producto->setImagen($registro["imagen"]);
                $productos[] = $producto; // Añade el producto al array
            }
            $bdClon->closeBD(); // Cierra la conexión a la base de datos
        
            return $productos; // Retorna la lista de productos
        }
    }
?>
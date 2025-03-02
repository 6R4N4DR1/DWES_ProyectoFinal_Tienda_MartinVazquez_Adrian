<?php
    namespace models;

    use lib\BaseDatos;

    /**
     * Clase Producto
     * Modelo para gestionar las operaciones relacionadas con los productos.
     */
    class Producto{
        // Aquí puedes añadir propiedades y métodos para gestionar los productos.
        private int $id;
        private int $categoria_id;
        private string $nombre;
        private string $descripcion;
        private float $precio;
        private int $stock;
        private string $oferta;
        private string $fecha;
        private string $imagen;
        private BaseDatos $bd;

        /*Getter y Setter de las propiedades*/
        public function getId(){
            return $this->id;
        }

        public function setId(int $id){
            $this->id = $id;
        }

        public function getCategoriaId(){
            return $this->categoria_id;
        }

        public function setCategoriaId(int $categoria_id){
            $this->categoria_id = $categoria_id;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre(string $nombre){
            $this->nombre = $nombre;
        }

        public function getDescripcion(){
            return $this->descripcion;
        }

        public function setDescripcion(string $descripcion){
            $this->descripcion = $descripcion;
        }

        public function getPrecio(){
            return $this->precio;
        }

        public function setPrecio(float $precio){
            $this->precio = $precio;
        }

        public function getStock(){
            return $this->stock;
        }

        public function setStock(int $stock){
            $this->stock = $stock;
        }

        public function getOferta(){
            return $this->oferta;
        }

        public function setOferta(string $oferta){
            $this->oferta = $oferta;
        }

        public function getFecha(){
            return $this->fecha;
        }

        public function setFecha(string $fecha){
            $this->fecha = $fecha;
        }

        public function getImagen(){
            return $this->imagen;
        }

        public function setImagen(string $imagen){
            $this->imagen = $imagen;
        }

        public function guardar(){
            $this->bd = new BaseDatos();
            $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)";
            $this->bd->ejecutarConsulta($sql, [
                ":categoria_id" => $this->categoria_id, 
                ":nombre" => $this->nombre, 
                ":descripcion" => $this->descripcion, 
                ":precio" => $this->precio, 
                ":stock" => $this->stock, 
                ":oferta" => $this->oferta, 
                ":fecha" => $this->fecha, 
                ":imagen" => $this->imagen
            ]);

            $salidaBD = $this->bd->getNumRegistros() == 1;
            $this->bd->closeBD();
            return $salidaBD;
        }

        public function eliminar() {
            $this->bd = new BaseDatos();
            $sql = "DELETE FROM productos WHERE id = :id";
            $this->bd->ejecutarConsulta($sql, [":id" => $this->id]);
    
            $salidaBD = $this->bd->getNumRegistros() == 1;
            $this->bd->closeBD();
            return $salidaBD;
        }

        public function actualizarBD(){
            $this->bd = new BaseDatos();
        
            $sql = "UPDATE productos SET precio = :precio, stock = :stock, oferta = :oferta, fecha = :fecha, imagen = :imagen WHERE id = :id";
            $this->bd->ejecutarConsulta($sql, [
                ':precio' => $this->precio,
                ':stock' => $this->stock,
                ':oferta' => $this->oferta,
                ':fecha' => $this->fecha,
                ':imagen' => $this->imagen,
                ':id' => $this->id
            ]);
            $salidaBD = $this->bd->getNumRegistros() == 1;
            $this->bd->closeBD();
            
            return $salidaBD;
        }

        public function existeProducto() {
            $this->bd = new BaseDatos();
            $sql = "SELECT id FROM productos WHERE nombre = :nombre";
            $this->bd->ejecutarConsulta($sql, [":nombre" => $this->nombre]);
    
            $existe = $this->bd->getNumRegistros() > 0;
            $this->bd->closeBD();
    
            return $existe;
        }

        public static function getAllProd(){
            $bdClon = new BaseDatos();
            $sql = "SELECT * FROM productos";
            $bdClon->ejecutarConsulta($sql);
            $registros = $bdClon->getRegistros();
            $productos = [];

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
                $productos[] = $producto;
            }
            $bdClon->closeBD();

            return $productos;
        }

        public static function getProdPorId(int $id){
            $bdClon = new BaseDatos();
            $sql = "SELECT * FROM productos WHERE id = :id";
            $bdClon->ejecutarConsulta($sql, [':id' => $id]);

            if($bdClon->getNumRegistros() == 1){
                $registro = $bdClon->getNextRegistro();

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
                $bdClon->closeBD();

                return $producto;
            }
            $bdClon->closeBD();

            return null;
        }
    }
?>
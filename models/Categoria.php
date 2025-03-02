<?php
    namespace models;

    use lib\BaseDatos;

    /**
     * Clase Categoria
     * Modelo para gestionar las operaciones relacionadas con las categorías.
     */
    class Categoria{
        // Propiedades de la clase
        private int $id; // ID de la categoría
        private string $nombre; // Nombre de la categoría
        private BaseDatos $bd; // Instancia de la base de datos

        /* Getter y Setter de las propiedades */

        /**
         * Obtiene el ID de la categoría.
         * 
         * @return int ID de la categoría.
         */
        public function getId():int{
            return $this->id;
        }

        /**
         * Establece el ID de la categoría.
         * 
         * @param int $id ID de la categoría.
         */
        public function setId(int $id):void{
            $this->id = $id;
        }

        /**
         * Obtiene el nombre de la categoría.
         * 
         * @return string Nombre de la categoría.
         */
        public function getNombre():string{
            return $this->nombre;
        }

        /**
         * Establece el nombre de la categoría.
         * 
         * @param string $nombre Nombre de la categoría.
         */
        public function setNombre(string $nombre):void{
            $this->nombre = $nombre;
        }

        /**
         * Guarda una nueva categoría en la base de datos.
         * 
         * @return bool True si la categoría se guardó correctamente, false en caso contrario.
         */
        public function guardar(){
            $this->bd = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)"; // Consulta SQL para insertar una nueva categoría
            $this->bd->ejecutarConsulta($sql, [":nombre" => $this->nombre]); // Ejecuta la consulta

            $salidaBD = $this->bd->getNumRegistros() == 1; // Verifica si se insertó una fila
            $this->bd->closeBD(); // Cierra la conexión a la base de datos
            return $salidaBD; // Retorna el resultado de la operación
        }

        /**
         * Obtiene todas las categorías de la base de datos.
         * 
         * @return array Lista de categorías.
         */
        public static function getAllCat(){
            $bdClon = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "SELECT * FROM categorias"; // Consulta SQL para obtener todas las categorías
            $bdClon->ejecutarConsulta($sql); // Ejecuta la consulta
            $registros = $bdClon->getRegistros(); // Obtiene los registros de la consulta
            $categorias = []; // Array para almacenar las categorías

            // Itera sobre los registros y crea instancias de la clase Categoria
            foreach($registros as $registro){
                $categoria = new Categoria();
                $categoria->setId($registro["id"]);
                $categoria->setNombre($registro["nombre"]);
                $categorias[] = $categoria; // Añade la categoría al array
            }
            $bdClon->closeBD(); // Cierra la conexión a la base de datos

            return $categorias; // Retorna la lista de categorías
        }

        /**
         * Verifica si una categoría ya existe en la base de datos.
         * 
         * @return bool True si la categoría existe, false en caso contrario.
         */
        public function existeCategoria() {
            $this->bd = new BaseDatos(); // Crea una nueva instancia de la base de datos
            $sql = "SELECT id FROM categorias WHERE nombre = :nombre"; // Consulta SQL para verificar si la categoría existe
            $this->bd->ejecutarConsulta($sql, [":nombre" => $this->nombre]); // Ejecuta la consulta

            $existe = $this->bd->getNumRegistros() > 0; // Verifica si se encontró algún registro
            $this->bd->closeBD(); // Cierra la conexión a la base de datos

            return $existe; // Retorna el resultado de la verificación
        }
    }
?>
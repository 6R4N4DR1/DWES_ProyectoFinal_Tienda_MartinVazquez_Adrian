<?php
    namespace models;

    use lib\BaseDatos;

    /**
     * Clase Categoria
     * Modelo para gestionar las operaciones relacionadas con las categorías.
     */
    class Categoria{
        // Aquí puedes añadir propiedades y métodos para gestionar las categorías.
        private int $id;
        private string $nombre;
        private BaseDatos $bd;

        /*Getter y Setter de las propiedades*/
        public function getId():int{
            return $this->id;
        }

        public function setId(int $id):void{
            $this->id = $id;
        }

        public function getNombre():string{
            return $this->nombre;
        }

        public function setNombre(string $nombre):void{
            $this->nombre = $nombre;
        }

        public function guardar(){
            $this->bd = new BaseDatos();
            $sql = "INSERT INTO categorias (nombre) VALUES (null, :nombre)";
            $this->bd->ejecutarConsulta($sql, [":nombre" => $this->nombre]);

            $salidaBD = $this->bd->getNumRegistros() == 1;
            $this->bd->closeBD();
            return $salidaBD;
        }

        public static function getAllCat(){
            $bdClon = new BaseDatos();
            $sql = "SELECT * FROM categorias";
            $bdClon->ejecutarConsulta($sql);
            $registros = $bdClon->getRegistros();
            $categorias = [];

            foreach($registros as $registro){
                $categoria = new Categoria();
                $categoria->setId($registro["id"]);
                $categoria->setNombre($registro["nombre"]);
                array_push($categorias, $categoria);
            }
            $bdClon->closeBD();

            return $categorias;
        }
    }
?>
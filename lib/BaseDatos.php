<?php
    namespace lib;

    use PDO;
    use PDOException;
    use PDOStatement;

    /**
     * Clase BaseDatos
     * Clase para gestionar la conexión y las operaciones con la base de datos.
     * 
     * Nota: Esta clase fue desarrollada con el consejo, ayuda y explicación de compañeros de clase, así como con conceptos de PDO gracias a la ayuda de AloncraftMC.
     * Esto asegura que el patrón MVC funcione correctamente y que la estructura del código sea semánticamente correcta.
     * Además, GitHub Copilot apoyó en las tabulaciones y realizó la mayor parte de esta clase.
     */
    class BaseDatos{
        private string $localhost;
        private string $user;
        private string $password;
        private string $tienda;
        private ?PDO $conexion;
        private ?PDOStatement $consulta;

        /**
         * Constructor de la clase
         * Establece la conexión con la base de datos.
         */
        public function __construct(){
            try{
                $this->localhost = DB_HOST;
                $this->user = DB_USER;
                $this->password = DB_PASS;
                $this->tienda = DB_NAME;

                // Crea una nueva conexión PDO
                $this->conexion = new PDO("mysql:host=$this->localhost;dbname=$this->tienda", $this->user, $this->password);
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }catch(PDOException $PDOe){
                // Muestra el mensaje de error por defecto en caso de fallo en la conexión
                echo $PDOe->getMessage();
            }
        }

        /**
         * Método ejecutarConsulta
         * Ejecuta una consulta SQL con parámetros opcionales.
         * 
         * @param string $sql Consulta SQL a ejecutar.
         * @param array $parametros Parámetros opcionales para la consulta.
         */
        public function ejecutarConsulta(string $sql, array $parametros = []): void{
            try{
                // Prepara y ejecuta la consulta SQL
                $this->consulta = $this->conexion->prepare($sql);
                $this->consulta->execute($parametros);
            }catch(PDOException $PDOe){
                // Muestra el mensaje de error por defecto en caso de fallo en la conexión
                echo "Error en la conexión con la base de datos: ".$PDOe->getMessage();
            }
        }

        // Métodos para obtener resultados de la base de datos

        /**
         * Método getNextRegistro
         * Obtiene el siguiente registro de la consulta.
         * 
         * @return ?array El siguiente registro de la consulta o null si no hay más registros.
         */
        public function getNextRegistro(): ?array{
            return $this->consulta->fetch();
        }

        /**
         * Método getRegistros
         * Obtiene todos los registros de la consulta.
         * 
         * @return array Todos los registros de la consulta.
         */
        public function getRegistros(): array{
            return $this->consulta->fetchAll();
        }

        /**
         * Método getNumRegistros
         * Obtiene el número de registros de la consulta.
         * 
         * @return int El número de registros de la consulta.
         */
        public function getNumRegistros(): int{
            return $this->consulta->rowCount();
        }

        
        // Métodos para cerrar la conexión con la base de datos

        /**
         * Método closeBD
         * Cierra la conexión con la base de datos.
         */
        public function closeBD(): void{
            $this->conexion = null;
            $this->consulta = null;
        }

        /**
         * Destructor de la clase
         * Cierra la conexión con la base de datos al destruir el objeto.
         */
        public function __destruct(){
            $this->closeBD();
        }
    }
?>
<?php
    namespace lib;

    use PDO;
    use PDOException;
    use PDOStatement;

    /**
     * Clase BaseDatos
     * Clase para gestionar la conexión y las operaciones con la base de datos.
     */
    class BaseDatos{
        private string $localhost;
        private string $user;
        private string $password;
        private string $tienda;
        private PDO $conexion;
        private PDOStatement $consulta;

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
                $this->consulta = $this->conexion->prepare($sql);
                $this->consulta->execute($parametros);
            }catch(PDOException $PDOe){
                // Muestra el mensaje de error por defecto en caso de fallo en la conexión
                echo $PDOe->getMessage();
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
         * Método getNumeroRegistros
         * Obtiene el número de registros de la consulta.
         * 
         * @return int El número de registros de la consulta.
         */
        public function getNumeroRegistros(): int{
            return $this->consulta->rowCount();
        }

        /**
         * Método getUltimoId
         * Obtiene el último ID insertado en la base de datos.
         * 
         * @return string El último ID insertado.
         */
        public function getUltimoId(): string{
            return $this->conexion->lastInsertId();
        }

        // Métodos para gestionar transacciones

        /**
         * Método iniciarCambios
         * Inicia una transacción.
         */
        public function iniciarCambios(): void{
            $this->conexion->beginTransaction();
        }

        /**
         * Método guardarCambios
         * Confirma una transacción.
         */
        public function guardarCambios(): void{
            $this->conexion->commit();
        }

        /**
         * Método descartarCambios
         * Revierte una transacción.
         */
        public function descartarCambios(): void{
            $this->conexion->rollBack();
        }
    }
?>
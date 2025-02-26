<?php
    namespace lib;

    use PDO;
    use PDOException;
    use PDOStatement;

    class BaseDatos{
        private string $localhost;
        private string $user;
        private string $password;
        private string $tienda;
        private PDO $conexion;
        private PDOStatement $consulta;

        // Constructor de la clase, establece la conexión con la base de datos
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

        // Ejecuta una consulta SQL con parámetros opcionales
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

        // Obtiene el siguiente registro de la consulta
        public function getNextRegistro(): ?array{
            return $this->consulta->fetch();
        }

        // Obtiene todos los registros de la consulta
        public function getRegistros(): array{
            return $this->consulta->fetchAll();
        }

        // Obtiene el número de registros de la consulta
        public function getNumeroRegistros(): int{
            return $this->consulta->rowCount();
        }

        // Obtiene el último ID insertado en la base de datos
        public function getUltimoId(): string{
            return $this->conexion->lastInsertId();
        }

        // Inicia una transacción
        public function iniciarCambios(): void{
            $this->conexion->beginTransaction();
        }

        // Confirma una transacción
        public function guardarCambios(): void{
            $this->conexion->commit();
        }

        // Revierte una transacción
        public function descartarCambios(): void{
            $this->conexion->rollBack();
        }

    }
?>
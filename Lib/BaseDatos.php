<?php

namespace Lib;
use PDO;
use PDOException;

class BaseDatos extends PDO {

    private string $servidor;
    private string $usuario;
    private string $pass;
    private string $base_datos;
    private string $tipo_de_base = 'mysql';

    function __construct(){
        $this->servidor = $_ENV['DB_HOST'];
        $this->usuario = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->base_datos = $_ENV['DB_DATABASE'];


            try {
                $opciones = array (
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::MYSQL_ATTR_FOUND_ROWS => true
                );
                parent::__construct("{$this->tipo_de_base}:dbname={$this->base_datos};host={$this->servidor}", $this->usuario, $this->pass, $opciones);

                /* Otra forma de conectarse a la base datos
                $conexion = new PDO("mysql:host={$this->servidor}; dbname={$this->base_datos}", $this->usuario, $this->pass, $opciones);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conexion;*/
            } catch(PDOException $e) {
                echo "Ha surgido un error y no se puede conectar a la base de datos. Detalle" . $e->getMessage();
                exit; 
            }

        


    }
    
    




}




?>
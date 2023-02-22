<?php

namespace Controllers;

use Lib\Pages;
use Models\Usuario;


class UsuarioController {

    private Pages $pages;
    private Usuario $usuario;
    

    public function __construct() {

        
        $this->pages = new Pages();
    }   

    // Método para registrar usuario
    public function registro() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if($_POST['data']){

                $datos = $_POST['data'];
                $usuario = Usuario::fromArray($datos);
                
                // comprueba si el usuario existe o no
                $existe = $usuario->existeEmail();

                if(!$existe) {
                    $validado = $usuario->validar();
                    

                    if(empty($validado)){
                        $save = $usuario->registrar();
                        if($save) {
                            $_SESSION['register'] = "complete";
                        } else {
                            $_SESSION['register'] = "failed";
                        }
                    } else {
                        $_SESSION['errores'] = $validado;
                        $_SESSION['register'] = "failed";
                    }
                } else {
                    $_SESSION['register'] = "exist";
                } 

            } else {
                $_SESSION['register'] = "failed";
            }
        
        }

        $this->pages->render('usuario/registro');

    }


    public function identifica() {
        $this->pages->render('usuario/login');
    }


    public function login(){
        // Identificar al usuario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['data']) {
                $datos = $_POST['data'];

                // Consulta a la base de datos
                $usuario = Usuario::fromArray($datos);

                $identity = $usuario->iniciarsesion();

                // Crear una sesión para el usuario identificado

                if ($identity && is_object($identity)) {
                    $_SESSION['identity'] = $identity;  // guardo los datos del usuario
                    var_dump($_SESSION['identity']);

                    if($identity->rol == 'admin') {
                        $_SESSION['admin'] = true;
                    }
                } else {
                    $_SESSION['error_login'] = 'Identificación fallida';
                }
            }
            header("Location:" . $_ENV['base_url']);  // redirige al principal
        }
    
    }

    public function logout() {
        if (isset($_SESSION['identity'])) {
            unset($_SESSION['identity']);
        }

        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }

        if (isset($_SESSION['carrito'])) {
            unset($_SESSION['carrito']);
        }

        header('Location:' . $_ENV['base_url']);
    }





}


?>
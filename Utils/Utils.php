<?php

namespace Utils;


class Utils {

    public static function deleteSession($name) {
        if(isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;

    }

    public static function isAdmin() {
        if(!isset($_SESSION['admin'])){
            header("Location:".$_ENV['base_url']);
        } else {
            return true;
        }
    }

    public static function isIdentity() {
        if(!isset($_SESSION['identity'])){
            header("Location:".$_ENV['base_url']."usuario/identifica");
        } else {
            return true;
        }
    }

    public static function cuentaCarrito() {
        if(isset($_SESSION['carrito'])) {
            $suma = 0;
            foreach($_SESSION['carrito'] as $indice => $elemento ) {
                $precio_producto = $elemento['precio'] * $elemento['unidades'];
                $suma += $precio_producto;
            }
            return $suma;
            
        }
    }


}




?>
<?php

namespace Controllers;
use Models\Categoria;
use Lib\Pages;
use Models\Producto;
use Utils\Utils;


class CarritoController {

    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }

    public function index() {
        $this->pages->render('carrito/index');
    }

    public function add($id) {
        
        if(isset($id)) {
            $producto_id = $id;
        } else{
            header('Location:' .$_ENV['base_url']);
        }

        if(isset($_SESSION['carrito'])) {
            $contador = 0;

            foreach($_SESSION['carrito'] as $indice => $elemento) {
                if($elemento['id_producto'] == $producto_id) {
                    $_SESSION['carrito'][$indice]['unidades']++;
                    $contador++;
                }
            }
        }

            if(!isset($contador) || $contador == 0) {
                // Nuevo producto
                $producto = new Producto();
                $producto->setId($producto_id);
                $producto = $producto->getOne();


                // Añadir producto al carrito
                if(is_object($producto)) {
                    $_SESSION['carrito'][] = array(
                    "id_producto" => $producto->id,
                    "precio" => $producto->precio,
                    "unidades" => 1,
                    "producto" => $producto
                    );
                }
            }
            header("Location:".$_ENV['base_url']."carrito/index");
    }

    public function delete($index) {
        if(isset($index)) {
            unset($_SESSION['carrito'][$index]);
            
            if(empty($_SESSION['carrito'])) {
                unset($_SESSION['carrito']);
            }
        }
        header("Location:".$_ENV['base_url']."carrito/index");
    }

    public function up($index) {
        // Añade una unidad más al producto existente en el carrito. No superará la cantidad de existencias en el stock.

        if(isset($index)) {
            $stock = $_SESSION['carrito'][$index]['producto']->stock;
            if(isset($_SESSION['carrito']) && $_SESSION['carrito'][$index]['unidades'] < $stock) {
                $_SESSION['carrito'][$index]['unidades']++;
            }
        }
        header("Location:".$_ENV['base_url']."carrito/index");
    }

    public function down($index) {
        // Resta una unidad más al producto existente en el carrito.
        if(isset($index)) {
            if(isset($_SESSION['carrito']) && $_SESSION['carrito'][$index]['unidades'] > 1) {
                $_SESSION['carrito'][$index]['unidades']--;

            }
        }
        header("Location:".$_ENV['base_url']."carrito/index");
    }

    public function delete_all() {
        if (isset($_SESSION['carrito'])) {
            unset($_SESSION['carrito']);
        }
        header("Location:".$_ENV['base_url']."carrito/index");
    }


    




}




?>
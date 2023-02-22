<?php

namespace Controllers;
use Models\Categoria;
use Lib\Pages;
use Models\Producto;
use Utils\Utils;
use PDO;
use PDOException;




class CategoriaController {

    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }



    public function index() {
        Utils::isAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->getAll();

        $this->pages->render('categoria/index', ['categorias' => $categorias]);
    }

    public function ver($id) {
        
        if(isset($id)) {
            $id = $id;
        }

        // Ver categoría
        $categoria = new Categoria();
        $categoria->setId($id);
        $categoria = $categoria->getOne();

        // Ver productos
        $producto = new Producto();
        $producto->setCategoria_id($id);
        $productos = $producto->getAllCategory();

        $this->pages->render('categoria/ver', ['categoria' => $categoria, 'productos' => $productos]);



    }

    public function crear() {
        Utils::isAdmin();
        $this->pages->render('categoria/crear');
    }

    // Método para guardar categoría
    public function saveCategoria() {
        Utils::isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre'])) {
                $nombreCategoria = $_POST['nombre'];

                $categoria = new Categoria();
                $categoria->setNombre($nombreCategoria);
                // comprueba si el nombre de la categoría es válido o no
                $valido = $categoria->validar();
                if(empty($valido)){
                    $save = $categoria->guardarCategoria($nombreCategoria);
                    if($save) {
                        $_SESSION['crear_categoria'] = 'complete';
                    } else {
                        $_SESSION['crear_categoria'] = 'failed';
                    }
                } else {
                    $_SESSION['errores_cat'] = $valido;
                }      
                
            } else {
                $_SESSION['crear_categoria'] = 'failed';
            }
        }
        // $this->pages->render('categoria/crear');
        
        header("Location:".$_ENV['base_url']."categoria/index");
    }

    public function editar() {
        Utils::isAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        $this->pages->render('categoria/editar',['categorias' => $categorias]);
    }

    // Método para actualizar una categoría
    public function actualizar() {
        Utils::isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if ( !empty($_POST['nombre']) && !empty($_POST['categoria_id']) ){
                $id_categoria = $_POST['categoria_id'];
                $nombre = $_POST['nombre'];
                
                $categoria = new Categoria();
                $categoria->setId($id_categoria);
                $categoria->setNombre($nombre);

                $valido = $categoria->validar();
                if(empty($valido)) {
                    $actualizada = $categoria->actualizarCategoria();
                    if($actualizada){
                        $_SESSION['actualizar_categoria'] = 'complete';
                    } else {
                        $_SESSION['actualizar_categoria'] = 'failed';
                    }
                } else{
                    $_SESSION['errores_cat'] = $valido;
                }

                

            } else {
                $_SESSION['actualizar_categoria'] = 'failed';
            }
            
            
        }
        header("Location:".$_ENV['base_url']."categoria/index");
    }
    // Método para borrar una categoría
    public function borrar() {
        Utils::isAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        $this->pages->render('categoria/borrar',['categorias' => $categorias]);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if (!empty($_POST['categoria_id']) ){
                $id_categoria = $_POST['categoria_id'];
                
                $categoria->setId($id_categoria);

                $borrado = $categoria->borrarCategoria();
                if($borrado){
                    $_SESSION['borrar_categoria'] = 'complete';
                } else {
                    $_SESSION['borrar_categoria'] = 'failed';
                }

            } else {
                $_SESSION['borrar_categoria'] = 'failed';
            }

            header("Location:".$_ENV['base_url']."categoria/index"); 
        }
        

    }
    
}


?>




<?php

namespace Controllers;
use Models\Categoria;
use Lib\Pages;
use Models\Producto;
use Utils\Utils;



class ProductoController {


    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }

    public function index() {
        $this->pages->render('inicio/inicio'); 
    }

    public function ver($id) {

            $producto = new Producto();
            $producto->setId($id);
            $product = $producto->getOne();
                      
        $this->pages->render('producto/ver', ['product' => $product]);  
        
    }

    public function gestion() {
        Utils::isAdmin();

        $producto = new Producto();
        $productos = $producto->getAll();

        $this->pages->render('producto/gestion', ['productos' => $productos]);
    }


    public function crear() {

        Utils::isAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        $this->pages->render('producto/crear',['categorias' => $categorias]);
    }

    public function save() {
        Utils::isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

                
            if (!empty($_POST['nombre']) && !empty($_POST['precio'])  && !empty($_POST['stock']) && !empty($_POST['categoria_id']) ) {
                $nombre = $_POST['nombre'];
                $precio = $_POST['precio'];
                $stock = $_POST['stock'];
                $categoria_id = $_POST['categoria_id'];
                $fecha =  date('Y-m-d');
                $imagen = NULL;

                if(isset($_POST['descripcion'])) {
                    $descripcion = $_POST['descripcion'];
                } else {
                    $descripcion = "NULL";
                }

                if(isset($_FILES['imagen'])) {
                    
    
                    $tipo = $_FILES['imagen']['type'];

                    if($tipo == "image/jpg" || $tipo == "image/jpeg" || $tipo == "image/png") {
                        $imagen = $_FILES['imagen']['name'];

                        if(!is_dir('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }

                        move_uploaded_file($_FILES['imagen']['tmp_name'], 'uploads/images/'.$imagen);

                        
                    }


                } 

                
                
                $producto = new Producto();
                $producto->setNombre($nombre);
                $valido = $producto->validar();
                if(empty($valido)){
                    $save = $producto->guardar($nombre,$precio,$stock,$categoria_id,$descripcion,$imagen,$fecha);
                    if($save) {
                        $_SESSION['crear_producto'] = 'complete';
                    } else {
                        $_SESSION['crear_producto'] = 'failed';
                    }
                } else {
                    $_SESSION['errores_prod'] = $valido;
                }
                
                
            } else {
                $_SESSION['crear_producto'] = 'failed';
            }
        }
        //$this->pages->render('producto/productoCreado');
        header("Location:".$_ENV['base_url']. "producto/gestion");
    }

    public function borrar() {
        Utils::isAdmin();
        $producto = new Producto();
        $productos = $producto->getAll();
        $this->pages->render('producto/borrar',['productos' => $productos]);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if (!empty($_POST['producto_id']) ){
                $id_producto = $_POST['producto_id'];
                
                $producto->setId($id_producto);

                $borrado = $producto->borrarProducto();
                if($borrado){
                    $_SESSION['borrar_producto'] = 'complete';
                } else {
                    $_SESSION['borrar_producto'] = 'failed';
                }

            } else {
                $_SESSION['borrar_producto'] = 'failed';
            }

            header("Location:".$_ENV['base_url']. "producto/gestion"); 
        }
        

    }

}


?>
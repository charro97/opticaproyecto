<?php

    session_start();
    require_once __DIR__.'/../vendor/autoload.php';
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // para acceder al contenido del archivo .env 
    $dotenv->safeLoad(); // si no existe no nos marca error


use Lib\Router;
use Controllers\UsuarioController;
use Controllers\CategoriaController;
use Controllers\ProductoController;
use Controllers\CarritoController;
use Controllers\PedidoController;
use Lib\Pages;

    $pages = new Pages();
    $pages->render('layout/header');
    
    Router::add('GET','/', function (){
        return (new ProductoController())->index();
    });

    // Rutas de usuario
   
    Router::add('GET','usuario/registro', function (){
        return (new UsuarioController())->registro();
    });

    Router::add('POST','usuario/registro', function (){
        return (new UsuarioController())->registro();
    });

    
    Router::add('GET','usuario/identifica', function (){
        return (new UsuarioController())->identifica();
    });

    Router::add('POST','usuario/login', function (){
        return (new UsuarioController())->login();
    });

    Router::add('GET','usuario/logout', function (){
        return (new UsuarioController())->logout();
    });

    // Rutas de categoria

    Router::add('GET','categoria/index', function (){
        return (new CategoriaController())->index();
    });


    Router::add('GET','categoria/crear', function (){
        return (new CategoriaController())->crear();
    });

    Router::add('POST','categoria/saveCategoria', function (){
        return (new CategoriaController())->saveCategoria();
    });

    Router::add('GET','categoria/ver/', function (){
        return "Página no disponible";
    });

    Router::add('GET','categoria/ver/:id', function ($id){
        return (new CategoriaController())->ver($id);
    });

    Router::add('GET','categoria/editar', function (){
        return (new CategoriaController())->editar();
    });

    Router::add('POST','categoria/actualizar', function (){
        return (new CategoriaController())->actualizar();
    });
    
    Router::add('PUT','categoria/actualizar', function (){
        return (new CategoriaController())->actualizar();
    });

    Router::add('GET','categoria/borrar', function (){
        return (new CategoriaController())->borrar();
    });

    Router::add('POST','categoria/borrar', function (){
        return (new CategoriaController())->borrar();
    });

    Router::add('DELETE','categoria/borrar', function (){
        return (new CategoriaController())->borrar();
    });

    // Rutas de producto

    Router::add('GET','producto/gestion', function (){
        return (new ProductoController())->gestion();
    });

    Router::add('GET','producto/crear', function (){
        return (new ProductoController())->crear();
    });

    Router::add('POST','producto/save', function (){
        return (new ProductoController())->save();
    });

    Router::add('GET','producto/ver/:id', function ($id){
        return (new ProductoController())->ver($id);
    });

    Router::add('GET','producto/borrar', function (){
        return (new ProductoController())->borrar();
    });

    Router::add('POST','producto/borrar', function (){
        return (new ProductoController())->borrar();
    });

    Router::add('DELETE','producto/borrar', function (){
        return (new ProductoController())->borrar();
    });


    // Rutas de carrito

    Router::add('GET','carrito/index', function (){
        return (new CarritoController())->index();
    });

    Router::add('GET','carrito/add/:id', function ($id){
        return (new CarritoController())->add($id);
    });

    Router::add('GET','carrito/delete/:id', function ($index){
        return (new CarritoController())->delete($index);
    });

    Router::add('GET','carrito/up/:id', function ($index){
        return (new CarritoController())->up($index);
    });

    Router::add('GET','carrito/down/:id', function ($index){
        return (new CarritoController())->down($index);
    });

    Router::add('GET','carrito/delete_all', function (){
        return (new CarritoController())->delete_all();
    });

    // Rutas de pedido

    Router::add('GET','pedido/rellenar', function (){
        return (new PedidoController())->rellenar();
    });

    Router::add('POST','pedido/hacer', function (){
        return (new PedidoController())->hacer();
    });

    Router::add('GET','pedido/mis_pedidos', function (){
        return (new PedidoController())->mis_pedidos();
    });


    Router::dispatch();
    
    
?>

    
<?php

 //$pages->render('layout/footer');
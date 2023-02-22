<?php

namespace Controllers;
use Models\Categoria;
use Lib\Pages;
use Models\Pedido;
use Models\LineaPedido;
use Models\Producto;
use Utils\Utils;
use PDO;
use PDOException;



class PedidoController {


    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }

    public function rellenar() {
        Utils::isIdentity();
        $this->pages->render('pedido/hacer');
    }

    public function mis_pedidos(){
        Utils::isIdentity();
        $pedido = new Pedido();
        $usuario_id = $_SESSION['identity']->id;
        $pedido->setUsuario_id($usuario_id);

        $pedidos = $pedido->getMisPedidos();

        $this->pages->render('pedido/mispedidos', ['pedidos' => $pedidos]);
    }

    public function hacer() {
        // Realiza completamente el proceso de un pedido
        Utils::isIdentity();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['provincia']) && isset($_POST['localidad']) && isset($_POST['direccion'])) {

                $pedido = new Pedido();
                $usuario_id = $_SESSION['identity']->id;
                $provincia = $_POST['provincia'];
                $localidad = $_POST['localidad'];
                $direccion = $_POST['direccion'];
                $coste = Utils::cuentaCarrito();
                $estado = 'pagado';
                $fecha = date('Y-m-d');

                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);
                $pedido->setEstado($estado);
                $pedido->setFecha($fecha);

                // Insertamos el pedido
                $save = $pedido->doPedido();

                if($save) {
                    
                    $_SESSION['hacer_pedido'] = 'complete';
                    if(isset($_SESSION['carrito'])) {

                        if($save) {
                            foreach($_SESSION['carrito'] as $indice => $elemento){
                                $producto_id = $elemento['producto']->id;
                                $unidades = $elemento['unidades'];

                                $producto = new Producto();
                                $producto->setId($producto_id);

                                $actualizado = $producto->actualizarStock($unidades);
                            }
                        }

                        if($save) {
                            if(isset($_SESSION['identity'])){
                                $nombre = $_SESSION['identity']->nombre;
                                $apellidos = $_SESSION['identity']->apellidos;
                            }

                            $importe = Utils::cuentaCarrito();
                            $pedido->enviarCorreo($nombre,$apellidos,$importe);

                            if (isset($_SESSION['carrito'])) {
                                unset($_SESSION['carrito']);
                            }
                    }
                    

                } else {
                    $_SESSION['hacer_pedido'] = 'failed';
                }
                
            } else {
                $_SESSION['hacer_pedido'] = 'failed';
            }
        }
        $this->pages->render('carrito/index');
    }
}
}




?>
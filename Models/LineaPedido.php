<?php 

namespace Models;
use Lib\BaseDatos;
use Models\Producto;
use PDO;
use PDOException;

class LineaPedido {

    private string $id;
    private string $pedido_id;    
    private string $producto_id;
    private string $unidades;

    
    private BaseDatos $db;

    public function __construct()
    {
        $this->db = new BaseDatos();
    }

    public function getId(): string{
        return $this->id;
    }

    public function setId(string $id){
        $this->id = $id;
    }

    public function getPedidoId(): string{
        return $this->pedido_id;
    }

    public function setPedidoId(string $pedido_id){
        $this->pedido_id = $pedido_id;
    }

    public function getProductoId(): string{
        return $this->producto_id;
    }

    public function setProductoId(string $producto_id){
        $this->producto_id = $producto_id;
    }

    public function getUnidades(): string{
        return $this->unidades;
    }

    public function setUnidades(string $unidades){
        $this->unidades = $unidades;
    }


}

?>
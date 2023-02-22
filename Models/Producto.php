<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;


class Producto {


    private string $id;
    private string $categoria_id;    
    private string $nombre;
    private string $descripcion;
    private string $precio;
    private string $stock;
    private string $oferta;
    private string $fecha;
    private string $imagen;

    private BaseDatos $db;
    protected static $errores = [];

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

    public function getCategoria_id(): string{
        return $this->categoria_id;
    }

    public function setCategoria_id(string $categoria_id){
        $this->categoria_id = $categoria_id;
    }

    public function getNombre(): string{
        return $this->nombre;
    }

    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string{
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion){
        $this->descripcion = $descripcion;
    }

    public function getPrecio(): string{
        return $this->precio;
    }

    public function setPrecio(string $precio){
        $this->precio = $precio;
    }

    public function getStock(): string{
        return $this->stock;
    }

    public function setStock(string $stock){
        $this->stock = $stock;
    }

    public function getOferta(): string{
        return $this->oferta;
    }

    public function setOferta(string $oferta){
        $this->oferta = $oferta;
    }

    public function getFecha(): string{
        return $this->fecha;
    }

    public function setFecha(string $fecha){
        $this->fecha = $fecha;
    }

    public function getImagen(): string{
        return $this->imagen;
    }

    public function setImagen(string $imagen){
        $this->imagen = $imagen;
    }

    public function getAll() {
        $productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC;");
        return $productos;
    }

    public function getOne() {
        $producto = $this->db->prepare("SELECT * FROM productos WHERE id = :id");

        $producto->bindParam(':id', $id, PDO::PARAM_STR);
        $id = $this->getId();

    
        try {
            $producto->execute();
            return $producto->fetch(PDO::FETCH_OBJ);
        } 
        catch(PDOException $e) {
            return false;

        }
    }

    public function getAllCategory() {
        $productos = $this->db->prepare("SELECT * FROM productos WHERE categoria_id = :categoria_id");

        $productos->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
        $categoria_id = $this->getCategoria_id();

        try {
            $productos->execute();
            return $productos;
        } 
        catch(PDOException $e) {
            return false;

        }

       


        
    }


    public static function obtenerProductos() {
        $producto = new Producto();

        $productos = $producto->db->query("SELECT * FROM productos ORDER BY id DESC;");
        return $productos;

    }

    public function validar() {
        $nombre = $this->getNombre();  

        if (!preg_match("/^[A-Z]{1}[a-z0-9A-Z áéúíó ñ]{2,30}$/", $nombre))
            self::$errores[] = 'Nombre del producto no válido: El nombre debe empezar por mayúscula y debe estar compuesto por números o letras';
        
        return self::$errores;
    }

    public function guardar($nombre,$precio,$stock,$categoria_id,$descripcion,$imagen,$fecha): bool {
        $ins = $this->db->prepare("INSERT INTO productos(id,categoria_id,nombre,descripcion,precio,stock,fecha,imagen) VALUES  (:id,:categoria_id,:nombre,:descripcion,:precio,:stock,:fecha,:imagen)");

        $ins->bindParam(':id', $id);
        $ins->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
        $ins->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $ins->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $ins->bindParam(':precio', $precio, PDO::PARAM_STR);
        $ins->bindParam(':stock', $stock, PDO::PARAM_STR);
        $ins->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $ins->bindParam(':imagen', $imagen, PDO::PARAM_STR);

        $id = NULL;

        try {
            $ins->execute();
            $result = true;
        } 
        catch(PDOException $e) {
            $result = false;

        }

        return $result;

    }

    public function stock($id) {
        $stock = $this->db->prepare("SELECT stock FROM productos WHERE id = :id");

        $stock->bindParam(':id', $id, PDO::PARAM_STR);

    
        try {
            $stock->execute();
            return $stock->fetch(PDO::FETCH_ASSOC);
        } 
        catch(PDOException $e) {
            return false;

        }
    }

    public function actualizarStock($unidadespedido) {
        $id = $this->getId();

        $unidades_stock = $this->stock($id);
        $upd = $this->db->prepare("UPDATE productos SET stock = :unidades WHERE id = :id");

        $upd->bindParam(':id', $id);
        $upd->bindParam(':unidades', $unidades, PDO::PARAM_STR);

        $unidades = $unidades_stock["stock"] - $unidadespedido;

        try {
            $upd->execute();
            return true;
        } 
        catch(PDOException $e) {
            return false;

        }
    }

    public function borrarProducto() {
        $del = $this->db->prepare("DELETE FROM productos WHERE id = :id;");

        $del->bindParam(':id', $id);

        $id = $this->getId();

        try {
            $del->execute();
            $result = true;
        } 
        catch(PDOException $e) {
            $result = false;

        }
        return $result;
    }

}

?>
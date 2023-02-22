<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;


class Categoria {

    private string $id;
    private string $nombre;

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

    public function getNombre(): string{
        return $this->nombre;
    }

    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }

    public function getAll() {
        $categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;
    }

    public static function obtenerCategorias() {
        $categoria = new Categoria();

        $categorias = $categoria->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;

    }

    public function getOne() {
        
        $cat = $this->db->prepare("SELECT * FROM categorias WHERE id = :id");

        $cat->bindParam(':id', $id);
        $id = $this->getId();
        
        return $cat->fetch();
    }

    public function validar() {
        $nombre = $this->getNombre();

        if (!preg_match("/^[A-Z]{1}[A-Za-z áéúíó ñ]{2,30}$/", $nombre))
            self::$errores[] = 'Nombre de categoría no válido: El nombre debe empezar por mayúscula y debe estar compuesto por letras';
        
        return self::$errores;
    }

    public function guardarCategoria($nombre): bool {
        $ins = $this->db->prepare("INSERT INTO categorias(id,nombre) VALUES  (:id,:nombre)");

        $ins->bindParam(':id', $id);
        $ins->bindParam(':nombre', $nombre, PDO::PARAM_STR);

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

    public function actualizarCategoria() {
        $upd = $this->db->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id;");

        $upd->bindParam(':id', $id);
        $upd->bindParam(':nombre', $nombre, PDO::PARAM_STR);

        $id = $this->getId();
        $nombre = $this->getNombre();

        try {
            $upd->execute();
            $result = true;
        } 
        catch(PDOException $e) {
            $result = false;

        }

        return $result;

    }

    public function borrarCategoria() {
        $del = $this->db->prepare("DELETE FROM categorias WHERE id = :id;");

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
<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;

class Usuario {
    private string $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $password;
    private string $rol;
    

    private BaseDatos $db;
    protected static $errores = [];

    public function __construct(string $id, string $nombre,string $apellidos,string $email,string $password,string $rol)
    {
        $this->db = new BaseDatos();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
        
    
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

    public function getApellidos(): string{
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos){
        $this->apellidos = $apellidos;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function setPassword(string $password){
        $this->password = $password;
    }

    public function getRol(): string{
        return $this->rol;
    }

    public function setRol(string $rol){
        $this->rol = $rol;
    }

    public static function fromArray(array $data): Usuario {
        return new Usuario(
            $data['id'] ?? '',
            $data['nombre'] ?? '',
            $data['apellidos'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['rol'] ?? '',
        );
    }


    public function existeEmail(): bool|object {
        $result = false;

        // Comprobar si existe el usuario
        $cons = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $cons->bindParam(':email', $email,PDO::PARAM_STR);
        
        $email = $this->getEmail();

        try{
            $cons->execute();
            if($cons && $cons->rowCount() == 1) {
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        } 
        catch(PDOException $e) {
            $result = false;
        }
        return $result;
    }

    public function validar() {
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $email = $this->getEmail();
        $password = $this->getPassword();
        
        
        

        if (!preg_match("/^(?=.{3,15}$)[A-Z??????????][a-z????????????]+(?: [A-Z??????????][a-z????????????]+)?$/", $nombre))
            self::$errores[] = 'Nombre no v??lido: Aseg??rate que la primera letra de cada nombre es May??scula';

        if (!preg_match("/^(?=.{3,15}$)[A-Z??????????][a-z????????????]+(?: [A-Z??????????][a-z????????????]+)?$/", $apellidos))
            self::$errores[] = 'Apellidos no v??lidos: Aseg??rate que la primera letra de cada apellido es May??scula';
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            self::$errores[] = 'Email no v??lido';

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,20}$/', $password))
            self::$errores[] = 'Contrase??a no valida: debe contener m??s de 6 caracteres, una letra min??scula, una letra may??scula y un n??mero';

        
        return self::$errores;
    }

    

    public function registrar(): bool{
        $ins = $this->db->prepare("INSERT INTO usuarios(id,nombre,apellidos,email,password,rol) VALUES  (:id,:nombre, :apellidos, :email, :password, :rol)");

        $ins->bindParam(':id', $id);
        $ins->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $ins->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $ins->bindParam(':email', $email, PDO::PARAM_STR);
        $ins->bindParam(':password', $password, PDO::PARAM_STR);
        $ins->bindParam(':rol', $rol, PDO::PARAM_STR);


        $id = NULL;
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $email = $this->getEmail();
        $pass = $this->getPassword();
        $password = password_hash($pass, PASSWORD_BCRYPT, ['cost' =>4]);
        $rol = 'user';

        try {
            $ins->execute();
            $result = true;
        } 
        catch(PDOException $e) {
            $result = false;

        }

        return $result;
    }

    public function iniciarsesion(): bool|object {
        $result = false;
        $password = $this->password;

        // Comprobar si existe el usuario

        $usuario = $this->existeEmail();

        if($usuario !== false){

            $verify = password_verify($password, $usuario->password);

            if($verify) {
                $result = $usuario;
            }
        }
        return $result;
    }

}

?>
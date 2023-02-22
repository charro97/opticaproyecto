<?php

namespace Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

use Lib\BaseDatos;
use Models\LineaPedido;
use PDO;
use PDOException;


//Load Composer's autoloader
require '../vendor/autoload.php';

class Pedido
{

    private string $id;
    private string $usuario_id;
    private string $provincia;
    private string $localidad;
    private string $direccion;
    private string $coste;
    private string $estado;
    private string $fecha;

    private BaseDatos $db;

    public function __construct()
    {
        $this->db = new BaseDatos();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getUsuario_id(): string
    {
        return $this->usuario_id;
    }

    public function setUsuario_id(string $usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    public function getProvincia(): string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia)
    {
        $this->provincia = $provincia;
    }

    public function getLocalidad(): string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad)
    {
        $this->localidad = $localidad;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion)
    {
        $this->direccion = $direccion;
    }

    public function getCoste(): string
    {
        return $this->coste;
    }

    public function setCoste(string $coste)
    {
        $this->coste = $coste;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado)
    {
        $this->estado = $estado;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha)
    {
        $this->fecha = $fecha;
    }

    public function getMisPedidos() {

        $pedidos = $this->db->prepare("SELECT * FROM pedidos WHERE usuario_id = :usuario_id");

        $pedidos->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);
        $usuario_id = $this->getUsuario_id();
    
        try {
            $pedidos->execute();
            return $pedidos;
        } 
        catch(PDOException $e) {
            return false;

        }
    }


    public function doPedido()
    {   
        $this->db->beginTransaction();
        $ins = $this->db->prepare("INSERT INTO pedidos (id,usuario_id,provincia,localidad,direccion,coste,estado,fecha) VALUES  (:id,:usuario_id,:provincia,:localidad,:direccion,:coste,:estado,:fecha)");

        $ins->bindParam(':id', $id);
        $ins->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);
        $ins->bindParam(':provincia', $provincia, PDO::PARAM_STR);
        $ins->bindParam(':localidad', $localidad, PDO::PARAM_STR);
        $ins->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $ins->bindParam(':coste', $coste, PDO::PARAM_STR);
        $ins->bindParam(':estado', $estado, PDO::PARAM_STR);
        $ins->bindParam(':fecha', $fecha, PDO::PARAM_STR);

        $id = NULL;
        $usuario_id = $this->getUsuario_id();
        $provincia = $this->getProvincia();
        $localidad = $this->getLocalidad();
        $direccion = $this->getDireccion();
        $coste = $this->getCoste();
        $estado = $this->getEstado();
        $fecha = $this->getFecha();

        try {
            $ins->execute();
            $ped_id = $this->db->lastInsertId();

            

            foreach($_SESSION['carrito'] as $indice => $elemento){
                $lin = $this->db->prepare("INSERT INTO lineas_pedidos (id,pedido_id,producto_id,unidades) VALUES  (:id,:pedido_id,:producto_id,:unidades)");

                $lin->bindParam(':id', $id);
                $lin->bindParam(':pedido_id', $pedido_id, PDO::PARAM_STR);
                $lin->bindParam(':producto_id', $producto_id, PDO::PARAM_STR);
                $lin->bindParam(':unidades', $unidades, PDO::PARAM_STR);

                $id = NULL;
                $pedido_id= $ped_id;
                $producto_id = $elemento['producto']->id;
                $unidades = $elemento['unidades'];

                $lin->execute();
                
            }
            $this->db->commit();
            $result = true;
         
        } catch (PDOException $e) {
            echo "Error al hacer pedido";
            $this->db->rollback();
            $result = false;
        }
        
        return $result;
    }

    public function enviarCorreo($nombre, $apellidos, $importe)
    {


        //Create a new PHPMailer instance
        $mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Set the hostname of the mail server
        $mail->Host = 'sandbox.smtp.mailtrap.io';

        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = $_ENV['username'];
        $mail->Password = $_ENV['password'];
        

        

        //Set who the message is to be sent from
        $mail->setFrom('dedirey924@gmail.com', 'Óptica Buenavista');

        //Set who the message is to be sent to
        $mail->addAddress('dedirey924@gmail.com', $nombre);

        $mail->Subject = 'Pedido confirmado';

        // Ponemos el HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        //Body
        $mail->Body = "Nombre cliente: {$nombre} {$apellidos}"."<br>";
        $mail->Body .= "Productos:"."<br>";
        if(isset($_SESSION['carrito'])) {
            foreach($_SESSION['carrito'] as $indice => $elemento) {
                $nom_producto = $elemento['producto']->nombre;
                $unidades = $elemento['unidades'];

                $mail->Body .= "{$nom_producto}, {$unidades} unidades"."<br>";
            }
        } 
        $mail->Body .= "Importe total: {$importe}$";



        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Pedido realizado correctamente';
        }
    }
}
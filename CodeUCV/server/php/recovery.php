<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require_once ('conexion_be.php');

$correo = $_POST['correo'];

$query = "SELECT * FROM usuarios WHERE correo='$correo' AND activo=1";
$result = $conexion->query($query);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp-mail.outlook.com";
        $mail->SMTPAuth = true;
        $mail->Username = 'kvarillasgu@outlook.com';
        $mail->Password = 'Kevinvarillas20@';
        $mail->Port = 587;

        $mail->setFrom('kvarillasgu@outlook.com', 'CodeUCV');
        $mail->addAddress('analucia.luisac@gmail.com', 'clara');
        $mail->isHTML(true);
        $mail->Subject = 'Recuperacion de clave';
        $mail->Body    = 'Hola, este es un correo generado para solicitar tu recuperación de contraseña, por favor, visita la página de <a href="localhost/Proyecto/cambiocontraseña/change_password.php?id='.$row['id'].'">Recuperación de contraseña</a>';

        $mail->send();
        header("Location: ../../client/iniciosesion/iniciosesion.php?message=ok");
    } catch (Exception $e) {
      header("Location: ../../client/iniciosesion/iniciosesion.php?message=error");
    }
    
    }else{
      header("Location: ../../client/iniciosesion/iniciosesion.php?message=not_found");
    }


?>
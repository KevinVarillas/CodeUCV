<?php 
require_once('conexion_be.php');
$id = $_POST['id'];
$contra = $_POST['new_password'];

$query = "UPDATE usuarios set contrasena= '$contra' WHERE id= $id";
$conexion->query($query);

header("Location: ../../client/iniciosesion/iniciosesion.php?message=success_password");

?>
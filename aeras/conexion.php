<?php
$host = "localhost"; 
$usuario = "admin";   
$contraseña = "SolCuarzo12";    
$base_de_datos = "air_scan"; 
$conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>

<?php

include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if (empty($nombre) || empty($correo) || empty($password)) {
        echo "Todos los campos son obligatorios.";
    } else {

        $password_encrypted = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (NOMBRE, CORREO, PASS) VALUES ('$nombre', '$correo', '$password_encrypted')";

        if ($conexion->query($sql) === TRUE) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Error al registrar usuario: " . $conexion->error;
        }
    }
}

$conexion->close();
?>

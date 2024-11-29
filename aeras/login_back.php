<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password']; 
    if (empty($correo) || empty($password)) {
        echo "Correo y contraseña son obligatorios.";
    } else {
        $sql = "SELECT * FROM usuario WHERE CORREO = '$correo'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($password, $usuario['PASS'])) {
                session_start();
                $_SESSION['usuario_id'] = $usuario['ID_USUARIO'];
                $_SESSION['nombre'] = $usuario['NOMBRE'];
                
                header("Location: index.php");
                exit();
            } else {
                echo "Correo o contraseña incorrectos.";
            }
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    }
}

$conexion->close();
?>

<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dispositivo_id = $_POST['dispositivo_id'];
    $co2_ppm = $_POST['co2_ppm'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO lecturas_calidad_aire (dispositivo_id, co2_ppm, estado) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sis", $dispositivo_id, $co2_ppm, $estado);

    if ($stmt->execute()) {
        echo "Datos guardados correctamente";
    } else {
        echo "Error al guardar los datos: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Método no permitido";
}
?>



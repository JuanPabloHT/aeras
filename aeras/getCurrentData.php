<?php
include 'conexion.php';

$sql = "SELECT dispositivo_id, co2_ppm, estado, timestamp FROM lecturas_calidad_aire ORDER BY timestamp DESC LIMIT 1";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        'co2' => $row['co2_ppm'],  // Asegúrate de que este campo se llama correctamente
        'estado' => $row['estado'],
        'timestamp' => $row['timestamp']
    ]);
} else {
    echo json_encode(['error' => 'No hay datos disponibles']);
}

$conexion->close();
?>


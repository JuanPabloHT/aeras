<?php
include 'conexion.php';

$sql = "SELECT dispositivo_id, co2_ppm, estado, timestamp FROM lecturas_calidad_aire ORDER BY timestamp DESC LIMIT 5"; // Obtén los últimos 5 registros
$result = $conexion->query($sql);

$history = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $history[] = [
            'dispositivo_id' => $row['dispositivo_id'],
            'co2' => $row['co2_ppm'],
            'estado' => $row['estado'],
            'timestamp' => $row['timestamp']
        ];
    }
    echo json_encode($history); // Envía el historial como JSON
} else {
    echo json_encode(['error' => 'No hay datos disponibles']);
}

$conexion->close();
?>

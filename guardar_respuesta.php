<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "juego";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(" Conexión fallida: " . $conn->connect_error);
}
$letra = $_POST['letra'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$animal = $_POST['animal'] ?? '';
$color = $_POST['color'] ?? '';
$cosa = $_POST['cosa'] ?? '';
$flor = $_POST['flor'] ?? '';
$tiempo = $_POST['tiempo'] ?? 0;
$sala = 1;
$id_usuario = 1;

$sql = "INSERT INTO respuestas 
(letra, apellido, ciudad, animal, color, cosa, flor, tiempo, sala, id_usuario)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(" Error en prepare(): " . $conn->error);
}

$stmt->bind_param("sssssssiii",
    $letra, $apellido, $ciudad, $animal, $color, $cosa, $flor, $tiempo, $sala, $id_usuario
);

if ($stmt->execute()) {
    echo " Respuesta guardada correctamente.";
} else {
    echo " Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<?php 
session_start();
include_once("db_juego.php"); // usa include_once para evitar múltiples inclusiones

// Evita redefinir la función si ya está declarada
if (!function_exists('guardar_usuario')) {
    function guardar_usuario($nombre, $nombre_usuario, $email, $clave) {
        $conexion = conectar();

        // Encriptar la clave
        $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

        // Consulta preparada con placeholders
        $stmt = $conexion->prepare("INSERT INTO registro (nombre, nombre_usuario, email, clave) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param("ssss", $nombre, $nombre_usuario, $email, $clave_hash);

        if (!$stmt->execute()) {
            die("Error al guardar usuario: " . $stmt->error);
        }

        $stmt->close();
    }
}

// Obtener datos del formulario
$nombre = $_POST['nombre'] ?? '';
$nombre_usuario = $_POST['nombre_usuario'] ?? '';
$email = $_POST['email'] ?? '';
$clave = $_POST['clave'] ?? '';

// Validar que los campos no estén vacíos
if (empty($nombre) || empty($nombre_usuario) || empty($email) || empty($clave)) {
    die("Por favor, completa todos los campos.");
}

// Guardar usuario en la base de datos
guardar_usuario($nombre, $nombre_usuario, $email, $clave);

// Guardar datos en sesión
$_SESSION['nombre'] = $nombre;
$_SESSION['nombre_usuario'] = $nombre_usuario;
$_SESSION['email'] = $email;

// Redirigir al usuario a la página de salas
header("Location: salas.php");
exit;
?>

<?php
function conectar() {
    $conexion = mysqli_connect("localhost", "root", "", "juego");
    if (!$conexion) {
        die("Error al conectar: " . mysqli_connect_error());
    }
    return $conexion;
}

function busca_sesion($email, $clave) {
    $conexion = conectar();


    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verifica la contraseña cifrada
        if (password_verify($clave, $usuario['clave'])) {
            return $usuario;
        }
    }

    return false;
}
?>
 <?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "juego";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

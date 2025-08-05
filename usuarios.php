<?php
session_start();
include("db_juego.php");
$email = $_POST['email'];
$clave = $_POST['clave'];
es
$usuario = busca_secion($email, $clave);

if ($usuario) {
    // Guardamos los datos en sesión
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
    $_SESSION['email'] = $usuario['email'];

    echo '
        <script>
            alert("Bienvenido ' . $usuario['nombre'] . '");
            window.location = "juego.html";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Correo o contraseña incorrectos");
            window.location = "registro.html";
        </script>
    ';
}
?>
>

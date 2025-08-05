<?php
session_start();

// Datos de sesión
$nombre = $_SESSION['nombre'];
$usuario = $_SESSION['nombre_usuario'];
$email = $_SESSION['email'];

require_once 'db_juego.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="style.css" />
  <title>Bienvenido</title>
<style>
   body {
      background: linear-gradient(to right, #fed6e3, #a8edea);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    main {
      background: #ffffff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
      max-width: 500px;
      width: 90%;
      text-align: center;
      margin: 40px 0;
    }

    h1 {
      color: #333;
      font-size: 28px;
      margin-bottom: 15px;
    }

    p {
      color: #555;
      font-size: 16px;
      margin-bottom: 25px;
    }

    label {
      display: block;
      text-align: left;
      margin-bottom: 8px;
      font-weight: bold;
      color: #444;
    }

    select {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      border: 2px solid #6c9cbf;
      border-radius: 8px;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background: #a8c9e7;
      color: #fff;
      padding: 12px 30px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn:hover {
      background: #ff4f4f;
      transform: translateY(-2px);
    }

    #mensaje-espera {
      margin-top: 20px;
      font-size: 16px;
      color: #333;
      display: none;
    }

    footer {
      width: 100%;
      background: #c6afe6; /* Lila */
      text-align: center;
      padding: 15px 0;
      margin-top: auto;
      color: #333;
      font-size: 14px;
      box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    }
</style>
</head>
<body>
  <main>
    <h1>¡Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h1>
    <p>Tu nombre de usuario es <strong><?php echo htmlspecialchars($usuario); ?></strong> y tu correo es <strong><?php echo htmlspecialchars($email); ?></strong>.</p>

    <label for="selector-sala">Elige una sala de juego:</label>
    <select id="selector-sala" class="selector-sala">
      <option value="sala1">Sala 1</option>
      <option value="sala2">Sala 2</option>
      <option value="sala3">Sala 3</option>
    </select>
    <label for="sala-dinamica">O selecciona una sala disponible:</label>
    <select id="sala-dinamica" name="sala">
      <?php
        $sql = "SELECT * FROM salas";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row['id_sala']) . "'>Sala " . htmlspecialchars($row['id_sala']) . " - Letra: " . htmlspecialchars($row['letra']) . "</option>";
          }
        } else {
          echo "<option>No hay salas disponibles</option>";
        }

        $conn->close();
      ?>
    </select>

    <button class="btn" onclick="esperarJugadores()">Ir a la partida</button>

    <div id="mensaje-espera"></div>
  </main>

  <footer>
    <p>&copy; 2025 Mi Página Web. Todos los derechos reservados.</p>
  </footer>

  <script>
    function esperarJugadores() {
      const selectorDinamico = document.getElementById('sala-dinamica');
      const salaSeleccionada = selectorDinamico.value;
      const mensaje = document.getElementById('mensaje-espera');

      let segundos = 10; // segundos de espera
      mensaje.style.display = 'block';
      mensaje.textContent = `Esperando que se unan más jugadores... ${segundos} segundos`;

      const intervalo = setInterval(() => {
        segundos--;
        mensaje.textContent = `Esperando que se unan más jugadores... ${segundos} segundos`;

        if (segundos <= 0) {
          clearInterval(intervalo);
          window.location.href = `partida.html?sala=${encodeURIComponent(salaSeleccionada)}`;
        }
      }, 1000);
    }
  </script>
</body>
</html>

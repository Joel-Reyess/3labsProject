<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylemenu.css">
  <title>Prestamo e Inventario</title>
  <script>
    window.onload = function() {
      <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        alert("Usuario o contraseña incorrectos. Inténtalo de nuevo.");
      <?php endif; ?>
    }
  </script>
</head>

<body>
  <header>
    <div class="container">
      <div class="logo">
        <a href="index.html"><img src="imagenes/uttn_logo.jpg" alt="Logo"></a>
      </div>
    </div>
  </header>

  <!-- cuerpo -->
  <div class="body-section">
    <div class="login-card">
      <form action="validate.php" method="post">
        <h1 class="titulo-form">Inicio de sesión</h1>

        <p class="login-p">Usuario</p>
        <input type="text" class="input-log" name="usuario" required>
        <p class="login-p">Contraseña</p>
        <input type="password" class="input-log" name="contraseña" required>
        <button type="submit" class="login-button">Iniciar sesión</button>
      </form>
    </div>
  </div>

</body>

</html>
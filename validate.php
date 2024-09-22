<?php
session_start();

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "proyect");

// Comprobar conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta SQL segura utilizando consultas preparadas
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE Matricula = ? AND Contraseña = ?");
$stmt->bind_param("ss", $usuario, $contraseña);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si hay resultados
if ($filas = $resultado->fetch_assoc()) {
    // Si se encuentra un usuario, redirigir según el RolID
    switch ($filas['RolID']) {
        case 1:
            header("Location: IndexA1.php");
            break;
        case 2:
            header("Location: IndexA2.php");
            break;
        case 3:
            header("Location: IndexNave.php");
            break;
        case 4:
            header("Location: IndexA.php");
            break;
    }
} else {
    // Si no se encuentra el usuario, redirigir a index.php con un parámetro de error
    header("Location: index.php?error=1"); // Usar un código de error
}

// Cerrar la conexión
$stmt->close();
mysqli_close($conexion);
exit(); // Asegúrate de incluir esto al final
?>

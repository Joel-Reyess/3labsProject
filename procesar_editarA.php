<?php
include('connection.php');

$matricula = mysqli_real_escape_string($conn, $_POST['txtMatricula']);
$nombre = mysqli_real_escape_string($conn, $_POST['txtNombre']);
$ApellidoP = mysqli_real_escape_string($conn, $_POST['txtApellidoP']);
$ApellidoM = mysqli_real_escape_string($conn, $_POST['txtApellidoM']);
$Correo = mysqli_real_escape_string($conn, $_POST['txtCorreo']);
$Grado = mysqli_real_escape_string($conn, $_POST['txtGrado']);
$Grupo = mysqli_real_escape_string($conn, $_POST['txtGrupo']);
$Carrera = mysqli_real_escape_string($conn, $_POST['txtCarrera']); // Cambiado de txtCarrera a txtRol

// Ejecutar la consulta de actualización
$resultado = mysqli_query($conn, "UPDATE estudiantes SET Nombre='$nombre', ApellidoP='$ApellidoP', ApellidoM='$ApellidoM', Correo='$Correo', Grado='$Grado', Grupo='$Grupo', CarreraID='$Carrera' WHERE Matricula='$matricula'");

// Verificar si se ejecutó correctamente
if (!$resultado) {
    die("Error al actualizar: " . mysqli_error($conn));
}

// Cerrar conexión
mysqli_close($conn);

// Redirigir con mensaje de éxito
header("Location: Alumnos.php?status=success");
exit();
?>
